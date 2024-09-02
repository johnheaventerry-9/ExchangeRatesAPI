<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Currency;
use App\Models\ExchangeRate;

class ExchangeRateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_rates_by_date_returns_correct_data()
    {
        // Arrange: Set up test data
        $currency = Currency::create(['code' => 'USD', 'name' => 'US Dollar']);
        ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => now()->toDateString(), // Use today's date for testing
            'rate' => 1.12,
        ]);

        // Act: Make a GET request to the endpoint
        $response = $this->getJson('exchange-rates/' . now()->toDateString());

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                [
                    'currency' => 'USD',
                    'rate' => 1.12,
                ]
            ]);
    }

    public function test_get_rates_by_date_no_data()
    {
        // Act: Make a GET request to the endpoint with a date that has no data
        $response = $this->getJson('exchange-rates/' . now()->toDateString());

        // Assert: Ensure the response is empty
        $response->assertStatus(200)
            ->assertJson([]);
    }
}
