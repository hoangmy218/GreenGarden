<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table="payments";
    protected $primaryKey = "pm_id";
    public $timestamps = false;
    protected $fillable = [
        'pm_name',
    ];
}
