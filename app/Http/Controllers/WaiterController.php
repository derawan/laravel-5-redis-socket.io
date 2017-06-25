<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

class WaiterController extends Controller
{
    public function getOrders(){
	    $orders = new Orders;
	    $getOrders = $orders->getCurrentOrders();
	    return view('waiter',$getOrders);
    }
}
