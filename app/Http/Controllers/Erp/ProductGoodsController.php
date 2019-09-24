<?php

namespace App\Http\Controllers\Erp;

use App\Models\ProductGoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductGoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('erp.product_goods.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //编辑操作
        $data = ProductGoods::find($id);
        return view('erp.product_goods.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //更新操作
        $result = ProductGoods::find($id);
        $result->sku_name = $request->sku_name;
        $result->sku_english = $request->sku_english;
        $result->sku_num = $request->sku_num;
        $result->sku_num_alarm = $request->sku_num_alarm;
        $result->sku_image = $request->sku_image;
        $result->sku_barcode = $request->sku_barcode;
        $result->sku_cost_price = $request->sku_cost_price;
        $result->sku_price = $request->sku_price;
        $result->sku_state = $request->sku_state;
        return $result->save() ? '0' : '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
