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
Route::any('/admin/login','Erp\ManagerController@login')->name('login');

Route::middleware(['auth:check'])->group(function(){
    Route::get('/logout',function(){
        Auth::logout();
        return redirect('/admin/login');
    });
    Route::get('/admin/index','Erp\IndexController@index');
    Route::get('/admin/home_page','Erp\IndexController@homePage');
});