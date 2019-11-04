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
    <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>
    <blockquote class="layui-elem-quote"><?php echo ($language["english"]); echo ($language["title"]); echo ($language["not-repeat"]); ?></blockquote>
    <input name="id"   value="<?php echo ($info["id"]); ?>" autocomplete="off" class="layui-input" type="hidden">
    <div class="layui-col-md12">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["please-input"]); echo ($language["title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-inline">
                    <input name="module" placeholder="<?php echo ($language["please-input"]); echo ($language["english"]); echo ($language["title"]); ?>" value="<?php echo ($info["module"]); ?>" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo ($language["chinese"]); echo ($language["title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-inline">
                    <input name="title" placeholder="<?php echo ($language["please-input"]); echo ($language["chinese"]); echo ($language["title"]); ?>"  value="<?php echo ($info["title"]); ?>" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-block">
                <label class="layui-form-label"><?php echo ($language["jurisdiction"]); echo ($language["explain"]); ?>：</label>
                <div class="layui-input-block">
                        <textarea  name="description" class="layui-textarea" placeholder="<?php echo ($language["please-input"]); echo ($language["jurisdiction"]); echo ($language["explain"]); ?>"><?php echo ($info["description"]); ?></textarea>
                </div>
            </div>
            <fieldset class="layui-elem-field">
                <legend><?php echo ($language["select"]); echo ($language["jurisdiction"]); ?></legend>
                <table class="layui-table" lay-size="sm">
                    <colgroup>
                        <col width="50">
                        <col width="1200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th><?php echo ($language["parent-level"]); echo ($language["menu"]); ?></th>
                        <th><?php echo ($language["child-level"]); echo ($language["menu"]); ?></th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php if(is_array($menu)): foreach($menu as $k=>$val): ?><tr>
                            <td>
                                <?php if(in_array(($val['id']), explode(',', ($rule)))): ?>
                                <input type="checkbox" name="rules[]" lay-skin="primary" value="<?php echo ($val["id"]); ?>"  class="parent<?php echo ($val["id"]); ?>" title="<?php echo ($val["title"]); ?>" checked lay-filter="p_all"/>
                                <?php else: ?>
                                <input type="checkbox" name="rules[]" lay-skin="primary" value="<?php echo ($val["id"]); ?>"  class="parent<?php echo ($val["id"]); ?>" title="<?php echo ($val["title"]); ?>"  lay-filter="p_all"/>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(is_array($val["child"])): $i = 0; $__LIST__ = $val["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(in_array(($vo['id']), explode(',', ($rule)))): ?>
                                    <input type="checkbox" name="rules[]" lay-skin="primary" value="<?php echo ($vo["id"]); ?>" pid="<?php echo ($vo["pid"]); ?>" class="child<?php echo ($vo["pid"]); ?>" checked title="<?php echo ($vo["title"]); ?>" lay-filter="c_all"/>
                                    <?php else: ?>
                                    <input type="checkbox" name="rules[]" lay-skin="primary" value="<?php echo ($vo["id"]); ?>" pid="<?php echo ($vo["pid"]); ?>" class="child<?php echo ($vo["pid"]); ?>" title="<?php echo ($vo["title"]); ?>" lay-filter="c_all"/>
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
            </fieldset>

        </div>
    </div>
</form>
<script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>

<script>
    layui.use(['form'], function () {
        var form = layui.form,
                $ = layui.jquery;

        form.on('checkbox(p_all)', function(obj){
            var value = obj.value;
            var checked = obj.elem.checked;
            if (checked == true) {
                $(".child"+value).prop("checked", true);
                form.render('checkbox');
            } else {
                $(".child"+value).prop("checked", false);
                form.render('checkbox');
            }
        })
        form.on('checkbox(c_all)', function(obj){
            var value = obj.elem.attributes.pid.value;
            var checked = obj.elem.checked;
            if (checked == true) {
                var pChecked = $(".parent"+value).prop('checked');
                if(pChecked == false){
                    $(".parent"+value).prop("checked", true);
                    form.render('checkbox');
                }
            }
        })

    });



    function subData(){
        $.ajax({
            cache: true,
            type: 'POST',
            url:'/admin.php/Group/updateGroupData',
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