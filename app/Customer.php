<?php

namespace App;

use Carbon\Carbon;
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
        'device_added',
        'status',
    ];

    // MARK: - Customer functions
    function getAddedDevice()
    {
        return Carbon::parse($this->device_added)->diffForHumans(now());
    }

    function getStatusCompensation()
    {
        $returnValue = array('className' => '', 'status' => '', 'status_id' => '');
        if(strtotime($this->device_added) <= strtotime(now()->subMonths(2))){
            $returnValue['status'] = 'غير مستحق';
            $returnValue['status_id'] = 0;
            $returnValue['className'] = 'danger';
        }else{
            $returnValue['status'] = 'مستحق';
            $returnValue['status_id'] = 1;
            $returnValue['className'] = 'success';
        }
        return $returnValue;
    }
    function getStatus()
    {
        $status = $this->status;
        $returnValue = array('className' => '', 'status' => '');

        if($status == ConstantsHelper::DISABLED_CUSTOMER)
        {
            $returnValue['status'] = 'موقوف';
            $returnValue['className'] = 'danger';
        }else if($status == ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER)
        {
            $returnValue['status'] = 'بحاجة لتحديث الحساب';
            $returnValue['className'] = 'dark';

        }else if($status == ConstantsHelper::ACTIVE_CUSTOMER){
            $returnValue['status'] = 'مفعل';
            $returnValue['className'] = 'success';
        }

        return $returnValue;
    }

    // MARK: - Relationship functions
    function groups()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
