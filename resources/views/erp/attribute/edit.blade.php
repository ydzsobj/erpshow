@extends('erp.father.father')
@section('content')
    <div class="layui-fluid">
        <form class="layui-form" action=""  lay-filter="formData">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">属性名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="attr_name" lay-verify="required" lay-reqtext="属性名称不能为空"
                           placeholder="请输入属性名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">英文名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="attr_english" lay-verify="required" lay-reqtext="英文名称不能为空"
                           placeholder="请输入英文名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" lay-filter="component-form-element">
                <label class="layui-form-label">属性值</label>
                <div class="layui-input-block">
                    @foreach($attribute_value as $value)
                        <input type="checkbox" value="{{$value->id}}" name="attr_value_ids[]" lay-skin="primary" title="{{$value->attr_value_name}}" @if(in_array($value->id,$dataArray)) checked @endif>
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">属性展示</label>
                <div class="layui-input-inline">
                    <div class="layui-col-md12">
                        <input type="checkbox" name="attr_show" lay-skin="switch" lay-text="ON|OFF">
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
        }).use('form', function(){
            var form = layui.form;
            var $=layui.jquery;

            //表单初始赋值
            form.val('formData', {
                "attr_name": "{{$data->attr_name}}"
                ,"attr_english": "{{$data->attr_english}}"

                ,"attr_show" : "{{$data->attr_show==1 ? 'on' : ''}}"

            });

            //监听提交
            form.on('submit(form)', function(data){
                //layer.msg(JSON.stringify(data.field));
                if(data.field.attr_show == "on") {
                    data.field.attr_show = "1";
                } else {
                    data.field.attr_show = "0";
                }

                $.ajax({
                    url:"{{url('admins/attribute/'.$data->id)}}",
                    type:'put',
                    data:data.field,
                    datatype:'json',
                    success:function (msg) {
                        if(msg=='0'){
                            layer.msg('修改成功！',{icon:1,time:2000},function () {
                                var index = parent.layer.getFrameIndex(window.name);
                                //刷新
                                parent.window.location = parent.window.location;
                                parent.layer.close(index);
                            });
                        }else{
                            layer.msg('修改失败！',{icon:2,time:2000});
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
