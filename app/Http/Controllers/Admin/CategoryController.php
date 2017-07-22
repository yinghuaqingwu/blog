<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    #添加分类操作
    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $input = Input::except('_token');
            $rules = [
                'cate_name' => 'required',
            ];
            $notices = [
                'cate_name.required' => '分类名称不能为空',
            ];
            $validator = \Validator::make($request->all(),$rules,$notices);
            if($validator->passes())
            {
                $res = Category::create($input);
                if($res)
                {
                    return redirect('admin/category/index');
                }else
                {
                    return back()->with('errors','数据填充失败')->withInput();
                }
            }else
            {
                return back()->withErrors($validator);
            }
        }
        $info = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('info'));
    }

    #分类列表展示
    public function index()
    {
        $data = Category::orderBy('cate_order','asc')->get();
        $info = $this->getTree($data);
        return view('admin/category/index',['info'=>$info]);
    }

    public function getTree($data)
    {
        $arr = array();
        foreach($data as $k=>$v)
        {
            if($v->cate_pid == 0)
            {
                $data[$k]['_cate_name'] = '|'.$data[$k]['cate_name'];
                $arr[] = $data[$k];
                foreach($data as $m=>$n)
                {
                    if($n->cate_pid == $v->cate_id)
                    {
                        $data[$m]['_cate_name'] = '||'.$data[$m]['cate_name'];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

    public function changeorder()
    {
        $input = Input::all();
        $cate_id = $input['cate_id'];
        $cate = Category::find($cate_id);
        $cate->cate_order = $input['cate_order'];
        $res = $cate->update();
        if($res)
        {
            return ['success'=>true,'msg'=>'分类排序成功'];
        }else
        {
            return ['success'=>false,'msg'=>'分类排序失败'];
        }
    }

    public function edit(Request $request,$cate_id)
    {
        if($request->isMethod('post'))
        {
            $input = Input::except('_token');
            $res = Category::where('cate_id',$cate_id)->update($input);
            if($res)
            {
                return redirect('admin/category/index');
            }else
            {
                return back()->with('errors','更新失败');
            }
        }

        $field = Category::find($cate_id);
        $info = Category::where('cate_pid',0)->get();
        return view('admin/category/edit',compact('field','info'));
    }

    public function del($cate_id)
    {
        $res = Category::destroy($cate_id);
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($res)
        {
            return [
                'success'=>true,
                'msg' => '删除成功'
            ];
        }else{
            return [
                'success'=>false,
                'msg' => '删除失败'
            ];
        }
    }
}
