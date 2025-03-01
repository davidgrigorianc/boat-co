<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BoatController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/boats', [BoatController::class, 'index']);
Route::get('/boats/{id}', [BoatController::class, 'show']);
Route::get('/manufacturers', [BoatController::class, 'getManufacturers']);
Route::get('/boat-models', [BoatController::class, 'getBoatModels']);
Route::post('/payment-checkout', [PaymentController::class, 'createCheckoutSession']);
Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);
