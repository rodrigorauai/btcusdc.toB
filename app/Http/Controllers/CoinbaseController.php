<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hellovoid\Gdax\Configuration;
use Hellovoid\Gdax\Client;

class CoinbaseController extends Controller
{
    private $api_key;
    private $api_secret;
    private $base_url = 'https://api.pro.coinbase.com';
    private $configuration;
    private $client;

    public function __construct() {
        # Chaves default
        $this->api_key = env('COINBASE_API_KEY');
        $this->api_secret = env('COINBASE_SECRET');
        $this->passphrase = env('COINBASE_PASSPHRASE');

        # Chaves sandbox
        // $this->api_key = '010e7508032e404c54ca850f8da4ea26';
        // $this->api_secret = 'ek/fvO7YanVTgU6shT6eljUaGBQU3VB6ERv1ZfmPYjrTvqUXgg7s8Ng9mOkuuk3rzz7KRbTuyrW7lQNf/8IbGw==';
        // $this->passphrase = 'ngucn0yyqpo';

        $this->configuration = Configuration::apiKey($this->api_key, $this->api_secret, $this->passphrase);
        $this->client = Client::create($this->configuration);
    }

    public function index()
    {
        // dd($client->getProductTrades("BTC-USD"));

        # Carteiras (wallets):
        // dd($this->client->getAccounts());
        return $this->client->getProductTrades("BTC-USD");
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
        return response()->json([
            'size'       => $value,
            'price'      => 0.1,
            'type'       => 'market',
            'side'       => 'sell',
            'product_id' => 'BTC-USD'
        ]);
        return $this->client->placeOrder([
            'size'       => $value,
            'price'      => 0.1,
            'type'       => 'market',
            'side'       => 'sell',
            'product_id' => 'BTC-USD'
        ]);

    }
}
