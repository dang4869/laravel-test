<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['order_code','order_name','email','address','phone','notes','order_status','payment','province','district','wards'];
    function order_detail(){
        return $this->hasOne('App\Order_detail');
    }
}
