<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CompositeKeyModelHelper;

class DetailsOrder extends Model
{

    public $incrementing = false;
    protected $table="details_orders";
    #protected $primaryKey = 'order_id';
    public $timestamps = false;
    public $keyType = 'integer';
    protected $fillable = [
        'order_id',
        'pro_id',
        'qty',
        'price',
    ];

    // protected function setKeysForSaveQuery(Builder $query)
    // {
    //     return $query->where('order_id', $this->getAttribute('order_id'))
    //                  ->where('pro_id', $this->getAttribute('pro_id'));
    // }

    

}
