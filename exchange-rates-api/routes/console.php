<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Http\Services\ExchangeRateService;

Schedule::call(function () {
    app(ExchangeRateService::class)->fetchAndStoreRates();
})->everyMinute();
