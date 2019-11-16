<?php

namespace App\Http\Controllers\Erp;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //首页列表
        return view('erp.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //创建操作
        return view('erp.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //存储表单信息
        $result = Supplier::insert([
            'supplier_name'=>$request->supplier_name,
            'supplier_url'=>$request->supplier_url,
            'supplier_address'=>$request->supplier_address,
            'supplier_person'=>$request->supplier_person,
            'supplier_phone'=>$request->supplier_phone,
            'supplier_text'=>$request->supplier_text,
            'show'=>$request->show,
            'sort'=>$request->sort,
            'created_at' => date('Y-m-d H:i:s', time()),
        ]);
        return $result ? '0' : '1';
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
        //
        $data = Supplier::find($id);
        return view('erp.Supplier.edit',compact('data'));
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
        $result = Supplier::find($id);
        $result->supplier_name = $request->supplier_name;
        $result->supplier_url = $request->supplier_url;
        $result->supplier_address = $request->supplier_address;
        $result->supplier_person = $request->supplier_person;
        $result->supplier_phone = $request->supplier_phone;
        $result->supplier_text = $request->supplier_text;
        $result->show = $request->show;
        $result->sort = $request->sort;
        return $result->save()?'0':'1';
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
