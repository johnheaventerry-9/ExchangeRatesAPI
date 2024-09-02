<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use App\Jobs\StoreExchangeRateJob;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    protected $apiUrl;
    protected $apiKey;
    protected $symbols;

    public function __construct()
    {
        $this->apiUrl = config('services.exchange_rates.api_url');
        $this->apiKey = config('services.exchange_rates.api_key');
        $this->symbols = config('services.exchange_rates.symbols');
    }

    public function fetchAndStoreRates()
    {
        $response = Http::get($this->apiUrl, [
            'access_key' => $this->apiKey,
            'symbols' => $this->symbols
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['rates'])) {
            $usdRate = $data['rates']['USD']; // Get the USD rate relative to the base currency

            foreach ($data['rates'] as $currencyCode => $rate) {
                $rateInUsd = ($currencyCode === 'USD') ? $rate : $rate / $usdRate;
                StoreExchangeRateJob::dispatch($currencyCode, $rateInUsd, now()->toDateString());
            }
        } else {
            Log::error('Failed to fetch rates or rates not available in response.');
        }
    }
}
