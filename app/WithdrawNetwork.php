<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawNetwork extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'withdraw_network';

    protected $fillable = [
        'id',
        'id_withdraw',
        'name',
        'value',
        'fee',
        'date',
        'destination_wallet',
        'email',
        'type'
    ];

    protected $guarded = [
        'id',
        'name',
        'id_withdraw',
        'value',
        'fee',
        'date',
        'destination_wallet',
        'email',
        'type'
    ];
}
