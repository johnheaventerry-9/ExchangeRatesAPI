<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Currency;
use App\Models\ExchangeRate;

class ExchangeRateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_exchange_rates()
    {
        $currency = Currency::create(['code' => 'USD', 'name' => 'US Dollar']);

        $exchangeRate = ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => now()->toDateString(),
            'rate' => 1.12,
        ]);

        $this->assertDatabaseHas('exchange_rates', [
            'currency_id' => $currency->id,
            'rate' => 1.12,
        ]);
    }

    public function test_it_returns_exchange_rates_by_date()
    {
        $currency = Currency::create(['code' => 'USD', 'name' => 'US Dollar']);

        ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => now()->toDateString(),
            'rate' => 1.12,
        ]);

        $response = $this->getJson('api/exchange-rates/' . now()->toDateString());

        $response->assertStatus(200)
            ->assertJson([
                ['currency' => 'USD', 'rate' => 1.12]
            ]);
    }
}
