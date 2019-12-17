<?php

namespace App\Http\Controllers;

use App\DailyEarning;
use App\Withdraw;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\DailyEarningStoreRequest;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\ClientController;

class DailyEarningController extends Controller
{
    private $clientController;
    private $withdrawController;

    public function __construct()
    {
        $this->clientController = new ClientController();
        $this->withdrawController = new WithdrawController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Withdraw::all();
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
    public function show($id)
    {
        $w = Withdraw::find($id);
        return $w;
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

        foreach ($validated as $key => $value) {
            $client = json_encode([
                'mmn_id_user' => $value["id_usuario"],
                'name' => $value["nome"],
                'email' => $value["email"],
                'usdc_wallet' => $value["carteira_usdc"]
            ]);
            $client = json_decode($client);

            # Verifica se o client ja esta cadastrado
            # através do mmn_id
            $check_client = $this->clientController->show($value["id_usuario"]);

            # Caso ja tenha cadastro chama o store do client controller
            # retornando o client
            if (!$check_client) {
                $client = $this->clientController->store($client);
            } else {
                $client = $check_client;
            }

            // Withdraw
            $withdraw = json_encode([
                'mmn_id_withdraw' => $value["id_saque"],
                'type' => $value["tipo"],
                'value' => $value["valor"],
                'fee' => $value["taxa"],
                'date' => $value["data_solicitacao"]["date"],
                'client' => $client,
            ]);
            $withdraw = json_decode($withdraw);

            $this->withdrawController->store($withdraw);
        }


        // Client
        // $client = json_encode([
        //     'mmn_id_user' => $validated["id_usuario"],
        //     'name' => $validated["nome"],
        //     'email' => $validated["email"],
        //     'usdc_wallet' => $validated["carteira_usdc"]
        // ]);
        // $client = json_decode($client);

        # User ja recebeu?

        # Mudou a carteira?

        # Envia email para user, confirmando mudança da carteira

        

        # Chama o store do client controller
        # retornando o client
        # pega o client e cadastra no withdraw
        // $client = $this->clientController->store($client);

        // Withdraw
        // $withdraw = json_encode([
        //     'mmn_id_withdraw' => $validated["id_saque"],
        //     'type' => $validated["tipo"],
        //     'value' => $validated["valor"],
        //     'fee' => $validated["taxa"],
        //     'date' => $validated["data_solicitacao"]["date"],
        //     'client' => $client,
        // ]);
        // $withdraw = json_decode($withdraw);

        // $this->withdrawController->store($withdraw);
    }
}
