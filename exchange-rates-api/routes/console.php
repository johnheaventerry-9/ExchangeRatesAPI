<?php

use Illuminate\Support\Facades\Schedule;
use App\Http\Services\ExchangeRateService;

Schedule::call(function () {
    app(ExchangeRateService::class)->fetchAndStoreRates();
})->daily();

$schedule->command('exchange-rates:send-report')->daily();
