<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";
    protected $primaryKey = "pro_id";
    public $timestamps = false;
    protected $fillable = [
        'pro_name',
        'pro_des',
        'pro_price',
        'pro_stock',
        'pro_image',
        'cate_id',
    ];
}
