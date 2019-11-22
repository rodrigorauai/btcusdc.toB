<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversorController extends Controller
{
    private $coinbaseController = 'App\Http\Controllers\CoinbaseController';

    public function conversor()
    {
        $btc_wallet = $this->getBtcWallet();
        $value = $btc_wallet["available"];

        try {
            $response = app($this->coinbaseController)->conversor($value, "BTC");
            sleep(3);
            if ($response) {
                return $this->getOrder($response["id"]);
            } else {
                return;
            }
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Error: '.$e->getMessage()
            ]);
        }
    }

    public function getBtcWallet()
    {
        # Sandbox
        $id_wallet = '56221037-3119-4704-9c9c-26d269a809f5';
        
        # Coinbase Pro
        // $id_wallet = '';

        return app($this->coinbaseController)->getWallet($id_wallet);
    }

    public function getUsdcWallet()
    {
        # Sandbox
        $id_wallet = '68b16534-5c72-4915-9232-f6d4c1888d19';

        # Coinbase Pro
        // $id_wallet = '';
        return app($this->coinbaseController)->getWallet($id_wallet);
    }

    public function orders()
    {
        return app($this->coinbaseController)->orders();
    }

    private function getOrder($id)
    {
        try {
            $response = app($this->coinbaseController)->order($id);
            // $this->split();
            return $response;
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error: '.$e->getMessage()
            ]);
        }
    }

    private function split(): float 
    {
        # Pegar o valor da carteira USDC
        $wallet = $this->getUsdcWallet();
        $size = $wallet["available"];

        # Dividir em 30%
        $value30 = 0.3 * $size;
        
        # Dividir em 70%
        $value70 = 0.7 * $size;
        
        // dd($value30 + $value70);
        return floatval($value);
    }
}
