<?php

namespace App\Http\Controllers\Erp;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    /**
     * 仓储管理系统首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('erp.father.father');
    }

    /**
     * 控制台页面（需要填充数据，暂时静态页面）
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homePage()
    {
        return view('erp.index.index');
    }
    public function blade(Request $request)
    {
        $type=$request->has('type')?$request->input('type'):'index.balde.php';
        \View::addExtension('html','php');
        return  view()->file(public_path().'/layuiadmin/html/'.$type);
    }
}
