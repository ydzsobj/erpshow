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

Route::group(['prefix'=>'admins','middleware'=>'auth:check','namespace'=>'Erp'],function(){
    Route::get('logout',function(){
        Auth::logout();
        return redirect('/admins/login');
    });
    Route::get('attribute/get_attr','AttributeController@get_attr');

    Route::get('index','IndexController@index');
    Route::get('home_page','IndexController@homePage');
    Route::get('admin_info','IndexController@adminInfo');
    Route::any('password','IndexController@password');
    Route::get('jsq','IndexController@jsq');
    Route::resource('category','CategoryController');
    Route::resource('product','ProductController');
    Route::resource('product_goods','ProductGoodsController');
    Route::resource('type','TypeController');
    Route::resource('attribute','AttributeController');
    Route::resource('attribute_value','AttributeValueController');
    Route::resource('brand','BrandController');
    Route::resource('supplier','SupplierController');
    Route::resource('salesman','SalesmanController');


    Route::post('uploader/pic_upload','UploaderController@picUpload');  //图片异步上传





});
