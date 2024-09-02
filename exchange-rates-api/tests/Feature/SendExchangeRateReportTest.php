<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Console\Commands\SendExchangeRateReport;
use App\Mail\ExchangeRateReport;
use App\Models\ExchangeRate;
use App\Models\Currency;

class SendExchangeRateReportTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Mail::fake();
    }

    public function test_command_creates_csv_and_sends_email()
    {
        // Arrange: Create a test currency and exchange rate
        $currency = Currency::create(['code' => 'USD', 'name' => 'US Dollar']);
        ExchangeRate::create([
            'currency_id' => $currency->id,
            'date' => now()->toDateString(),
            'rate' => 1.12,
        ]);

        // Act: Run the command
        $this->artisan('exchange-rates:send-report')
            ->assertExitCode(0);

        // Assert: Check the CSV file was created
        $filePath = "exchange-rates-".now()->toDateString().".csv";
        $this->assertTrue(Storage::disk('local')->exists($filePath));

        // Assert: Check the CSV content
        $csvContent = Storage::disk('local')->get($filePath);
        $this->assertStringContainsString("Currency,Rate", $csvContent);
        $this->assertStringContainsString("USD,1.12", $csvContent);

        // Assert: Check the email was sent
        Mail::assertSent(ExchangeRateReport::class, function ($mail) use ($filePath) {
            // Check email properties
            $this->assertEquals('Daily Exchange Rate Report', $mail->envelope()->subject);
            $this->assertEquals('jsmht@hotmail.com', $mail->envelope()->from->address);

            // Check if the email contains the correct attachment
            $attachmentFound = false;
            foreach ($mail->attachments() as $attachment) {
                if ($attachment->as === 'exchange-rate-report-' . now()->toDateString() . '.csv' &&
                    $attachment->mime === 'text/csv') {
                    $attachmentFound = true;
                    break;
                }
            }
            return $attachmentFound;
        });
    }
}
