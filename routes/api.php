<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//接管路由··
$api = app('Dingo\Api\Routing\Router');
// 配置api版本和路由  V1

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api'],function ($api){
        $api->get('/',function (){
            echo "myApi";
        });
    $api->resource('/category','CategoryController', ['only' => ['index']]);
    $api->resource('/product','ProductController', ['only' => ['index','show']]);
    $api->resource('/product_goods','ProductGoodsController', ['only' => ['index','show']]);
    $api->resource('/type','TypeController', ['only' => ['index']]);
    $api->resource('/attribute','AttributeController', ['only' => ['index']]);
    $api->resource('/attribute_value','AttributeValueController', ['only' => ['index']]);
    $api->resource('/brand','BrandController', ['only' => ['index']]);
    $api->resource('/supplier','SupplierController', ['only' => ['index']]);
    $api->resource('/salesman','SalesmanController', ['only' => ['index']]);
    $api->resource('/storage','StorageController', ['only' => ['index']]);
//    $api->resource('/order','OrderController', ['only' => ['index']]);
    $api->resource('/product_unit','ProductUnitController', ['only' => ['index']]);


    $api->get('/product/sku/{id}','ProductController@sku');


        /******订单相关****/
        $api->get('/orders','OrderController@index')->name('api.orders.index');

    });
});

