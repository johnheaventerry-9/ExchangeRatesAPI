<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function getRatesByDate(Request $request, $date)
    {
        $rates = ExchangeRate::with('currency')
            ->whereDate('date', $date)
            ->get()
            ->map(function ($rate) {
                return [
                    'currency' => $rate->currency->code,
                    'rate' => $rate->rate,
                ];
            });

        return response()->json($rates);
    }
}
