<?php

namespace App\Http\Controllers;

use App\WithdrawNetwork;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWithdrawNetwork;

class WithdrawNetworkController extends Controller
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
     * @param  \App\WithdrawNetwork  $withdrawNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawNetwork $withdrawNetwork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WithdrawNetwork  $withdrawNetwork
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawNetwork $withdrawNetwork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WithdrawNetwork  $withdrawNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawNetwork $withdrawNetwork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WithdrawNetwork  $withdrawNetwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawNetwork $withdrawNetwork)
    {
        //
    }

    public function storeWithdrawNetwork(StoreWithdrawNetwork $request)
    {
        $validated = $request->validated();

        $withdrawNetwork = new WithdrawNetwork;
        $withdrawNetwork->id_withdraw = $validated["id_saque"];
        $withdrawNetwork->name = $validated["nome"];
        $withdrawNetwork->value = $validated["valor"];
        $withdrawNetwork->fee = $validated["taxa"];
        $withdrawNetwork->date = $validated["data_solicitacao"]["date"];
        $withdrawNetwork->destination_wallet = $validated["carteira_usdc"];
        $withdrawNetwork->email = $validated["email"];
        $withdrawNetwork->type = $validated["tipo"];

        if ($withdrawNetwork->save()) {
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
