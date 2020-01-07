<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the client for the blog post.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the fees for the withdraw.
     */
    public function fees()
    {
        return $this->hasMany('App\Fee');
    }
}
