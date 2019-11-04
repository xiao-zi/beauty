<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Public/Layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/Public/Admin/css/User/user.css">
    <link rel="stylesheet" href="/Public/Layui/css/template.css">
</head>
<body>
    <form class="layui-form" id="form">
        <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>
        <div class="layui-col-md12">
            <div class="layui-form-item">
                <div class="layui-block">
                    <label class="layui-form-label"><?php echo ($language["content"]); ?><b style="color:#d70101">*</b></label>
                    <div class="layui-inline" style="width: 65%;">
                        <textarea   name="remark" class="layui-textarea" placeholder="<?php echo ($language["content"]); ?>"><?php echo ($data["remark"]); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
   <script>
        layui.use(['form','laydate','layer'], function(){
            var layer = layui.layer,form = layui.form;
            //全选
        });
   </script>
    <script>
        function updateRemark(){
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Reservation/updateRemark?id='+<?php echo ($data['id']); ?>,
                data:$('#form').serialize(),// 你的formid
                dataType:'json',
                success: function(json){
                    if(json.rel==1){
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["define"]); ?>'] //按钮
                        }, function(){
                            parent.window.layer_back();
                        });
                    }else{
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["close"]); ?>'] //按钮
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>