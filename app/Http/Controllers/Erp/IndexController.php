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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function blade(Request $request)
    {
        $type=$request->has('type')?$request->input('type'):'index.balde.php';
        \View::addExtension('html','php');
        return  view()->file(public_path().'/layuiadmin/html/'.$type);
    }

    /**
     * 修改个人信息页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminInfo()
    {
        return view('erp.admin.info');
    }

    /**
     * 修改个人信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upSelf(Request $request)
    {
        $data=$request->only('admin_show_name');
        $msg=Admin::where('admin_id',Auth::user()->admin_id)->update($data);
        //添加补货单日志
        if(!$msg){
            return response()->json(['err'=>0,'str'=>'个人信息修改失败！']);
        }
        return response()->json(['err'=>1,'str'=>'修改成功~']);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function password(Request $request)
    {
        if($request->isMethod('get')){
            return view('erp.admin.password');
        }elseif($request->isMethod('post')){
            $data=$request->only('password');
            $data['password']=password_hash($data['password'],PASSWORD_BCRYPT);
            $msg=Admin::where('admin_id',Auth::user()->admin_id)->update($data);
            //添加补货单日志
            if(!$msg){
                return response()->json(['err'=>0,'str'=>'密码修改失败！']);
            }
            return response()->json(['err'=>1,'str'=>'修改成功~']);
        }
    }

    /**
     * 计算器
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jsq()
    {
        return view('erp.tool.jsq');
    }
}
