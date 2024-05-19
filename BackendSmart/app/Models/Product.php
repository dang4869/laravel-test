<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['product_name','price','thumbnail','product_desc','product_detail','category_product_id','slug','status'];
    function category_product(){
        return $this->belongsTo('App\Models\CategoryProduct');
    }
    function order_detail(){
        return $this->belongsTo('App\Models\OrderDetail');
    }
}
