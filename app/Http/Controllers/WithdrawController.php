<?php

namespace App\Http\Controllers;

use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendDailyWithdrawals;

class WithdrawController extends Controller
{
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
        return $withdrawals;
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

}
