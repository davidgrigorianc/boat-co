<?php
namespace Tests\Feature;

use App\Models\Boat;
use App\Models\BoatModel;
use App\Models\Manufacturer;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the creation of a checkout session with Stripe.
     *
     * @return void
     */
    public function testCreateCheckoutSession()
    {
        $manufacturer = Manufacturer::factory()->create();
        $boatModel = BoatModel::factory()->create([
            'manufacturer_id' => $manufacturer->id,
        ]);

        $boat = Boat::factory()->create([
            'price' => 50000,
            'year' => 2020,
            'boat_model_id' => $boatModel->id,
        ]);

        $stripeResponse = [
            'id' => 'stripe_session_id',
            'url' => 'https://checkout.stripe.com/pay/xyz',
        ];

        // Mock the Stripe API response
        Http::fake([
            '*' => Http::response($stripeResponse, 200),
        ]);

        // Set up the mock for Log::debug to expect exactly one call

        Log::shouldReceive('debug')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'session');
            });

        // Act: Send the request to the controller
        $response = $this->postJson('api/payment-checkout', [
            'boat_id' => $boat->id,
            'amount' => 50000,
        ]);

        // Assert: Check the response status and payment ID
        $response->assertStatus(200)
            ->assertJson([
                'payment_id' => Payment::first()->id,
            ]);

        $responseData = $response->json();
        $this->assertStringStartsWith('https://checkout.stripe.com/c/pay/', $responseData['url']);
        $this->assertStringContainsString('cs_test_', $responseData['url']);

        // Assert that the payment record is created in the database
        $this->assertDatabaseHas('payments', [
            'boat_id' => $boat->id,
            'amount' => $boat->price,
            'status' => 'pending',
            'payment_provider' => 'stripe',
        ]);

        // Retrieve the payment record from the database and assert the transaction_id starts with 'cs_test_'
        $payment = Payment::first();
        $this->assertStringStartsWith('cs_test_', $payment->transaction_id);
    }


}
