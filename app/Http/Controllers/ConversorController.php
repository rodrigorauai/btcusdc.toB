<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CoinbaseController;
use App\Http\Controllers\LogController;

class ConversorController extends Controller
{
    // private $coinbaseController = 'App\Http\Controllers\CoinbaseController';
    public $logController;
    protected $coinbaseController;

    public function __construct()
    {
        $this->coinbaseController = new CoinbaseController();
        $this->logController = new LogController();
    }

    public function conversor()
    {
        $btc_wallet = $this->getBtcWallet();
        $value = $btc_wallet["available"];

        try {
            $response = $this->coinbaseController->conversor($value, "BTC");
            sleep(3);
            if ($response) {
                # Pega o order ja com o status de settled
                $getOrderResponse = $this->getOrder($response["id"]);
                # Salvar um log
                $this->saveOrderLog($getOrderResponse);

                # Fazer o split em duas wallets
                $this->split();

                return $getOrderResponse;
            } else {
                # Quando não há nada na carteira
                return;
            }
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Error: '.$e->getMessage()
            ]);
        }
    }

    public function getWallets()
    {
        return $this->coinbaseController->getWallets();
    }

    public function getBtcWallet()
    {
        # Sandbox
        // $id_wallet = '56221037-3119-4704-9c9c-26d269a809f5';
        
        # Coinbase Pro
        $id_wallet = 'c3791fc3-5627-4fc9-a6a5-0ea73a11bea7';
        return $this->coinbaseController->getWallet($id_wallet);
    }

    public function getUsdcWallet()
    {
        # Sandbox
        // $id_wallet = '68b16534-5c72-4915-9232-f6d4c1888d19';

        # Coinbase Pro
        $id_wallet = 'd3de80f0-3c8b-4a92-95eb-97602e49817a';
        return $this->coinbaseController->getWallet($id_wallet);
    }

    public function orders()
    {
        return $this->coinbaseController->orders();
    }

    public function products()
    {
        return $this->coinbaseController->products();
    }

    private function saveOrderLog($response)
    {
        $jsonLog = json_encode($response);
        $request = json_decode($jsonLog);

        $this->logController->store($request);
    }

    private function getOrder($id)
    {
        try {
            $response = $this->coinbaseController->order($id);
            // $this->split();
            return $response;
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error: '.$e->getMessage()
            ]);
        }
    }

    public function split() 
    {
        # Pegar o valor da carteira USDC
        $wallet = $this->getUsdcWallet();
        $size = $wallet["available"];

        # Padroniza o size para a quantidade de casas decimais suportadas pelas operações do coinbase
        $size = floatval(number_format($size, 6));

        # Dividir em 30%
        $value30 = 0.3 * $size;
        $value30 = floatval(number_format($value30, 6));
        # Dividir em 70%
        $value70 = 0.7 * $size;
        $value70 = floatval(number_format($value70, 6));
        
        $value = $value30 + $value70;
        if ($value === $size) {
            # Manda pra w30
            try {
                $response30 = $this->coinbaseController->withdrawToWallet30($value30);
            } catch(Exception $e) {
                // dump('error 30');
            }

            # Manda pra w70
            try {
                $response70 = $this->coinbaseController->withdrawToWallet70($value70);
            } catch(Exception $e) {
                // dump('error 70');
            }
        } else {
            return false;
        }
        return true;
    }
}
