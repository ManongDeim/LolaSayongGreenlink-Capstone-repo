<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FarmOrderModel;
use App\Http\Controllers\Controller;

class FarmOrderController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Incoming request:', $request->all());

        // Initialize all product columns to 0
        $orderData = [
            'bangus_order' => 0,
            'eggs_order' => 0,
            'mudCrab_order' => 0,
            'nativeChicken_order' => 0,
            'nativePork_order' => 0,
            'squash_order' => 0,
            'total_bill' => 0,
            'payment_method' => $request->payment_method,
            'order_status' => 'Pending',
        ];

        // Loop through cart items
        foreach ($request->cart as $item) {
            switch ($item['name']) {
                case 'Bangus':
                    $orderData['bangus_order'] = $item['qty'];
                    break;
                case 'Egg':
                    $orderData['eggs_order'] = $item['qty'];
                    break;
                case 'Mud Crab':
                    $orderData['mudCrab_order'] = $item['qty'];
                    break;
                case 'Native Chicken':
                    $orderData['nativeChicken_order'] = $item['qty'];
                    break;
                case 'Native Pork':
                    $orderData['nativePork_order'] = $item['qty'];
                    break;
                case 'Squash':
                    $orderData['squash_order'] = $item['qty'];
                    break;
            }

            // Add to total bill
            $orderData['total_bill'] += $item['price'] * $item['qty'];
        }

        // Save to DB
        FarmOrderModel::create($orderData);

        return response()->json(['message' => 'Order saved successfully!']);
    }
}
