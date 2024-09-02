<?php

use Illuminate\Support\Facades\Schedule;
use App\Http\Services\ExchangeRateService;

Schedule::call(function () {
    app(ExchangeRateService::class)->fetchAndStoreRates();
})->everyMinute();
