<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['client_name','client_surname','email','order_status','total_price'];

    public function products()
    {
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }
}
