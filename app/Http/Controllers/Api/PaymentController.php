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
    public function createCheckoutSession(CreateCheckoutSessionRequest $request)
    {
        $boat = Boat::findOrFail($request->boat_id);
        $boatName = "{$boat->year} {$boat->boat_model?->manufacturer?->name} {$boat->boat_model->name}";

        Stripe::setApiKey(env('STRIPE_SECRET'));

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
            'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}&boat_name=' . urlencode($boatName) . '&amount=' . urlencode($boat->price),
            'cancel_url' => env('APP_URL') . '/boats/' . $boat->id,
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
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $sig_header = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            Log::error("Stripe Webhook Error: " . $e->getMessage());
            return response()->json(['error' => 'Invalid webhook signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $payment = Payment::where('transaction_id', $session->id)->first();

            if ($payment) {
                $payment->update(['status' => 'paid']);

                Boat::where('id', $payment->boat_id)->update(['status' => 'sold']);

                Log::info("Payment successful. Boat ID {$payment->boat_id} marked as sold.");
            }
        }

        return response()->json(['status' => 'success']);
    }
}
