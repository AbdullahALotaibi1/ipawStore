<?php

namespace App;

use Carbon\Carbon;
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



    // MARK: - Group Functions
    function getLastUpdate()
    {
        return Carbon::parse($this->updated_at)->diffForHumans(now());
    }

    // MARK: - Relationship functions
    function applications()
    {
        return $this->hasMany(Application::class, 'app_info_id', 'id');
    }

}
