<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResignApp extends Model
{
    protected $fillable = [
        'customer_id',
        'app_info_id',
        'app_name',
        'app_bundle',
        'app_ipa',
    ];
}
