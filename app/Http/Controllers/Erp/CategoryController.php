<?php

namespace App\Http\Controllers\Erp;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //首页列表
        return view('erp.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //创建操作
        $category = (new Category())->tree();
        $type = Type::get();
        return view('erp.category.create',compact('category','type'));
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
        $result = Category::insert([
            'category_name'=>$request->category_name,
            'parent_id'=>$request->parent_id,
            'type_id'=>$request->type_id,
            'type_name'=>$request->type_id==0?'':Type::find($request->type_id)->type_name,
            'sort'=>$request->sort
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
        //展示操作
        $data = Category::find($id);
        return view('erp.category.show',compact('data'));
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
        $category = (new Category())->tree();
        $data = Category::find($id);
        $type = Type::get();
        return view('erp.category.edit',compact('data','category','type'));
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
        $result = Category::find($id);
        $result->category_name = $request->category_name;
        $result->parent_id = $request->parent_id;
        $result->type_id = $request->type_id;
        $result->type_name = $request->type_id==0?'':Type::find($request->type_id)->type_name;
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
        //删除操作
        $result = Category::find($id);
        return $result->delete()?'0':'1';
    }
}
