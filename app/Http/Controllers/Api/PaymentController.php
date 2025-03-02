<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCheckoutSessionRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use App\Models\Payment;
use App\Models\Boat;

class PaymentController extends Controller
{
    public function createCheckoutSession(CreateCheckoutSessionRequest $request): \Illuminate\Http\JsonResponse
    {
        $boat = Boat::findOrFail($request->boat_id);
        $boatName = "{$boat->year} {$boat->boat_model?->manufacturer?->name} {$boat->boat_model->name}";

        Stripe::setApiKey(config('app_config.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $boatName,
                    ],
                    'unit_amount' => $boat->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => config('app_config.app_url') . '/success?session_id={CHECKOUT_SESSION_ID}&boat_name=' . urlencode($boatName) . '&amount=' . urlencode($boat->price),
            'cancel_url' => config('app_config.app_url') . '/boats/' . $boat->id,
            'metadata' => [
                'boat_id' => $boat->id,
                'amount' => $boat->price,
            ],
        ]);
        Log::debug('session',[
            'session_id' => $session->id,
        ]);

        $payment = Payment::create([
            'boat_id' => $boat->id,
            'amount' => $boat->price,
            'status' => 'pending',
            'payment_system' => 'stripe',
            'transaction_id' => $session->id,
        ]);

        return response()->json([
            'url' => $session->url,
            'payment_id' => $payment->id,
        ]);
    }

    public function handleWebhook(Request $request)
    {
        Log::debug('Stripe Webhook Received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
        ]);

        $endpointSecret = config('app_config.stripe.webhook_key');
        $signatureHeader = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        if (!$signatureHeader || !$payload) {
            Log::error('Stripe Webhook: Missing signature or payload.');
            return response()->json(['error' => 'Invalid request'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $signatureHeader, $endpointSecret);
        } catch (\Exception $e) {
            Log::error("Stripe Webhook: Signature verification failed - " . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            default:
                Log::info("Unhandled event type: {$event->type}");
        }

        return response()->json(['status' => 'success']);
    }

    private function handleCheckoutSessionCompleted($session): void
    {
        Log::info("Processing checkout.session.completed", ['session_id' => $session->id]);

        $payment = Payment::where('transaction_id', $session->id)->first();
        if (!$payment) {
            Log::warning("Payment record not found for session: {$session->id}");
            return;
        }

        $payment->update(['status' => 'paid']);

        $boat = Boat::find($payment->boat_id);
        if ($boat) {
            $boat->update(['status' => 'sold']);
            Log::info("Boat ID {$payment->boat_id} marked as sold.");
        } else {
            Log::warning("Boat ID {$payment->boat_id} not found.");
        }
    }

    private function handlePaymentIntentSucceeded($paymentIntent): void
    {
        Log::info("Processing payment_intent.succeeded", ['intent_id' => $paymentIntent->id]);

        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();
        if (!$payment) {
            Log::warning("Payment record not found for intent: {$paymentIntent->id}");
            return;
        }

        $payment->update(['status' => 'paid']);
        Log::info("Payment {$payment->id} marked as paid.");
    }
}
