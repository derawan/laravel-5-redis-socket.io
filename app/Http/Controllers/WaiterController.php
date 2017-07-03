<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

class WaiterController extends Controller
{
    public function getOrders(){
	    $orders = Orders::all()->reverse();
	    return view('waiter', compact('orders'));
    }
}
