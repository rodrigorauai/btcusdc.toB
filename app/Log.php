<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'logs';

    protected $fillable = [
        'id',
        'id_order',
        'size',
        'product_id',
        'side',
        'done_at',
        'done_reason',
        'type',
        'post_only',
        'created_at_order',
        'fill_fees',
        'filled_size',
        'executed_value',
        'status',
        'settled'
    ];

    protected $guarded = [
        'id',
        'id_order',
        'size',
        'product_id',
        'side',
        'done_at',
        'done_reason',
        'type',
        'post_only',
        'created_at_order',
        'fill_fees',
        'filled_size',
        'executed_value',
        'status',
        'settled'
    ];
    
}
