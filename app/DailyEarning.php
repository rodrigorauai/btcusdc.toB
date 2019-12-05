<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyEarning extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'daily_earnings';

    protected $fillable = [
        'id',
        'id_user',
        'name',
        'email',
        'id_withdraw',
        'value',
        'id_user',
        'date',
        'destination_wallet'
    ];

    protected $guarded = [
        'id',
        'id_user',
        'name',
        'email',
        'id_withdraw',
        'value',
        'id_user',
        'date',
        'destination_wallet'
    ];
}
