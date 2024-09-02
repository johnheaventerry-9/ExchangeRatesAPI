<?php

namespace App\Jobs;

use App\Models\ExchangeRate;
use App\Models\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class StoreExchangeRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currencyCode;
    protected $rate;
    protected $date;

    public function __construct($currencyCode, $rate, $date)
    {
        $this->currencyCode = $currencyCode;
        $this->rate = $rate;
        $this->date = $date;
    }

    public function handle()
    {
        Log::info("Processing job for currency: {$this->currencyCode} with rate: {$this->rate}");

        $currency = Currency::firstOrCreate(
            ['code' => $this->currencyCode],
            ['name' => $this->currencyCode]
        );

        ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => $this->date,
            'rate' => $this->rate,
        ]);

        Log::info("Job completed for currency: {$this->currencyCode}");
    }
}
