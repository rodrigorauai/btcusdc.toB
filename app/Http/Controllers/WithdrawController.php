<?php

namespace App\Http\Controllers;

use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $withdrals = [];
        $withdrawals_db = Withdraw::where('status', 'aprovado')
            ->get();
        $today = Carbon::today();

        foreach ($withdrawals_db as $key => $value) {
            if ($value->created_at->day == $today->day) {
                $withdrals[] = [
                    'id_saque' => $value->mmn_id_withdraw,
                    'value' => $value->value,
                    'fee' => $value->fee,
                    'day' => $value->created_at->day
                ];
            }
        }

        return $withdrals;
    }

    /**
     * Send email with day's withdrawals.
     */
    public function sendEmail()
    {
        // Configurar pra mandar email
    }

}
