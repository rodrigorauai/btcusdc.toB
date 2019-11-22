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
        // $this->api_key = env('COINBASE_API_KEY');
        // $this->api_secret = env('COINBASE_SECRET');
        // $this->passphrase = env('COINBASE_PASSPHRASE');

        # Chaves sandbox
        $this->api_key = '010e7508032e404c54ca850f8da4ea26';
        $this->api_secret = 'ek/fvO7YanVTgU6shT6eljUaGBQU3VB6ERv1ZfmPYjrTvqUXgg7s8Ng9mOkuuk3rzz7KRbTuyrW7lQNf/8IbGw==';
        $this->passphrase = 'ngucn0yyqpo';

        $this->setUpConfiguration();
        $this->setUpClient();
        
    }

    private function setUpConfiguration()
    {
        $this->configuration = Configuration::apiKey($this->api_key, $this->api_secret, $this->passphrase);
    }
    
    private function setUpClient()
    {
        $this->client = Client::create($this->configuration);
    }

    public function index()
    {
        // dd($client->getProductTrades("BTC-USD"));

        # Carteiras (wallets):
        // dd($this->client->getAccounts());
        return $this->client->getProductTrades("BTC-USD");
    }

    public function orders()
    {
        // dd($this->client->conversion([
        //     'from' => 'USDC',
        //     'to' => 'USDC',
        //     'amount' => 1,
        // ]));

        return $this->client->getOrders([
            'status' => 'all',
        ]);

        // "filled_size": "0.02439452"
        // "executed_value": "197.4629058112000000"
        # filled_size -> Valor em BTC
        # executed_value -> Valor em USDC

        return $this->client->getAccount("d3de80f0-3c8b-4a92-95eb-97602e49817a");
    }

    public function order($order_id)
    {
        return $this->client->getOrder($order_id);
    }

    public function conversor($value, $currency = 'BTC')
    {
        # Place a new order:
        // {
        //     "size": "0.01",
        //     "price": "0.100",
        //     "side": "sell",
        //     "product_id": "BTC-USD"
        // }
        # size: amount of BTC to sell
        $response = $this->client->placeOrder([
            'size'       => $value,
            'price'      => 0.1,
            'type'       => 'market',
            'side'       => 'sell',
            'product_id' => 'BTC-USD'
        ]);

        return $response;
    }
}
