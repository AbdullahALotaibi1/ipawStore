<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppleFiles extends Model
{
    protected $fillable = [
        'file_name',
        'file_extension',
    ];
}
