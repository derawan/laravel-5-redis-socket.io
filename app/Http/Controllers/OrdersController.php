<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Database\Query;
use Auth;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function newOrder (Request $request) {
		$form = $request->all();
	    $form ['done'] = 'false';
	    $form ['name'] = Auth::user()->name;
	    $form ['timeOfOrder'] = Carbon::now()->timestamp;
	    $form ['created_at'] = Carbon::now();
	    $form ['updated_at'] = Carbon::now();
	    $form ['id'] = Orders::insertGetId($form);
	    event(new \App\Events\NewOrder($form ));
    }

	public function done (Request $request) {
		$id = $request->id;
		Orders::find($id)->update([
				'done' => 'true'
		]);
		event(new \App\Events\OrderDone($id));
	}

	public function delete (Request $request){
		$id = $request->delete;
		$order = Orders::destroy($id);
		event(new \App\Events\DeleteOrder($id));
	}


}
