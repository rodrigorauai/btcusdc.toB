<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplitValues extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'split_values';

    protected $fillable = [
        'id',
        'id_order',
        'value30',
        'value70',
        'done'
    ];

    protected $guarded = [
        'id',
        'id_order',
        'value30',
        'value70',
        'done'
    ];
}
