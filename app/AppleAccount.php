<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppleAccount extends Model
{
    protected $fillable = [
        'apple_email',
        'apple_password',
    ];

    // MARK: - Relationship functions
    function groups()
    {
        return $this->belongsTo(Group::class);
    }

}
