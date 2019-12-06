<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyEarningStoreRequest extends FormRequest
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
            'id_user' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'id_withdraw' => 'required',
            'value' => 'required',
            'fee' => 'required',
            'date' => 'required',
            'destination_wallet' => 'required'
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
            'id_user.required' => 'User ID is required',
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'id_withdraw.required' => 'Withdraw ID is required',
            'value.required' => 'Value is required',
            'fee.required' => 'Fee is required',
            'date.required' => 'Date is required',
            'destination_wallet.required' => 'Destination Wallet is required'
        ];
    }
}
