<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FarmOrderModel;
use App\Http\Controllers\Controller;
use App\Services\PaymongoService;


class FarmOrderController extends Controller
{       
 public function createPaymentLink(Request $request)
    {
        Log::info('Incoming request:', $request->all());

        $refNumber = uniqid('REF-');

        // Convert cart into orderData
        $orderData = [
            'bangus_order' => 0,
            'eggs_order' => 0,
            'mudCrab_order' => 0,
            'nativeChicken_order' => 0,
            'nativePork_order' => 0,
            'squash_order' => 0,
            'total_bill' => 0,
            'payment_method' => 'GCash',
            'order_status' => 'Pending',
            'ref_number' => $refNumber,
        ];

        foreach ($request->cart as $item) {
            switch ($item['name']) {
                case 'Bangus': $orderData['bangus_order'] = $item['qty']; break;
                case 'Egg': $orderData['eggs_order'] = $item['qty']; break;
                case 'Mud Crab': $orderData['mudCrab_order'] = $item['qty']; break;
                case 'Native Chicken': $orderData['nativeChicken_order'] = $item['qty']; break;
                case 'Native Pork': $orderData['nativePork_order'] = $item['qty']; break;
                case 'Squash': $orderData['squash_order'] = $item['qty']; break;
            }

            $orderData['total_bill'] += $item['price'] * $item['qty'];
        }

        // Save temporary order in session (not DB yet)
        session([
            'orderData' => $orderData,
            'refNumber' => $refNumber
        ]);

        // Call PayMongo API
        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/links', [
                'data' => [
                    'attributes' => [
                        'amount' => intval($orderData['total_bill'] * 100), // centavos
                        'description' => "Farm Order Ref: $refNumber",
                        'remarks' => $refNumber,
                        'currency' => 'PHP',
                        'redirect' => [
                            'success' => route('farmOrders.paymentSuccess'),
                            'failed' => route('farmOrders.paymentFailed'),
                        ]
                    ]
                ]
            ]);

        $checkoutUrl = $response->json()['data']['attributes']['checkout_url'] ?? null;

        return response()->json([
    'payment_url' => $checkoutUrl
]);
    }

    public function paymentSuccess(Request $request)
    {
        $refNumber = $request->query('remarks');
        $orderData = session('orderData');

        if (!$orderData || !$refNumber || $refNumber !== session('refNumber')) {
            return redirect('/pages/paymentFailed.html');
        }

        // Save order to DB
        FarmOrderModel::create($orderData);

        // Clear session
        session()->forget(['orderData', 'refNumber']);

        return redirect('/pages/paymentSuccess.html');
    }

    // Step 2b: If payment fails
    public function paymentFailed()
    {
        return view('payment-failed');
    }
}
