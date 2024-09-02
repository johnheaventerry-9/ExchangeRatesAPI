<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;


Route::get('exchange-rates/{date}', [ExchangeRateController::class, 'getRatesByDate']);
