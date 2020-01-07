<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the withdraw for the fee.
     */
    public function withdraw()
    {
        return $this->belongsTo('App\Withdraw');
    }
}
