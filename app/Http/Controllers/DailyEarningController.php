<?php

namespace App\Http\Controllers;

use App\DailyEarning;
use Illuminate\Http\Request;
use App\Http\Requests\DailyEarningStoreRequest;

class DailyEarningController extends Controller
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
     * @param  \App\DailyEarning  $dailyEarning
     * @return \Illuminate\Http\Response
     */
    public function show(DailyEarning $dailyEarning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyEarning  $dailyEarning
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyEarning $dailyEarning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyEarning  $dailyEarning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyEarning $dailyEarning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyEarning  $dailyEarning
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyEarning $dailyEarning)
    {
        //
    }

    public function withdrawRede(DailyEarningStoreRequest $request)
    {
        $validated = $request->validated();

        $dailyEarning = new DailyEarning;
        $dailyEarning->name = $validated["nome"];
        $dailyEarning->email = $validated["email"];
        $dailyEarning->id_withdraw = $validated["id_saque"];
        $dailyEarning->value = $validated["valor"];
        $dailyEarning->fee = $validated["taxa"];
        $dailyEarning->date = $validated["data_solicitacao"];
        $dailyEarning->destination_wallet = $validated["carteira_usdc"];
        $dailyEarning->type = $validated["tipo"];

        dd($dailyEarning);
        return 'recebido';
    }
}
