<?php

namespace App\Http\Controllers;

use App\WithdrawYield;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWithdrawYield;

class WithdrawYieldController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WithdrawYield  $withdrawYield
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawYield $withdrawYield)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WithdrawYield  $withdrawYield
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawYield $withdrawYield)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WithdrawYield  $withdrawYield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawYield $withdrawYield)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WithdrawYield  $withdrawYield
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawYield $withdrawYield)
    {
        //
    }

    public function storeWithdrawYield(StoreWithdrawYield $request)
    {
        $validated = $request->validated();

        $withdrawYield = new WithdrawYield;
        $withdrawYield->id_withdraw = $validated["id_saque"];
        $withdrawYield->name = $validated["nome"];
        $withdrawYield->value = $validated["valor"];
        $withdrawYield->fee = $validated["taxa"];
        $withdrawYield->date = $validated["data_solicitacao"]["date"];
        $withdrawYield->destination_wallet = $validated["carteira_usdc"];
        $withdrawYield->email = $validated["email"];
        $withdrawYield->type = $validated["tipo"];

        if ($withdrawYield->save()) {
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'error' => 'Error'
            ]);
        }
    }
}
