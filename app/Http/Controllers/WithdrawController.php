<?php

namespace App\Http\Controllers;

use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendDailyWithdrawals;
use App\Http\Binance;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FeeController;

class WithdrawController extends Controller
{
    protected $api;
    private $feeController;

    public function __construct()
    {
        $api_key = config('binance.api_key');
        $api_secret = config('binance.api_secret');
        
        $this->api = new Binance\API($api_key, $api_secret);
        // $api = new Binance\RateLimiter($api);

        $this->feeController = new FeeController();
    }

    /**
     * Display the daily email.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_formated = Carbon::today('America/Sao_Paulo')->format('d/m/Y');

        $withdrawals = $this->dayWithdrawals();

        $total = [
            'fees' => 0,
            'withdrawals' => 0
        ];

        foreach ($withdrawals as $key) {
            $total['fees'] += $key['fee'];
            $total['withdrawals'] += $key['value'];
        }

        return view('emails.daily_withdrawals', 
            [
                'withdrawals' => $withdrawals,
                'date_formated' => $date_formated,
                'total' => $total
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $withdraw = new Withdraw;
        $withdraw->mmn_id_withdraw = $request->mmn_id_withdraw;
        $withdraw->binance_id = "";
        $withdraw->type = $request->type;
        $withdraw->value = $request->value;
        $withdraw->fee = $request->fee;
        $withdraw->date = $request->date;
        $withdraw->status = $request->status;
        $withdraw->client_id = $request->client->id;
        
        try {
            $withdraw->save();

            return $withdraw;
        } catch(QueryException $ex) {
            return;
            dd($ex->getMessage());
            // Note any method of class PDOException can be called on $ex.
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show($mmn_id_withdraw)
    {
        $withdraw = Withdraw::where('mmn_id_withdraw', $mmn_id_withdraw)->first();

        if ($withdraw) {
            return $withdraw;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function update($mmn_id_withdraw, $request)
    {
        $withdraw = Withdraw::where('mmn_id_withdraw', $mmn_id_withdraw)->first();

        $withdraw->status = $request["status"];

        if (array_key_exists('binance_id', $request)) {
            $withdraw->binance_id = $request["binance_id"];
        }

        try {
            $withdraw->save();

            return $withdraw;
        } catch(QueryException $ex) {
            return;
            dd($ex->getMessage());
            // Note any method of class PDOException can be called on $ex.
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }

    /**
     * Display a listing of withdrawals to pay.
     *
     * @return \Illuminate\Http\Response
     */
    public function dayWithdrawals()
    {
        $withdrawals = [];
        $withdrawals_db = Withdraw::where('status', 'aprovado')
            ->get();
        $today = Carbon::today();

        foreach ($withdrawals_db as $key => $value) {
            if ($value->created_at->day == $today->day) {
                $withdrawals[] = [
                    'id_withdraw' => $value->mmn_id_withdraw,
                    'value' => $value->value,
                    'fee' => $value->fee,
                    'day' => $value->created_at->day
                ];
            }
        }

        return $this->sendEmail($withdrawals);
    }

    /**
     * Send email with day's withdrawals.
     */
    public function sendEmail($withdrawals)
    {
        // Configurar pra mandar email
        $date_formated = Carbon::today('America/Sao_Paulo')->format('d/m/Y');

        $total = [
            'fees' => 0,
            'withdrawals' => 0
        ];

        # TODO: save this values (fee and value) in table of DB
        foreach ($withdrawals as $key) {
            $total['fees'] += $key['fee'];
            $total['withdrawals'] += $key['value'];
        }

        $mail = Mail::to('theus.ass.reis@gmail.com')->send(new SendDailyWithdrawals($withdrawals, $date_formated, $total));

    }

    public function getDayWithdrawals()
    {
        $withdrawals = [];
        $withdrawals_db = Withdraw::where('status', 'aprovado')
            ->get();
        $today = Carbon::today();

        foreach ($withdrawals_db as $key => $value) {
            if ($value->created_at->day == $today->day) {
                $withdrawals[] = [
                    'id_withdraw' => $value->id,
                    'mmn_id_withdraw' => $value->mmn_id_withdraw,
                    'value' => $value->value,
                    'fee' => $value->fee,
                    'day' => $value->created_at->day,
                    'destination_wallet' => $value->client->usdc_wallet,
                ];
            }
        }

        return $withdrawals;
    }

    public function withdraw()
    {
        // return 'a';
        
        return $this->api->withdraw("USDC", "0xee92Feb8f9e8C411930C5Defb94C2BEb28dD870a", 2);
    }

    public function payWithdrawals()
    {
        // Pagar saques e taxas
        $withdrawals = $this->getDayWithdrawals();

        $withdrawals_executed = [
            'withdrawals' => [],
            'fees' => []
        ];

        // dd($withdrawals);
        // dd($this->api->withdrawHistory());

        foreach ($withdrawals as $key => $item) {
            $asset = "USDC";
            $address = $item["destination_wallet"];
            $amount = $item["value"];

            # Withdraw to client
            $withdraw_client = $this->api->withdraw($asset, $address, $amount);

            # Example of response
            // $withdraw_client = [
            //     'success' => false,
            //     'id' => 'fapisdjfoahfoij',
            // ];
                
            // dd($withdraw_client);
            if ($withdraw_client["success"]) {
                # Pago

                $withdraw_formated = [
                    'id_saque' => $item["mmn_id_withdraw"],
                    'status' => 'pago',
                    'binance_id' => $withdraw_client["id"],
                ];

                $this->update($item["mmn_id_withdraw"], $withdraw_formated);
            } else {
                # Não pago

                $withdraw_formated = [
                    'id_saque' => $item["mmn_id_withdraw"],
                    'status' => 'nao_pago',
                    'binance_id' => 'none',
                ];

                $this->update($item["mmn_id_withdraw"], $withdraw_formated);
            }

            array_push($withdrawals_executed['withdrawals'], $withdraw_formated);

            $address = "0xee92Feb8f9e8C411930C5Defb94C2BEb28dD870a";
            $amount = $item["fee"];
            
            # Withdraw fee
            $withdraw_fee = $this->api->withdraw($asset, $address, $amount);

            # Example of response
            // $withdraw_fee = [
            //     'success' => false,
            //     'id' => 'fapisdjfoahfoij',
            // ];

            if ($withdraw_fee["success"]) {
                # Pago

                $fee = json_encode([
                    'id_withdraw' => $item['id_withdraw'],
                    'value' => $amount,
                    'status' => 'pago',
                ]);
                $fee = json_decode($fee);

                $fee_formated = [
                    'id_withdraw' => $item['id_withdraw'],
                    'value' => $amount,
                    'status' => 'pago'
                ];

                $this->feeController->store($fee);
            } else {
                # Não pago

                $fee = json_encode([
                    'id_withdraw' => $item['id_withdraw'],
                    'value' => $amount,
                    'status' => 'nao_pago',
                ]);
                $fee = json_decode($fee);

                $fee_formated = [
                    'id_withdraw' => $item['id_withdraw'],
                    'value' => $amount,
                    'status' => 'nao_pago'
                ];

                $this->feeController->store($fee);
            }

            array_push($withdrawals_executed['fees'], $fee_formated);
        }

        dd($withdrawals_executed);

        # Chamar POST para devolver ao MMN
        // 
    }

}
