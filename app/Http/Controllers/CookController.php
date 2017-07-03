<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

class CookController extends Controller
{
    public function getOrders(){
	    $orders = Orders::all()->reverse();
	    return view('cook', compact('orders'));
    }
}
