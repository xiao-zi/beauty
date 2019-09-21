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
    <link rel="stylesheet" href="/Public/select2/css/select2.min.css">
    <style>
        #product .layui-form-select {
            position: relative;
            display: none;
        }
    </style>
</head>
<body>
    <form class="layui-form" id="form">
        <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>
        <div class="layui-col-md12">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["first-name"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="first_name"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["last-name"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="last_name"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["email"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="email" placeholder="<?php echo ($language["email"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["phoneCode"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <select name="phoneCode" lay-search="">
                            <option value="86">86(<?php echo ($language["China"]); ?>)</option>
                            <option value="1">1(<?php echo ($language["American"]); ?>)</option>
                            <option value="886">886(<?php echo ($language["Taiwan"]); ?>)</option>
                            <option value="1">1(<?php echo ($language["Canada"]); ?>)</option>
                            <option value="850">850(<?php echo ($language["HongKong"]); ?>)</option>
                            <option value="852">852(<?php echo ($language["Macao"]); ?>)</option>
                            <option value="61">61(<?php echo ($language["Australia"]); ?>)</option>
                            <option value="64">64(<?php echo ($language["NewZealand"]); ?>)</option>
                            <option value="44">44(<?php echo ($language["Britain"]); ?>)</option>
                            <option value="34">34(<?php echo ($language["Spain"]); ?>)</option>
                            <option value="39">39(<?php echo ($language["Italy"]); ?>)</option>
                            <option value="33">33(<?php echo ($language["France"]); ?>)</option>
                            <option value="49">49(<?php echo ($language["Germany"]); ?>)</option>
                            <option value="32">32(<?php echo ($language["Belgium"]); ?>)</option>
                            <option value="41">41(<?php echo ($language["Switzerland"]); ?>)</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["phone"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="phone" placeholder="<?php echo ($language["phone"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["date"]); ?>：</label>
                    <div class="layui-input-inline">
                        <input name="date" id="date"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["time"]); ?>：</label>
                    <div class="layui-input-inline">
                        <select name="time" lay-search="">
                            <option value="10:00-11:00">10:00-11:00</option>
                            <option value="11:30-12:30">11:30-12:30</option>
                            <option value="13:00-14:00">13:00-14:00</option>
                            <option value="14:30-15:30">14:30-15:30</option>
                            <option value="16:00-17:00">16:00-17:00</option>
                            <option value="17:30-18:30">17:30-18:30</option>
                        </select>
                    </div>
                </div>
                <div class="layui-block">
                    <label class="layui-form-label"><?php echo ($language["project"]); ?>：</label>
                    <div class="layui-input-block" id="product">
                        <select class="select" name="product[]" multiple="multiple" style="width:100%;">
                            <?php if(is_array($product)): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
    <script src="/Public/select2/js/select2.min.js"></script>
   <script>
        layui.use(['form','laydate','layer'], function(){
            var layer = layui.layer,laydate = layui.laydate;
            //日期
            laydate.render({
                elem: '#date',
                type: 'date',
                trigger: 'click'
            });
        });
   </script>
    <script>
        $(document).ready(function() {
            $('.select').select2();
        });
        function subData(){
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Reservation/createReservationData',
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