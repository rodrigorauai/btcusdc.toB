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

        // if (strtoupper($data["currency"]) !== "BTC") {
        //     return response()->json(['error' => 'Currency not avaible']);
        // }

        try {
            $response = app($this->coinbaseController)->conversor($data["value"], $data["currency"]);
            // dd($response["id"]);
            sleep(5);
            dd($this->getOrder($response["id"]));
            // return $response;
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Error: '.$e->getMessage()
            ]);
        }        
    }

    public function getBtcWallet()
    {
        return 'BTC Wallet';
    }

    public function getUsdcWallet()
    {
        return 'USDC Wallet';
    }

    public function orders()
    {
        return app($this->coinbaseController)->orders();
    }

    private function x($value): float {
        return floatval($value);
    }

    private function getOrder($id)
    {
        $response = app($this->coinbaseController)->order($id);
        return $response;
    }
}
