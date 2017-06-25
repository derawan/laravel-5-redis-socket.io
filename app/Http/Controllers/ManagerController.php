<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ManagerController extends Controller
{
	public function getUsers () {
	$users=  User::select('id','name', 'email')->get();
	return view('manager', compact('users'));
}

	public function changeRole (Request $request) {
		$user = $request->user;
		$role = $request->role;
		if ($role == 'delete') {
			User::destroy($user);
		} else {
			$userRole = User::find($user);
			$userRole->update([
				'role' => $role
			]);
			$userRole->save;
		}
	}
}
