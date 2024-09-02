<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    public function fetchAndStoreRates()
    {
        $response = Http::get('https://api.exchangeratesapi.io/v1/latest', [
            'access_key' => '8821a8b8456efe92aadbcfa56e491620',
            'base' => 'USD'
        ]);
    
        Log::info('API Response:', $response->json());
    
        if ($response->successful() && isset($response['rates'])) {
            foreach ($response['rates'] as $currencyCode => $rate) {
                $currency = Currency::firstOrCreate(['code' => $currencyCode]);
                ExchangeRate::create([
                    'currency_id' => $currency->id,
                    'date' => now()->toDateString(),
                    'rate' => $rate,
                ]);
            }
        } else {
            Log::error('Failed to fetch rates or rates not available in response.');
        }
    }
}
