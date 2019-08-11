<?php

namespace App\Http\Controllers\Erp;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('erp.attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = (new Category())->tree();
        return view('erp.attribute.create', compact('category'));
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
        $result = Attribute::insert([
            'attr_name'=>$request->attr_name,
            'attr_english'=>$request->attr_english,
            'attr_value'=>'',
            'attr_value_ids'=>'',
            'attr_show'=>$request->attr_show,
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
        $attribute_value = AttributeValue::where('attr_id',$id)->get();
        $data = Attribute::find($id);
        $dataArray = explode(',',$data->attr_value_ids);
        return view('erp.attribute.edit', compact('data','attribute_value','dataArray'));
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
        $attribute_value = AttributeValue::where('attr_id',$id)->get();
        foreach($attribute_value as $key=>$value){
            if(in_array($value->id,$request->attr_value_ids)){
                $attr_value[$key]['attr_value_id'] = $value->id;
                $attr_value[$key]['attr_value_name'] = $value->attr_value_name;
            }
        }

        //更新操作
        $result = Attribute::find($id);
        $result->attr_name = $request->attr_name;
        $result->attr_english = $request->attr_english;
        $result->attr_value = serialize($attr_value);
        $result->attr_value_ids = implode(",", $request->attr_value_ids);
        $result->attr_show = $request->attr_show;
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



    //自定义
    public function get_attr(Request $request)
    {
        $type = Category::find($request->category_id)->type;
        if($type){
            foreach(explode(',',$type->attr_ids) as $key=>$value){
                $attr= Attribute::find($value);
                $data[$key]=$attr;
                $data[$key]['attrValue']=unserialize($attr->attr_value);
            }
        }else{
            $data = '';
        }

        return $data;
        //返回信息
        //return response()->json($data);

    }








}
