<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationsInfo extends Model
{
    protected $fillable = [
        'app_name',
        'app_version',
        'app_bundle',
        'app_icon',
        'app_arrangement',
        'app_size',
        'app_ipa',
        'app_folder'
    ];


    // MARK: - Relationship functions
    function applications()
    {
        return $this->hasMany(Application::class, 'app_info_id', 'id');
    }

}
