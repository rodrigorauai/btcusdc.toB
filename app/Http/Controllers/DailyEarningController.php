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
            $check_valid = false;
            $status_withdraw = 'recebido';

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

            # Caso nao tenha cadastro chama o store do client controller
            # retornando o client
            if (!$check_client) {
                # **(fluxo do recebeu 1x: não)**
                $client = $this->clientController->store($client);
                $check_valid = true;
            } else {
                # **(fluxo do recebeu 1x: sim)**
                # Verificar carteira, se mudou: mandar email
                # e tambem cancelar o pagamento, cliente verifica com o mmn
                if ($check_client->usdc_wallet !== $client->usdc_wallet) {
                    # **(mudou carteira: sim)**
                    # Carteira esta diferente, mandar email
                    echo "Mandar email".$client->email;
                    // continue;
                    $check_valid = false;
                } else {
                    # **(mudou carteira: não)**
                    $check_valid = true;
                }

                $client = $check_client;
            }

            // Withdraw
            $withdraw = json_encode([
                'mmn_id_withdraw' => $value["id_saque"],
                'type' => $value["tipo"],
                'value' => $value["valor"],
                'fee' => $value["taxa"],
                'date' => $value["data_solicitacao"]["date"],
                'status' => $status_withdraw,
                'client' => $client,
            ]);
            $withdraw = json_decode($withdraw);

            $check_withdraw_exists = $this->withdrawController->show($withdraw->mmn_id_withdraw);

            # Withdraw ja existe (quando mudar a carteira do cliente e enviar o saque novamente)
            if (!$check_withdraw_exists) {

            }

            # **(verifica status do pagamento (aprovado ou negado), para guardar no banco)**
            if ($check_valid) {
                # Status Aprovado
                $withdraw_stored = $this->withdrawController->store($withdraw);

                # Formatar para dar o callback para MMN
                if ($withdraw_stored) {
                    $status_withdraw = 'aprovado';

                    $withdraw_formated = [
                        'id_saque' => $withdraw->mmn_id_withdraw,
                        'status' => $status_withdraw,
                    ];
                }
            } else {
                # Status Negado
                $status_withdraw = 'negado';

                $withdraw_formated = [
                    'id_saque' => $withdraw->mmn_id_withdraw,
                    'status' => $status_withdraw,
                ];
            }

            # Em vez de retornar a lista, atualizar no banco 
            # Para quando o financeiro solicitar o saque, puxar dessa tabela
            # Caso o status seja de 'aprovado', manda pro coinbase
            $this->withdrawController->update($withdraw->mmn_id_withdraw, $withdraw_formated);
        }

        # Chama função para mandar email para financeiro
        $email = $this->withdrawController->dayWithdrawals();
        dd($email);
    }
}
