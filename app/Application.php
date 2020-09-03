<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'app_info_id',
        'app_ipa',
        'group_id',
        'app_plist',
    ];
}
