<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";
    protected $primaryKey = "cate_id";
    public $timestamps = false;
    protected $fillable = [
        'cate_name',
        'cate_des',
    ];
}
