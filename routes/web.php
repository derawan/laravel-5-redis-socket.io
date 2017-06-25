<?php
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\Orders;
use App\User;

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'middleware' => 'role:waiter'], function () {
    Route::get('/waiter','WaiterController@getOrders');
    Route::post('/waiter/order','OrdersController@newOrder');
    Route::post('/waiter/delete','OrdersController@delete');
});

Route::group(['middleware' => 'auth', 'middleware' => 'role:cook'], function () {
    Route::get('/cook','CookController@getOrders');
    Route::post('/cook/done','OrdersController@done');
});

Route::group(['middleware' => 'auth', 'middleware' => 'role:manager'], function () {
    Route::get('/manager','ManagerController@getUsers');
    Route::post('/manager/change','ManagerController@changeRole');
});



