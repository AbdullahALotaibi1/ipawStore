<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BankAccounts extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_image',
        'owner_name',
        'account_number',
        'iban',
    ];

    // MARK: - BankAccounts functions
    function getLastUpdate()
    {
        return Carbon::parse($this->updated_at)->diffForHumans(now());
    }
}
