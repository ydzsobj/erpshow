<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//后台相关路由
Route::any('/admins/login','Erp\ManagerController@login')->name('login');

Route::middleware(['auth:check'])->group(function(){
    Route::get('/logout',function(){
        Auth::logout();
        return redirect('/admins/login');
    });
    Route::get('/admins/index','Erp\IndexController@index');
    Route::get('/admins/home_page','Erp\IndexController@homePage');
    Route::get('/admins/admin_info','Erp\IndexController@adminInfo');
    Route::any('/admins/password','Erp\IndexController@password');
    Route::post('/admins/up_self','Erp\IndexController@upSelf');
    Route::get('/admins/jsq','Erp\IndexController@jsq');
});