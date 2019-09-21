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
                <label class="layui-form-label"><?php echo ($language["Link-level"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-inline">
                    <select name="pid" lay-search="">
                        <option value="0"><?php echo ($language["Top-level-links"]); ?></option>
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["Chinese-title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="title" placeholder="<?php echo ($language["please-input-Chinese-title"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["English-title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="english" placeholder="<?php echo ($language["please-input-English-title"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["Link-Address"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="url" placeholder="<?php echo ($language["please-input-Link-Address"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["icon-class"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="icon" placeholder="<?php echo ($language["please-input"]); ?>class" value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["Option-type"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-inline">
                    <select name="type" lay-search="">
                        <option value="select"><?php echo ($language["drop-down"]); ?></option>
                        <option value="head"><?php echo ($language["Title-Link"]); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["sort"]); ?>：</label>
                <div class="layui-input-block">
                    <input name="sort" placeholder="<?php echo ($language["sort"]); ?>" value="0" autocomplete="off" class="layui-input" type="number" lay-verify="number">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["status"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-inline">
                    <select name="status" lay-search="">
                        <option value="activation"><?php echo ($language["activation"]); ?></option>
                        <option value="defaulted"><?php echo ($language["defaulted"]); ?></option>
                    </select>
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
            url:'/admin.php/Menu/createMenuData',
            data:$('#form').serialize(),// 你的formid
            dataType:'json',
            success: function(json){
                console.log(json)
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