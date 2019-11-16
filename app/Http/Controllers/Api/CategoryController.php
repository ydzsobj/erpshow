<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //获取分类列表
    public function index(Request $request)
    {
        $keywords = $request->get('keywords');
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit :10;
        if($keywords){
            $count = Category::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('category_name','like',"%{$keywords}%");
            })->count();
            $data = Category::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('category_name','like',"%{$keywords}%");
            })->orderBy('id','desc')->offset(($page-1)*$limit)->limit($limit)->get();
        }else{
            $count = Category::count();
            $data = Category::with('type')->orderByDesc('id')->offset(($page-1)*$limit)->limit($limit)->get();
        }

        return response()->json(['code'=>0,'count'=>$count,'msg'=>'成功获取数据！','data'=>$data]);
    }


}
