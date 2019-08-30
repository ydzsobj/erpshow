<?php

namespace App\Http\Controllers\Erp;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    // 获取管理员列表
    public function get_admin(Request $request)
    {
        $keywords = $request->get('keywords');
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit :10;
        if($keywords){
            $count = Admin::where(function ($query) use ($keywords){
                $query->where('admin_id','like',"%{$keywords}%")
                    ->orWhere('admin_name','like',"%{$keywords}%");
            })->count();
            $data = Admin::where(function ($query) use ($keywords){
                $query->where('admin_id','like',"%{$keywords}%")
                    ->orWhere('admin_name','like',"%{$keywords}%");
            })->orderBy('id','desc')->offset(($page-1)*$limit)->limit($limit)->get();
        }else{
            $count = Admin::count();
            $data = Admin::orderByDesc('admin_id')->offset(($page-1)*$limit)->limit($limit)->get();
        }

        return response()->json(['code'=>0,'count'=>$count,'msg'=>'成功获取数据！','data'=>$data]);
    }
}
