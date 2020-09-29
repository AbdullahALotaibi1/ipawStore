<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'title',
        'logo_store',
        'app_bundle',
        'description',
        'keywords',
        'conditions_order',
        'status_store',
        'price_order',
        'status_orders',
        'twitter_account',
        'snapchat_account',
        'telegram_account',
        'whatsapp_account'
    ];
}
