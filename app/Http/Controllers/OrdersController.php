<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Database\Query;
use Auth;

class OrdersController extends Controller
{
    public function newOrder (Request $request) {
		$form = $request->all();
	    $form ['done'] = 'false';
	    $form ['delete'] =  'false';
	    $form ['name'] = Auth::user()->name;
	    $form ['timeOfOrder'] = time();
	    $form ['id'] = Orders::insertGetId($form);
	    event(new \App\Events\NewOrder($form ));
    }

	public function done (Request $request) {
		$id = $request->id;
		$order = Orders::find($id);
		$order->update([
				'done' => 'true'
		]);
		$order->save;
		event(new \App\Events\OrderDone($id));
	}

	public function delete (Request $request){
		$id = $request->delete;
		$order = Orders::find($id);
		$order->update([
				'delete' => 'true'
		]);
		$order->save;
		event(new \App\Events\DeleteOrder($id));
	}


}