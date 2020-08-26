<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    protected $table="order_states";
    protected $primaryKey = "st_id";
    public $timestamps = false;
    protected $fillable = [
        'st_name',
    ];
}
