<?php

namespace App\Http\Controllers\Erp;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('erp.attribute_value.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //创建操作
        $attribute = Attribute::where('attr_show',1)->get();
        return view('erp.attribute_value.create',compact('attribute'));
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
        $result = AttributeValue::insert($data = [
            'attr_value_name'=>$request->attr_value_name,
            'attr_value_english'=>$request->attr_value_english,
            'attr_id'=>$request->attr_id,
            'code'=>$request->code,
            'attr_value_show'=>$request->attr_value_show,
            'created_at' => date('Y-m-d H:i:s', time()),
        ]);
        /*$data = [
            'attr_value_name'=>$request->attr_value_name,
            'attr_value_english'=>$request->attr_value_english,
            'attr_id'=>$request->attr_id,
            'attr_value_show'=>$request->attr_value_show,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $id = DB::table('attribute_value')->insertGetId($data);

        $result = Attribute::find($request->attr_id);
        $result->attr_value = $request->attr_value_name;
        $result->attr_value_ids = $id;*/

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
        $attribute = Attribute::where('attr_show',1)->get();
        $data = AttributeValue::find($id);
        return view('erp.attribute_value.edit', compact('data','attribute'));
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
        $result = AttributeValue::find($id);
        $result->attr_value_name = $request->attr_value_name;
        $result->attr_value_english = $request->attr_value_english;
        $result->attr_id = $request->attr_id;
        $result->code = $request->code;
        $result->attr_value_show = $request->attr_value_show;
        $result->updated_at = date('Y-m-d H:i:s', time());
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
