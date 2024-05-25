<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;


Route::post('/webhook/receive', [WebhookController::class, 'receive']);
Route::post('/webhook/send', [WebhookController::class, 'send']);