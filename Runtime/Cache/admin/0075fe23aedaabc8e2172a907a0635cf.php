<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Public/Layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/Public/Layui/css/template.css">
</head>
<body>
<form class="layui-form" id="form">
    <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>
    <div class="layui-col-md8">
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label"><?php echo ($language["customer"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <select name="data[cid]" lay-search="customer">
                        <option value=""><?php echo ($language["customer"]); ?></option>
                        <?php if(is_array($customer)): $i = 0; $__LIST__ = $customer;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label"><?php echo ($language["package"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <select name="data[pid]" lay-search=""  lay-filter="package">
                        <option value=""><?php echo ($language["package"]); ?></option>
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label"><?php echo ($language["Payment-method"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <?php echo ($pay); ?>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label"><?php echo ($language["Payment-status"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <select name="data[status]" lay-search="" >
                        <option value=""><?php echo ($language["Payment-status"]); ?></option>
                        <option value="1"><?php echo ($language["Unpaid"]); ?></option>
                        <option value="2" selected><?php echo ($language["Paid"]); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-col-md4">
        <div class="layui-form-item" id="table-show">
        </div>
    </div>
    <div class="layui-form-item layui-layout-admin">
        <div class="layui-footer" style="left: auto;">
            <a class="layui-btn" onclick="subCreate()"><i class="layui-icon">&#xe605;</i><?php echo ($language["Submission"]); ?> </a>
            <button type="reset" class="layui-btn layui-btn-primary"><i class="layui-icon">&#x1006;</i><?php echo ($language["Reset"]); ?></button>
        </div>
    </div>
</form>
<script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
<script>
    layui.use(['form','layer'], function(){
        var form = layui.form
                ,layer = layui.layer;
        //监听select下拉选中事件
        form.on('select(package)', function(data) {
            var value = data.value;
            $.ajax({
                cache: true,
                type: 'get',
                url:'/admin.php/Package/showDetail?id='+value,
                dataType:'json',
                success: function(json){
                    $('#table-show').text('')
                    $('#table-show').append(json)
                }
            });
        });
    });
</script>
<script>
    function subCreate(){
        $.ajax({
            cache: true,
            type: 'POST',
            url:'/admin.php/Package/buy',
            data:$('#form').serialize(),// 你的formid
            dataType:'json',
            success: function(json){
                if(json.rel==1){
                    layer.confirm(json.msg, {
                        btn: ['<?php echo ($language["define"]); ?>'] //按钮
                    }, function(){
                        layer.close(layer.index);
                    });
                }else{
                    layer.confirm(json.msg, {
                        btn: ['<?php echo ($language["close"]); ?>'] //按钮
                    }, function(){
                        layer.close(layer.index);
                    });
                }
            }
        });
    }
</script>
</body>
</html>