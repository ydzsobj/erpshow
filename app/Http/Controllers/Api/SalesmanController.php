<?php

namespace App\Http\Controllers\Api;

use App\Models\Salesman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesmanController extends Controller
{
    //获取品牌列表
    public function index(Request $request)
    {
        $keywords = $request->get('keywords');
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit :10;
        if($keywords){
            $count = Salesman::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('username','like',"%{$keywords}%");
            })->count();
            $data = Salesman::where(function ($query) use ($keywords){
                $query->where('id','like',"%{$keywords}%")
                    ->orWhere('username','like',"%{$keywords}%");
            })->orderBy('id','desc')->offset(($page-1)*$limit)->limit($limit)->get();
        }else{
            $count = Salesman::count();
            $data = Salesman::orderByDesc('id')->offset(($page-1)*$limit)->limit($limit)->get();
        }

        return response()->json(['code'=>0,'count'=>$count,'msg'=>'成功获取数据！','data'=>$data]);
    }
}
