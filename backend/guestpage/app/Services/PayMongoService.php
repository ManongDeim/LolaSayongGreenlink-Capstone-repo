namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymongoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
    }

    // Create Payment Intent
    public function createPaymentIntent($amount, $currency = 'PHP')
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post('https://api.paymongo.com/v1/payment_intents', [
                'data' => [
                    'attributes' => [
                        'amount' => $amount * 100, // PayMongo expects cents
                        'payment_method_allowed' => ['gcash'],
                        'currency' => $currency,
                    ]
                ]
            ]);

        return $response->json();
    }

    // Attach Payment Method
    public function attachPaymentMethod($intentId, $paymentMethodId, $returnUrl)
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post("https://api.paymongo.com/v1/payment_intents/{$intentId}/attach", [
                'data' => [
                    'attributes' => [
                        'payment_method' => $paymentMethodId,
                        'return_url' => $returnUrl,
                    ]
                ]
            ]);

        return $response->json();
    }
}