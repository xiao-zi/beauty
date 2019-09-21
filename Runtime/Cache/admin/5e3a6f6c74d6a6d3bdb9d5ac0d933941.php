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
                        <input name="first_name"  value="<?php echo ($data["first_name"]); ?>" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["last-name"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="last_name"  value="<?php echo ($data["last_name"]); ?>" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["email"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="email" placeholder="<?php echo ($language["email"]); ?>"  value="<?php echo ($data["email"]); ?>" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["phoneCode"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <select name="phoneCode" lay-search="">
                            <?php switch($data["phone_code"]): case "86": ?><option value="86" selected>86(<?php echo ($language["China"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="86">86(<?php echo ($language["China"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "1": ?><option value="1" selected>1(<?php echo ($language["American"]); ?>)</option><?php break;?>
                                <?php default: ?> <option value="1">1(<?php echo ($language["American"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "886": ?><option value="886" selected>886(<?php echo ($language["Taiwan"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="886">886(<?php echo ($language["Taiwan"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "1": ?><option value="1" selected>1(<?php echo ($language["Canada"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="1">1(<?php echo ($language["Canada"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "850": ?><option value="850" selected>850(<?php echo ($language["HongKong"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="850">850(<?php echo ($language["HongKong"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "852": ?><option value="852" selected>852(<?php echo ($language["Macao"]); ?>)</option><?php break;?>
                                <?php default: ?> <option value="852">852(<?php echo ($language["Macao"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "61": ?><option value="61" selected>61(<?php echo ($language["Australia"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="61">61(<?php echo ($language["Australia"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "64": ?><option value="64" selected>64(<?php echo ($language["NewZealand"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="64">64(<?php echo ($language["NewZealand"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "44": ?><option value="44" selected>44(<?php echo ($language["Britain"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="44">44(<?php echo ($language["Britain"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "34": ?><option value="34" selected>34(<?php echo ($language["Spain"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="34">34(<?php echo ($language["Spain"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "39": ?><option value="39" selected>39(<?php echo ($language["Italy"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="39">39(<?php echo ($language["Italy"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "33": ?><option value="33" selected>33(<?php echo ($language["France"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="33">33(<?php echo ($language["France"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "49": ?><option value="49" selected>49(<?php echo ($language["Germany"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="49">49(<?php echo ($language["Germany"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "32": ?><option value="32" selected>32(<?php echo ($language["Belgium"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="32">32(<?php echo ($language["Belgium"]); ?>)</option><?php endswitch;?>
                            <?php switch($data["phone_code"]): case "41": ?><option value="41" selected>41(<?php echo ($language["Switzerland"]); ?>)</option><?php break;?>
                                <?php default: ?><option value="41">41(<?php echo ($language["Switzerland"]); ?>)</option><?php endswitch;?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["phone"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="phone" placeholder="<?php echo ($language["phone"]); ?>" value="<?php echo ($data["phone"]); ?>" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["date"]); ?>：</label>
                    <div class="layui-input-inline">
                        <input name="date" id="date"  value="<?php echo ($data["date"]); ?>" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["time"]); ?>：</label>
                    <div class="layui-input-inline">
                        <select name="time" lay-search="">
                            <?php switch($data["time"]): case "10:00-11:00": ?><option value="10:00-11:00" selected>10:00-11:00</option><?php break;?>
                                <?php default: ?><option value="10:00-11:00">10:00-11:00</option><?php endswitch;?>
                            <?php switch($data["time"]): case "11:30-12:30": ?><option value="11:30-12:30" selected>11:30-12:30</option><?php break;?>
                                <?php default: ?><option value="11:30-12:30">11:30-12:30</option><?php endswitch;?>
                            <?php switch($data["time"]): case "13:00-14:00": ?><option value="13:00-14:00" selected>13:00-14:00</option><?php break;?>
                                <?php default: ?><option value="13:00-14:00">13:00-14:00</option><?php endswitch;?>
                            <?php switch($data["time"]): case "14:30-15:30": ?><option value="14:30-15:30" selected>14:30-15:30</option><?php break;?>
                                <?php default: ?><option value="14:30-15:30">14:30-15:30</option><?php endswitch;?>
                            <?php switch($data["time"]): case "16:00-17:00": ?><option value="16:00-17:00" selected>16:00-17:00</option><?php break;?>
                                <?php default: ?><option value="16:00-17:00">16:00-17:00</option><?php endswitch;?>
                            <?php switch($data["time"]): case "17:30-18:30": ?><option value="17:30-18:30" selected>17:30-18:30</option><?php break;?>
                                <?php default: ?><option value="17:30-18:30">17:30-18:30</option><?php endswitch;?>
                        </select>
                    </div>
                </div>
                <div class="layui-block">
                    <label class="layui-form-label"><?php echo ($language["project"]); ?>：</label>
                    <div class="layui-input-block" id="product">
                        <select class="select" name="product[]" multiple="multiple" style="width:100%;">
                            <?php if(is_array($product)): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; if(in_array($val['id'],$data['product'])): ?>
                                <option value="<?php echo ($val["id"]); ?>" selected><?php echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)</option>
                                <?php else: ?>
                                <option value="<?php echo ($val["id"]); ?>" ><?php echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)</option>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
        function updateData(){
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Reservation/updateReservationData?id='+<?php echo ($data['id']); ?>,
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