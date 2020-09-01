<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'full_name',
        'phone_number',
        'udid',
        'device_id',
        'device_type',
        'device_model',
        'register_coupon',
        'status',
    ];

    // MARK: - Relationship functions
    function groups()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
