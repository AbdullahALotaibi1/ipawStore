<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
      'name',
      'folder',
      'status'
    ];

    // MARK: - Relationship functions
    function appleAccount()
    {
        return $this->hasOne(AppleAccount::class);
    }

    function appleFiles()
    {
        return $this->hasOne(AppleFiles::class);
    }
}
