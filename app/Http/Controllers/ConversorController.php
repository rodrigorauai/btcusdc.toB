<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversorController extends Controller
{
    private $coinbaseController = 'App\Http\Controllers\CoinbaseController';

    # Recebe dados de sistemas externos
    public function conversor(Request $request)
    {
        # Validar currency, value
        $data = $request->only('value', 'currency');

        if (strtoupper($data["currency"]) !== "BTC") {
            return response()->json(['error' => 'Currency not avaible']);
        }

        return app($this->coinbaseController)->conversor(0.0000000001);
    }

    private function x($value): float {
        return floatval($value);
    }
}
