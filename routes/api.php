<?php
use App\Http\Controllers\WebhookController;

Route::post('/webhook/receive', [WebhookController::class, 'receive']);
Route::post('/webhook/send', [WebhookController::class, 'send']);
