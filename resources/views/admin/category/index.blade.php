<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/admin/css/ch-ui.admin.css">
	<link rel="stylesheet" href="/admin/font/css/font-awesome.min.css">
    <script type="text/javascript" src="/admin/js/jquery.js"></script>
    <script type="text/javascript" src="/admin/js/ch-ui.admin.js"></script>
</head>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i>-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">分类管理</a> &raquo; 分类展示
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>分类管理</h3>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{'/admin/category/add'}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="/admin/category/index"><i class="fa fa-plus"></i>全部分类</a>
                    <a href="/admin/category/index"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>分类名字</th>
                        <th>分类标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($info as $vol)
                    <tr>
                        <td class="tc">
                            <input type="text" name="cate_order" onchange="changeorder(this,'{{$vol->cate_id}}')" value="{{$vol->cate_order}}">
                        </td>
                        <td class="tc">{{$vol->cate_id}}</td>
                        <td>
                            <a href="#">{{$vol->_cate_name}}</a>
                        </td>
                        <td>{{$vol->cate_title}}</td>
                        <td>{{$vol->cate_view}}</td>
                        <td>
                            <a href="/admin/category/edit/{{$vol->cate_id}}">修改</a>
                            <a href="javascript:;" onclick="del(this,{{$vol->cate_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>


<div class="page_nav">

</div>
                </div>
            </div>
        </div>
    </form>
    <script src="/layer/layer.js"></script>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeorder(obj,cate_id){
            var cate_order = $(obj).val();
            $.post('{{"/admin/category/changeorder"}}',{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function(data){
               if(data.success==true)
               {
                   layer.msg(data.msg,{icon:6});
               }else
               {
                   layer.msg(data.msg,{icon:5});
               }
            });
        }

        function del(obj,cate_id)
        {
            layer.confirm('您确定要删除吗？',{
                btn:['确定','取消'],
            },function(){
                $.post('/admin/category/del/'+cate_id,{'_token':'{{csrf_token()}}'},function(data){
                    if(data.success == true)
                    {
                        layer.msg(data.msg,{icon:6});
                        window.location.href = window.location.href;
                    }else
                    {
                        layer.msg(data.msg,{icon:5});
                    }
                })
            },function(){});

        }
    </script>


</body>
</html>