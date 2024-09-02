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
        ]);
    
        $data = $response->json();
    
        if ($response->successful() && isset($data['rates'])) {
            foreach ($data['rates'] as $currencyCode => $rate) {
                StoreExchangeRateJob::dispatch($currencyCode, $rate, now()->toDateString());
            }
        } elseif (isset($data['error'])) {
            Log::error('API Error: ' . $data['error']['message']);
        } else {
            Log::error('Failed to fetch rates or rates not available in response.');
        }
    }
    
}
