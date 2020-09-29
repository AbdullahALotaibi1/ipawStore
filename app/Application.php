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


    // MARK: - Relationship functions
    function groups()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    function applicationsInfo()
    {
        return $this->belongsTo(ApplicationsInfo::class, 'app_info_id', 'id');
    }


}
