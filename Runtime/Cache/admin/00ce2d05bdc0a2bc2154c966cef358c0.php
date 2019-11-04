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
    
    <style>
        .layui-col-space10 {
            margin: 18px;
        }
        .layui-card {
            margin-bottom: 15px;
            border-radius: 2px;
            background-color: #fff;
            box-shadow: 0 1px 2px 0 rgba(105,99,99,0.5);
        }
    </style>

    <!--head script块-->
    
</head>
<body>
    <!-- 内容区 -->
    
    <!--左边-->
    <form class="layui-form" id="form" action="">
        <div class="layui-col-md8">
            <div class="layui-row layui-col-space10">
                <div class="layui-card">
                    <div class="layui-card-header"><?php echo ($language["Default-picture"]); ?></div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space10">
                            <div class="layui-upload">
                                <div class="layui-upload-list">
                                    <img class="layui-upload-img" name="IMAGE"  id="demo2" src="<?php echo ($config["IMAGE"]); ?>">
                                </div>
                                <input name="IMAGE" id="url2"   value="<?php echo ($config["IMAGE"]); ?>" autocomplete="off" class="layui-input" type="hidden">
                                <button type="button"   class="layui-btn" id="test2"><?php echo ($language["Upload-default-images"]); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header"><?php echo ($language["Website-logo"]); ?></div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space10">
                        <div class="layui-upload">
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="demo1"   src="<?php echo ($config["WEBSITE-LOG"]); ?>">
                            </div>
                            <input name="WEBSITE-LOG" id="url1"    value="<?php echo ($config["WEBSITE-LOG"]); ?>" autocomplete="off" class="layui-input" type="hidden">
                            <button type="button"  class="layui-btn" id="test1"><?php echo ($language["Upload-website-LOGO"]); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header"><?php echo ($language["Time-Zone-Selection"]); ?></div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space10">

                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label" style="width: 140px;"><?php echo ($language["Time-Zone-Selection"]); ?></label>
                                <div class="layui-input-inline">
                                    <select name="WEBSITE-TIME-ZONE" lay-verify="required"  lay-search="">
                                        <?php switch($config["WEBSITE-TIME-ZONE"]): case "Asia/Shanghai": ?><option value="Asia/Shanghai" selected><?php echo ($language["Chinese-time"]); ?></option><option value="America/New_York"><?php echo ($language["America-time"]); ?></option><?php break;?>
                                            <?php default: ?><option value="Asia/Shanghai"><?php echo ($language["Chinese-time"]); ?></option><option value="America/New_York" selected><?php echo ($language["America-time"]); ?></option><?php endswitch;?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-layout-admin">
            <div class="layui-input-block">
                <div class="layui-footer" style="left: 0;text-align: center;">
                    <a class="layui-btn" onclick="subData()"><i class="layui-icon">&#xe605;</i><?php echo ($language["Submission"]); ?> </a>
                    <!--<button type="reset" class="layui-btn layui-btn-primary"><i class="layui-icon">&#x1006;</i><?php echo ($language["Reset"]); ?></button>-->
                </div>
            </div>
        </div>
    </form>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form','element','upload'], function(){
            var $ = layui.jquery,form = layui.form
                    ,element = layui.element,//Tab的切换功能，切换事件监听等，需要依赖element模块
                    upload = layui.upload;//上传图片
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: '/admin.php/Config/handleUpload'
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
            var uploadInst1 = upload.render({
                elem: '#test2'
                ,url: '/admin.php/Config/handleUpload'
                ,done: function(json){
                    if(json.code == 0){
                        layer.msg(json.msg, {icon: 6});
                        $('#demo2').attr('src', json.src); //图片链接（base64）
                        $('#url2').val(json.src)
                    }else{
                        layer.msg(json.msg, {icon: 5});
                    }
                }
            });
        });
        /*关闭二级页面*/
        function layer_back(){
            layer.closeAll();
        }
    </script>
    <script>
        function subData(){
            $.ajax({
                cache: true,
                type: 'post',
                url:'/admin.php/Config/SpecialConfigData',
                data:$('#form').serialize(),// 你的formid
                dataType:'json',
                success: function(json){
                    if(json.rel==1){
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["define"]); ?>'] //按钮
                        }, function(){
                            layer_back();
                        });
                    }else{
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["close"]); ?>'] //按钮
                        }, function(){
                            layer_back();
                        });
                    }
                }
            });
        }
    </script>

</body>
</html>