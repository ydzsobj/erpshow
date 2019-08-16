<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductGoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductGoodsController extends Controller
{
    //获取产品列表
    public function index(Request $request)
    {

        $keywords = $request->get('keywords');
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit :10;
        //getSql();
        if($keywords){
            //$count = Product::where('id',$keywords)->orWhere('product_name','like',"%{$keywords}%")->count();
            //$data = Product::where('id',$keywords)->orWhere('product_name','like',"%{$keywords}%")->offset(($page-1)*$limit)->limit($limit)->get();
            $count = ProductGoods::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('sku_name','like',"%{$keywords}%");
            })->count();
            $data = ProductGoods::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('sku_name','like',"%{$keywords}%");
            })->orderBy('id','desc')->offset(($page-1)*$limit)->limit($limit)->get();

        }else{
            $count = ProductGoods::count();
            $data = ProductGoods::orderByDesc('id')->offset(($page-1)*$limit)->limit($limit)->get();
        }

        return response()->json(['code'=>0,'count'=>$count,'msg'=>'成功获取数据！','data'=>$data]);
    }

    //获取单个产品信息
    public function show($id)
    {

        $data = ProductGoods::find($id);
        return response()->json(['code'=>0,'msg'=>'成功获取数据！','data'=>$data]);
    }
}
