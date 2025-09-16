<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FarmOrderController;
use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\Api\EventAdminReservationController;
use App\Models\EventAdminModel;

Route::post('cottageReservation', [RoomController::class, 'store']);

Route::post('eventReservation', [EventController::class, 'store']);

use App\Http\Controllers\FarmOrdersController;

Route::post('farmOrder/create-link', [FarmOrderController::class, 'createPaymentLink'])->name('farmOrders.createLink');
Route::get('farmOrder/payment-success', [FarmOrderController::class, 'paymentSuccess'])->name('farmOrders.paymentSuccess');
Route::get('farmOrder/payment-failed', [FarmOrderController::class, 'paymentFailed'])->name('farmOrders.paymentFailed');


Route::post('foodOrder', [FoodOrderController::class, 'store']);


// Admin Routes

Route::get('/reservations/latest', function () {
    Log::info("API request: Fetch latest reservation");

    $reservation = EventAdminModel::latest('id')->first();

    if (!$reservation) {
        Log::warning("No reservations found in database");
        return response()->json(['error' => 'No reservations found'], 404);
    }

    Log::debug("Latest reservation data", $reservation->toArray());

    return response()->json($reservation);
});

Route::patch('/reservations/{id}/approval', [EventAdminReservationController::class, 'updateApproval']);