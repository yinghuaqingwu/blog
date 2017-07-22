<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::all()){
            $rules = [
                'code' => 'required|captcha',
                'password'=> 'required',
            ];
            $notices = [
                'code.required' => '验证码必须填写',
                'code.captcha' => '验证码输入错误',
                'password.required' => '密码能不能为空',
            ];
            $validator = Validator::make($input,$rules,$notices);
            if($validator->passes())
            {
                $username = $input['username'];
                $password = $input['password'];
                $rst = Auth::guard('admin')->attempt(['username'=>$username,'password'=>$password]);
                if($rst)
                {
                    return redirect('admin/user/index');
                }else
                {
                    return back();
                }
            }else
            {
                return back()->with('msg','验证码输入错误');
            }
        }else{
            return view('admin/login/login');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login/login');
    }
}
