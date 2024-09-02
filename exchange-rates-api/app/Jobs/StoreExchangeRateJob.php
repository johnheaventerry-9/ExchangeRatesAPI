<?php

namespace App\Jobs;

use App\Models\ExchangeRate;
use App\Models\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreExchangeRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currencyCode;
    protected $rate;
    protected $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($currencyCode, $rate, $date)
    {
        $this->currencyCode = $currencyCode;
        $this->rate = $rate;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currency = Currency::firstOrCreate(
            ['code' => $this->currencyCode],
            ['name' => $this->currencyCode]
        );

        ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => $this->date,
            'rate' => $this->rate,
        ]);
    }
}
