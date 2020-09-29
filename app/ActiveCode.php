<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    //
    protected $fillable = [
        'code',
        'customer_id',
    ];

    // MARK: - Active Code Functions
    function getLastUpdate()
    {
        return Carbon::parse($this->updated_at)->diffForHumans(now());
    }


    // MARK: - Relationship functions
    function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
