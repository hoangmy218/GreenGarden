<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table="accounts";
    protected $primaryKey = "acc_id";
    public $timestamps = false;
    protected $fillable = [
        'acc_name',
        'acc_mail',
        'acc_password',
        'acc_phone',
        'acc_dob',
        'acc_address',
        'role_id',
    ];
}
