<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="orders";
    protected $primaryKey = "order_id";
    public $timestamps = false;
    protected $fillable = [
        'order_name',
        'order_phone',
        'order_date',
        'order_total',
        'order_note',
        'order_address',
        'user_id',
        'st_id',
        'pm_id',
    ];
}
