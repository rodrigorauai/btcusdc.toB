<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ClientController extends Controller
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
        // Verifica o mmn_id_user, caso ja exista, nao cadastrar
        $client = new Client;
        $client->mmn_id_user = $request->mmn_id_user;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->usdc_wallet = $request->usdc_wallet;

        try { 
            $client->save();

            return $client;
        } catch(QueryException $ex) {
            return;
            dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($mmn_id)
    {
        $client = Client::where('mmn_id_user', $mmn_id)->first();

        if ($client) {
            return $client;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
