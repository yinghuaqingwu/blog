<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/admin/css/ch-ui.admin.css">
	<link rel="stylesheet" href="/admin/font/css/font-awesome.min.css">
</head>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">分类管理</a> &raquo; 编辑分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>分类管理

                    @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                        @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                        @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                    @endif

            </h3>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{'/admin/category/add'}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="/admin/category/index"><i class="fa fa-plus"></i>全部分类</a>
                </div>
            </div>
        </div>

    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="/admin/category/edit/{{$field->cate_id}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="0" @if($field->cate_pid == 0) selected @endif>==顶级分类==</option>
                                @foreach($info as $d)
                                <option value="{{$d->cate_id}}" @if($field->cate_pid == $d->cate_id) selected @endif>{{$d->cate_name}}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text" class="lg" name="cate_name" value="{{$field->cate_name}}">

                            <p></p>

                        </td>
                    </tr>
                    <tr>
                        <th>分类标题：</th>
                        <td>
                            <input type="text" name="cate_title" value="{{$field->cate_title}}">
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <textarea name="cate_keywords">{{$field->cate_keywords}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="cate_description">{{$field->cate_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="cate_order" value="{{$field->cate_order}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>
</html>