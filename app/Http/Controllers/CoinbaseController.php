<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hellovoid\Gdax\Configuration;
use Hellovoid\Gdax\Client;

class CoinbaseController extends Controller
{
    private $api_key;
    private $api_secret;
    private $configuration;
    private $client;

    public function __construct() {
        # Chaves default
        $this->api_key = config('coinbase.api_key');
        $this->api_secret = config('coinbase.secret');
        $this->passphrase = config('coinbase.passphrase');

        # Chaves sandbox
        // $this->api_key = '010e7508032e404c54ca850f8da4ea26';
        // $this->api_secret = 'ek/fvO7YanVTgU6shT6eljUaGBQU3VB6ERv1ZfmPYjrTvqUXgg7s8Ng9mOkuuk3rzz7KRbTuyrW7lQNf/8IbGw==';
        // $this->passphrase = 'ngucn0yyqpo';

        $this->setUpConfiguration();
        $this->setUpClient();
    }

    public function conversor($value, $currency = 'BTC')
    {
        # Vende Bitcoin e compra USDCoin
        if ($value >= 0.001) {
            $response = $this->client->placeOrder([
                'size'       => $value,
                'price'      => 0.1,
                'type'       => 'market',
                'side'       => 'sell',
                'product_id' => 'BTC-USDC'
                // 'product_id' => 'BTC-USD'
            ]);
    
            return $response;
        } else {
            // return response()->json([
            //     'error' => 'Value is not enough'
            // ])
        }
    }

    public function order($order_id)
    {
        return $this->client->getOrder($order_id);
    }

    public function withdrawToWallet30($value)
    {
        if ($value >= 0.000001) {
            try {
                $response = $this->client->withdrawalTo([
                    'amount'              => $value,
                    'currency'            => 'USDC',
                    'crypto_address'      => '0xe1Bf10Cb02e09042b4185e73BB302631D66E4094'
                ]);
                
                return $response;
            } catch(Exception $e) {
                // dump('error in 30');
            }
        }
    }

    public function withdrawToWallet70($value)
    {
        if ($value >= 0.000001) {
            try {
                $response = $this->client->withdrawalTo([
                    'amount'              => $value,
                    'currency'            => 'USDC',
                    'crypto_address'      => '0x1AB13042aB81112b1fb5eE8c4D076c56F5725bb0'
                ]);

                return $response;
            } catch(Exception $e) {
                // dump('error in 70');
            }
        }
    }

    public function getWallet($id)
    {
        return $this->client->getAccount($id);
    }

    public function orders()
    {
        return $this->client->getOrders([
            'status' => 'all',
        ]);
    }

    public function products()
    {
        return $this->client->getProducts();
    }

    public function getWallets()
    {
        return $this->client->getAccounts();
    }

    private function setUpConfiguration()
    {
        $this->configuration = Configuration::apiKey($this->api_key, $this->api_secret, $this->passphrase);
    }
    
    private function setUpClient()
    {
        $this->client = Client::create($this->configuration);
    }
}
