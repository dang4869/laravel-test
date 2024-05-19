<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orders_detail';
    protected $fillable = ['order_id','product_id','product_qty','total'];
    function order(){
        return $this->belongsTo('App\Order');
    }
    function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
