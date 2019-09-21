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
        #product .layui-form-select,#category .layui-form-select{
            position: relative;
            display: none;
        }
    </style>
</head>
<body>
    <form class="layui-form" id="form">
        <blockquote class="layui-elem-quote"><?php echo ($language["explain-red"]); ?><b style="color:#d70101">*</b><?php echo ($language["required-important"]); ?></blockquote>
        <blockquote class="layui-elem-quote"><?php echo ($language["Description-of-coupon-products"]); ?></blockquote>
        <div class="layui-col-md8">
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="data[title]" placeholder="<?php echo ($language["title"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Preferential-mode"]); ?>:<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input type="radio" name="data[type]" value="1" title="<?php echo ($language["Full-reduction"]); ?>" checked="">
                    <input type="radio" name="data[type]" value="2" title="<?php echo ($language["discount"]); ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Validity-period-of-coupon"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input type="text" name="data[date]" class="layui-input" id="data" placeholder=" - ">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Coupon-Rules"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <table class="layui-table" id="add_rule" style="width:100%">
                        <colgroup>
                            <col width="200">
                            <col width="200">
                            <col width="90">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?php echo ($language["consumption"]); ?></th>
                            <th><?php echo ($language["discount"]); ?></th>
                            <th><?php echo ($language["operation"]); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input name="data[rule][0][money]"  autocomplete="off"  class="layui-input" type="text"></td>
                            <td><input name="data[rule][0][discount]"  autocomplete="off"  class="layui-input" type="text"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button class="layui-btn layui-btn-small" onClick="add_rule()" type="button"><?php echo ($language["add"]); ?></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="layui-form-mid layui-word-aux">金额代表消费金额，折扣代表优惠力度，满减的折扣取值范围不能大于消费金额，折扣的取值范围0~100,90代表9折</div>
                </div>

            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["project"]); ?>：</label>
                <div class="layui-input-block" id="product">
                    <select class="product" name="data[product][]" multiple="multiple" style="width:100%;">
                        <?php if(is_array($product)): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Product-Classification"]); ?>：</label>
                <div class="layui-input-block" id="category">
                    <select class="category" name="data[category][]" multiple="multiple" style="width:100%;">
                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><?php echo ($language["Notes-on-coupons"]); ?>：</label>
                <div class="layui-input-block">
                    <textarea placeholder="<?php echo ($language["Notes-on-coupons"]); ?>" name="data[remark]" class="layui-textarea"></textarea>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header"><?php echo ($language["Upload-pictures"]); ?></div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space10">
                        <div class="layui-upload">
                            <div class="layui-upload-list">
                                <img id="demo1"   src="<?php echo ($config["IMAGE"]); ?>">
                            </div>
                            <input name="data[img]" id="url1"    value="<?php echo ($config["IMAGE"]); ?>" autocomplete="off" class="layui-input" type="hidden">
                            <button type="button"  class="layui-btn" id="test1"><?php echo ($language["Upload-pictures"]); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
    <script src="/Public/select2/js/select2.min.js"></script>
   <script>
        layui.use(['form','laydate','layer','upload'], function(){
            var layer = layui.layer,laydate = layui.laydate, upload = layui.upload;//上传图片
            //日期范围
            laydate.render({
                elem: '#data'
                ,range: true
            });

            var uploadInst = upload.render({
                elem: '#test1'
                ,url: '/admin.php/Coupon/handleUpload'
                ,done: function(json){
                    if(json.code == 0){
                        layer.msg(json.msg, {icon: 6});
                        $('#demo1').attr('src', json.src); //图片链接（base64）
                        $('#url1').val(json.src)
                    }else{
                        layer.msg(json.msg, {icon: 5});
                    }
                }
            });
        });
   </script>
    <script>
        function add_rule(){

            var tb = document.getElementById("add_rule");
            var oTr = tb.rows[1];
            var newTr = oTr.cloneNode(true);
            tb.getElementsByTagName("tbody")[0].insertBefore(newTr, tb.rows[tb.rows.length - 1]);

            newTr.cells[0].firstChild.name = "data[rule]["+newTr.rowIndex+"][money]";

            newTr.cells[1].firstChild.name = "data[rule]["+newTr.rowIndex+"][discount]";

            newTr.cells[2].innerHTML  = '<button class="layui-btn layui-btn-small" type="button" onClick="delet_tr(\'add_rule\',this)"><?php echo ($language["delete"]); ?></button>';

        }

        function delet_tr(tablen,obj){
            layer.confirm('<?php echo ($language["delete-information"]); ?>', {
                btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //按钮
            }, function(){
                var tb = document.getElementById(tablen);
                tb.deleteRow(obj.parentElement.parentElement.rowIndex);
                layer.closeAll();
            }, function(){
                layer.msg("<?php echo ($language["cancelled-operation"]); ?>", {icon: 1});
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.product').select2();
            $('.category').select2();
        });
        function createCoupon(){
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Coupon/createCoupon',
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