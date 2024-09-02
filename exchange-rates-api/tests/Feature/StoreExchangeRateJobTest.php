<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Jobs\StoreExchangeRateJob;
use App\Models\Currency;
use App\Models\ExchangeRate;

class StoreExchangeRateJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_creates_currency_and_exchange_rate()
    {
        Queue::fake();

        $currencyCode = 'USD';
        $rate = 1.12;
        $date = now()->toDateString();

        // Dispatch the job
        StoreExchangeRateJob::dispatch($currencyCode, $rate, $date);

        // Run the job
        Queue::assertPushed(StoreExchangeRateJob::class, function ($job) use ($currencyCode, $rate, $date) {
            $job->handle();

            // Assert that the currency is created or found
            $currency = Currency::where('code', $currencyCode)->first();
            $this->assertNotNull($currency);

            // Assert that the exchange rate is created
            $exchangeRate = ExchangeRate::where('currency_id', $currency->id)
                ->where('date', $date)
                ->where('rate', $rate)
                ->first();
            $this->assertNotNull($exchangeRate);

            return true;
        });
    }
}
