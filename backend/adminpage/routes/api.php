<?php

use Illuminate\Support\Facades\Route;
use App\Models\EventModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;



Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from API']);
});

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});
