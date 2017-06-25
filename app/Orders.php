<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = "id";
    protected $fillable =  array('table', 'dish', 'email', 'timeToOrder', 'timeOfOrder', 'id', 'done', 'delete', 'name');
    public $timestamps = false;

    public function getCurrentOrders (){
        $orders = Orders::where('delete', 'false')->get()->toArray();
        $orders =array_reverse( $orders);
        return compact('orders');
    }
}
