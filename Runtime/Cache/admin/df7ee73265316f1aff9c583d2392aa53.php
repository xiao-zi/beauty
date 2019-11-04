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
        <div class="layui-col-md2">
            <div class="profile__heading--avatar-warp">
                <a href="javascript:void(0);">
                    <img src="<?php echo ($config["HEAD-IMAGE"]); ?>" onclick="UploadFile()" alt="<?php echo ($language["head-image"]); ?>" class="profile__heading--avatar avatar-160" id="image" width="160px">
                </a>
                <input type="file" id="file" name="image" value="<?php echo ($config["HEAD-IMAGE"]); ?>" class="file hide">
                <input type="text" id="head" name="image" value="<?php echo ($config["HEAD-IMAGE"]); ?>" class="file hide">
                <div class="profile__avatar-uploader" id="uploadPhoto">
                    <span onclick="UploadFile()"><?php echo ($language["upload"]); ?> <?php echo ($language["head-image"]); ?></span>
                </div>
            </div>
        </div>
        <div class="layui-col-md8">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["account"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="username" placeholder="<?php echo ($language["please-input"]); echo ($language["account"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["nickname"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="realname" placeholder="<?php echo ($language["please-input"]); echo ($language["nickname"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["password"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="password" placeholder="<?php echo ($language["please-input"]); ?> <?php echo ($language["password"]); ?>"  value="" autocomplete="off" class="layui-input" type="password">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["phone"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="phone" placeholder="<?php echo ($language["please-input"]); echo ($language["phone"]); ?>" value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["email"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <input name="email" placeholder="<?php echo ($language["please-input"]); echo ($language["email"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">QQ：</label>
                    <div class="layui-input-inline">
                        <input name="qq" placeholder="<?php echo ($language["please-input"]); ?> QQ"  value="" autocomplete="off" class="layui-input" type="password">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["wechat"]); ?>：</label>
                    <div class="layui-input-inline">
                        <input name="wechat" placeholder="<?php echo ($language["please-input"]); ?> <?php echo ($language["wechat"]); ?>"  value="" autocomplete="off" class="layui-input" type="password">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["status"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <select name="status" lay-search="">
                            <option value="activation"><?php echo ($language["activation"]); ?></option>
                            <option value="defaulted"><?php echo ($language["defaulted"]); ?></option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo ($language["jurisdiction"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-inline">
                        <select class="layui-form" name="grouping" >
                            <?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-block">
                    <label class="layui-form-label"><?php echo ($language["Personal-profile"]); ?></label>
                    <div class="layui-input-block">
                        <textarea  name="describe" class="layui-textarea" placeholder="<?php echo ($language["Personal-profile"]); ?>">

                        </textarea>
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
        console.log($('#form').serialize())
        $.ajax({
            cache: true,
            type: 'POST',
            url:'/admin.php/User/createUserData',
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
    <script>
        function UploadFile(){
            $('#file').click();
        }
        $('#file').on('change',function(e){
            var fileObj = document.getElementById("file").files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                alert("请选择图片或视频");
                return;
            }
            var formFile = new FormData();
            formFile.append("action", "UploadVMKImagePath");
            formFile.append("file", fileObj); //加入文件对象
            var data = formFile;
            $.ajax({
                url: "/admin.php/User/handleUpload",
                data: data,
                type: "Post",
                dataType: "json",
                processData: false,//用于对data参数进行序列化处理 这里必须false
                contentType: false, //必须
                success: function (result) {
                    if (result.code == 0) {
                        $('#image').attr('src',result.src);
                        $('#head').attr('value',result.src);
                    } else {
                        alert(result.msg);
                    }
                },
            })
        });
    </script>
</body>
</html>