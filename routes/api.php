<?php
use Illuminate\Http\Request; use Illuminate\Support\Facades\Route;
Route::middleware('auth')->get('/me', fn(Request $request)=>$request->user()->load('profile'));
Route::get('/health',fn()=>['ok'=>true,'app'=>'GeeGig']);

Route::post('/payments/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payments.webhook');
