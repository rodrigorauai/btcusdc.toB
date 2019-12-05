<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CoinbaseController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SplitValuesController;

class ConversorController extends Controller
{
    public $logController;
    public $splitValuesController;
    protected $coinbaseController;

    public function __construct()
    {
        $this->coinbaseController = new CoinbaseController();
        $this->logController = new LogController();
        $this->splitValuesController = new SplitValuesController();
    }

    public function conversor()
    {
        $btc_wallet = $this->getBtcWallet();
        $value = $btc_wallet["available"];

        try {
            $response = $this->coinbaseController->conversor($value, "BTC");
            sleep(3);
            if ($response) {
                # Split na carteira USDC
                $this->splitValues($response["id"]);

                # Pega o order ja com o status de settled, por conta do sleep(3)
                $getOrderResponse = $this->getOrder($response["id"]);
                # Salvar um log
                $this->saveOrderLog($getOrderResponse);

                return $getOrderResponse;
            } else {
                # Quando não há nada na carteira
                return;
            }
        } catch(Exception $e) {
            // return response()->json([
            //     'error' => 'Error: '.$e->getMessage()
            // ]);
        }
    }

    public function split($value30, $value70) 
    {
        # Manda pra w30
        $response30 = $this->coinbaseController->withdrawToWallet30($value30);

        # Manda pra w70
        $response70 = $this->coinbaseController->withdrawToWallet70($value70);
    }

    public function splitValues($order_id = 'none')
    {
        # Pegar o valor da carteira USDC
        $wallet = $this->getUsdcWallet();
        $size = $wallet["available"];

        # Padroniza o size para a quantidade de casas decimais suportadas pelas operações do coinbase
        $size = $this->getValueSixDecimal($size);

        # Dividir em 30%
        $value30 = 0.3 * $size;
        $value30 = $this->getValueSixDecimal($value30);
        // $value30 = floatval(number_format($value30, 6));

        # Dividir em 70%
        $value70 = 0.7 * $size;
        $value70 = $this->getValueSixDecimal($value70);
        // $value70 = floatval(number_format($value70, 6));

        if ($value30 > 0 && $value70 > 0) {
            # Mandar para duas carteiras
            $this->split($value30, $value70);

            # Guardar no banco
            $response = [
                'id_order' => $order_id,
                'value30' => $value30,
                'value70' => $value70,
            ];
            $this->saveSplitValues($response);
        }
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

    public function getWallets()
    {
        return $this->coinbaseController->getWallets();
    }

    public function orders()
    {
        return $this->coinbaseController->orders();
    }

    public function products()
    {
        return $this->coinbaseController->products();
    }

    private function getOrder($id)
    {
        try {
            $response = $this->coinbaseController->order($id);

            return $response;
        } catch (Exception $e) {
            // return response()->json([
            //     'error' => 'Error: '.$e->getMessage()
            // ]);
        }
    }

    private function saveOrderLog($response)
    {
        $jsonLog = json_encode($response);
        $request = json_decode($jsonLog);

        $this->logController->store($request);
    }

    private function saveSplitValues($response)
    {
        $jsonLog = json_encode($response);
        $request = json_decode($jsonLog);

        $this->splitValuesController->store($request);
    }

    private function getValueSixDecimal($value): float
    {
        return intval(strval($value * 1000000)) / 1000000;
    }
}
