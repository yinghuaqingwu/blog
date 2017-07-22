<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('admin/user/index');
    }

    public function info() {
        return view('admin/user/info');
    }

    //修改密码
    public function pass(Request $request)
    {
        if($request->isMethod('post'))
        {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $notices = [
                'password.required'=>'新密码不能为空',
                'password.between' => '新密码必须在6-20位之间',
                'password.confirmed' => '两次输入密码不一致',
            ];
            $validator = \Validator::make($request->all(),$rules,$notices);
            $user = \Auth::guard('admin')->user();
            $password_o = $request->input('password_o');
            $password = $request->input('password');
            $validator->after(function($validator) use($password_o,$user){
                if(!\Hash::check($password_o,$user->password)){
                    $validator->errors()->add('password_o','原始密码错误');
                }
            });
            if($validator->fails()){
                return back()->withErrors($validator);
            }else{
                $user->password = bcrypt($password);
                $user->update();
                return redirect('admin/user/info');
            }
        }
        return view('admin/user/pass');
    }
}
