<?php

namespace App\Http\Controllers\Erp;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
class ManagerController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request){
        if($request->isMethod('get')){
            return view('erp.login');
        }elseif($request->isMethod('post')){
            $validator=Validator::make($request->all(),[
                "username"=>"required|between:2,16",
                "password"=>"required|between:4,20",
                "captcha"=>"required|size:3|captcha",
            ],[
              "username.required"=>"用户名必须填写",
              "username.between"=>"请输入2-16位的用户名",
              "password.required"=>"密码必须填写",
              "password.between"=>"请输入4-20位的密码",
              "captcha.required"=>"验证码必须填写",
              "captcha.size"=>"验证码长度为3",
              "captcha.captcha"=>"验证码验证失败",
            ]);
            if($validator->fails()){
                return $this->code_response(0, $validator->errors()->first());
            }

            $username=$request->input('username');
            $password=$request->input('password');
            if(Auth::guard('check')->attempt(['admin_name'=>$username,'password'=>$password])){
                $ip=$request->getClientIp();
                $time=date('Y-m-d H:i:s',time());
                $admin=Admin::where('admin_name',$request->input('username'))->first();
                if($admin->admin_use!='1'){
                    return $this->code_response(0, "此账户无法使用!请联系管理员!");
                }
                if($admin->admin_ip!=null){
                    Cookie::forever('l_ip',$admin->admin_ip);
                    Cookie::forever('l_time',$admin->admin_time);
                    Cookie::forever('l_num',$admin->admin_num);
                }else{
                    Cookie::forever('l_ip','初次登陆');
                    Cookie::forever('l_time','初次登陆');
                    Cookie::forever('l_num','初次登陆');
                }
                $admin->admin_ip=$ip;
                $admin->admin_time=$time;
                $admin->admin_num=$admin->admin_num+1;
                $admin->save();
                Log::notice('['.$time.']'.$username.'账户登录于'.$ip);
                return $this->code_response(1,'登录成功');
            }else{
                return $this->code_response(0,'用户名或密码错误');
            };
        }
    }
}
