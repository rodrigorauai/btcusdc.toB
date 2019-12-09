<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawNetwork extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'email' => 'required|email',
            'id_saque' => 'required',
            'valor' => 'required',
            'taxa' => 'required',
            'data_solicitacao' => 'required',
            'data_solicitacao.date' => 'required',
            'carteira_usdc' => 'required',
            'tipo' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'Nome is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'id_saque.required' => 'Saque ID is required',
            'valor.required' => 'Valor is required',
            'taxa.required' => 'Taxa is required',
            'data_solicitacao.required' => 'Data Solitacao is required',
            'data_solicitacao.date.required' => 'Date is required',
            'carteira_usdc.required' => 'Carteira USDC is required',
            'tipo.required' => 'Tipo is required'
        ];
    }
}
