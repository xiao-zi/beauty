<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Public/Layui/css/layui.css" media="all">
</head>
<body>
<form class="layui-form" id="form">

    <div class="layui-tab-item layui-show">
        <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["model"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="model" placeholder="<?php echo ($language["please-input-model"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["chinese"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="chinese" placeholder="<?php echo ($language["please-input-chinese"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["english"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="english" placeholder="<?php echo ($language["please-input-english"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
    </div>
</form>
<script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
<script>
    layui.use(['form'], function(){});
</script>
<script>
    function subData(){
        $.ajax({
            cache: true,
            type: 'POST',
            url:'/admin.php/Language/createLanguageData',
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
                    }, function(){
                        parent.window.layer_back();
                    });
                }
            }
        });
    }
</script>
</body>
</html>