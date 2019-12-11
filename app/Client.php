<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    protected $fillable = [
        'id',
        'name',
        'usdc_wallet',
        'email',
    ];

    protected $guarded = [
        'id',
        'name',
        'usdc_wallet',
        'email',
    ];
}
