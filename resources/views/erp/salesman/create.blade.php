@extends('erp.father.father')
@section('content')
    <div class="layui-fluid">
        <form class="layui-form" action="">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="username" lay-verify="required" lay-reqtext="姓名不能为空" placeholder="请输入姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">电话</label>
                <div class="layui-input-inline">
                    <input type="text" name="phone" placeholder="请输入电话" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="address" placeholder="请输入地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">地区</label>
                <div class="layui-input-inline">
                    <input type="text" name="area" placeholder="请输入地区" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">显示</label>
                <div class="layui-input-inline">
                    <div class="layui-col-md12">
                        <input type="checkbox" name="status" lay-skin="switch" lay-text="ON|OFF" checked>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="form">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>

    </div>


@endsection
@section('js')
    <script>
        //Demo
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).use(['form','upload'], function(){
            var form = layui.form
                ,upload = layui.upload;
            var $=layui.jquery;


            //监听提交
            form.on('submit(form)', function(data){
                //layer.msg(JSON.stringify(data.field));
                if(data.field.status == "on") {
                    data.field.status = "1";
                } else {
                    data.field.status = "0";
                }
                $.ajax({
                    url:"{{url('admins/salesman')}}",
                    type:'post',
                    data:data.field,
                    datatype:'json',
                    success:function (msg) {
                        if(msg=='0'){
                            layer.msg('添加成功！',{icon:1,time:2000},function () {
                                var index = parent.layer.getFrameIndex(window.name);
                                //刷新
                                parent.window.location = parent.window.location;
                                parent.layer.close(index);
                            });
                        }else{
                            layer.msg('添加失败！',{icon:2,time:2000});
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!',{icon:2,time:2000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection
