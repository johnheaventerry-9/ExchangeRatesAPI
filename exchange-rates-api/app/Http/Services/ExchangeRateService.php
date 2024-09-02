<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Log;
use App\Jobs\StoreExchangeRateJob;

class ExchangeRateService
{
    public function fetchAndStoreRates()
    {
        $response = Http::get('http://api.exchangeratesapi.io/v1/latest', [
            'access_key' => '8821a8b8456efe92aadbcfa56e491620',
            // 'base' => 'USD', // Commented out since setting USD as base is not supported
            'symbols' => 'USD,EUR,AUD,CAD,GBP,JPY,CHF,CNY,INR,MXN,ZAR' // Include USD in symbols
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['rates'])) {
            $usdRate = $data['rates']['USD']; // Get the USD rate relative to the base currency

            foreach ($data['rates'] as $currencyCode => $rate) {
                // Convert to USD if necessary
                $rateInUsd = ($currencyCode === 'USD') ? $rate : $rate / $usdRate;

                $currency = Currency::firstOrCreate(
                    ['code' => $currencyCode],
                    ['name' => $currencyCode]  // Assuming the currency code is used as the name
                );

                ExchangeRate::create([
                    'currency_id' => $currency->id,
                    'date' => now()->toDateString(),
                    'rate' => $rateInUsd,
                ]);
            }
        } else {
            Log::error('Failed to fetch rates or rates not available in response.');
        }
    }
}
