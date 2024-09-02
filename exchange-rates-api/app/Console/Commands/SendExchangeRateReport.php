<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExchangeRateReport;

class SendExchangeRateReport extends Command
{
    protected $signature = 'exchange-rates:send-report';
    protected $description = 'Generate a daily report of exchange rates and send via email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = now()->toDateString();
        $rates = ExchangeRate::with('currency')->whereDate('date', $date)->get();

        $csvContent = "Currency,Rate\n";
        foreach ($rates as $rate) {
            $csvContent .= "{$rate->currency->code},{$rate->rate}\n";
        }

        $filePath = "exchange-rates-{$date}.csv";
        Storage::disk('local')->put($filePath, $csvContent);

        Mail::to('recipient@example.com')->send(new ExchangeRateReport($filePath));
    }
}
