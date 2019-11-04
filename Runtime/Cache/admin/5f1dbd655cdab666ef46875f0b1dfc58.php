<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>信息管理系统界面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Public/Layui/css/layui.css" media="all">
    <script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>

    <!--head css块-->
    
    <style type="text/css">
        /*设置 layui 表格中单元格内容溢出可见样式*/
        .table-overlay .layui-table-view,
        .table-overlay .layui-table-box,
        .table-overlay .layui-table-body {
            overflow: visible;
        }

        .table-overlay .layui-table-cell {
            height: auto;
            overflow: visible;
        }
    </style>

    <!--head script块-->
    
</head>
<body>
    <!-- 内容区 -->
    
    <!--左边-->
    <form class="layui-form" id="form" action="" style='margin-top: 25px;'>
        <div class="layui-col-md8">
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["customer"]); ?>：</label>
                <div class="layui-input-block" id="customer">
                    <select name="cid" lay-search="" lay-filter="customer" >
                        <option value=""><?php echo ($language["customer"]); ?></option>
                        <?php if(is_array($customerGroup)): $i = 0; $__LIST__ = $customerGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" id="package" style="display: none">
                <label class="layui-form-label"><?php echo ($language["package"]); ?>：</label>
                <div class="layui-input-block">
                    <select name="pid" lay-search="" lay-filter="package">
                        <option value=""><?php echo ($language["customer"]); ?></option>
                        <?php if(is_array($customerGroup)): $i = 0; $__LIST__ = $customerGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" id="packageInfo">
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
                        <select name="status" lay-search="" >
                            <option value=""><?php echo ($language["Payment-status"]); ?></option>
                            <option value="1"><?php echo ($language["Unpaid"]); ?></option>
                            <option value="2" selected><?php echo ($language["Paid"]); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><?php echo ($language["remark"]); ?></label>
                <div class="layui-input-block">
                    <textarea name="remark" placeholder="<?php echo ($language["remark"]); ?>" class="layui-textarea"></textarea>
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

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form'], function(){
            var form = layui.form, layer = layui.layer;

            form.on('select(customer)', function(data){
                var id = data.value;
                $.ajax({
                    type: 'get',
                    url:'/admin.php/Order/getCustomerPackage/cid/'+id,
                    dataType:'json',
                    success: function(json){
                        $("#package select").html("");
                        $("#package").css("display",'block');
                        $.each(json, function(key, val) {
                            var option = $("<option>").val(val.id).text(val.title);
                            $("#package select").append(option);
                            form.render('select');
                        });
                        getPackageValue();
                    }
                });
            })
            form.on('select(package)', function(data){
                getPackageValue();
            })
        });

        function getPackageValue(){
            var value = $("#package select").val();
            $.ajax({
                type: 'get',
                url:'/admin.php/Order/findCustomerPackage/id/'+value,
                dataType:'json',
                success: function(json){
                    $("#packageInfo").html("");
                    $("#packageInfo").append(json.json);
                    $("#table-show").html("");
                    $("#table-show").append(json.html);
                }
            });
        }
    </script>
    <script>
        function subCreate(){
            console.log($('#form').serialize())
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Order/package',
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