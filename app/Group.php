<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
      'name',
      'folder',
      'team_id',
      'expiration_date',
      'status'
    ];

    // MARK: - Group Functions
    function getDateExpires()
    {
        return Carbon::parse($this->expiration_date)->diffForHumans(now());
    }

    function getLastUpdate()
    {
        return Carbon::parse($this->updated_at)->diffForHumans(now());
    }

    function getStatus()
    {
        $status = $this->status;
        $returnValue = array('className' => '', 'status' => '');

        if(strtotime($this->expiration_date) <= strtotime(now())){
            $returnValue['status'] = 'منتهية';
            $returnValue['className'] = 'danger';
        }else if($status == ConstantsHelper::DISABLED_GROUP)
        {
            $returnValue['status'] = 'معلقة';
            $returnValue['className'] = 'danger';
        }else if($status == ConstantsHelper::NEED_UPDATE_LOGIN_APPLE_DEVELOPER)
        {
            $returnValue['status'] = 'بحاجة تحديث حساب المطورين';
            $returnValue['className'] = 'dark';

        }else if($this->customers()->count() >= 100)
        {
            $returnValue['status'] = 'الحد الاقصى';
            $returnValue['className'] = 'warning';
        }else if($status == ConstantsHelper::ACTIVE_GROUP){
            $returnValue['status'] = 'متاحة';
            $returnValue['className'] = 'success';
        }

        return $returnValue;
    }

    // MARK: - Relationship functions
    function appleAccount()
    {
        return $this->hasOne(AppleAccount::class);
    }

    function appleFiles()
    {
        return $this->hasOne(AppleFiles::class);
    }

    function customers()
    {
        return $this->hasMany(Customer::class);
    }

    function applications()
    {
        return $this->hasOne(Application::class);
    }

}
