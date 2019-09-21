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
    
    <link rel="stylesheet" href="/Public/Admin/css/User/drop-down.css" media="all">

    <!--head script块-->
    

</head>
<body>
    <!-- 内容区 -->
    
    <fieldset class="layui-elem-field">
        <legend><?php echo ($language["screen"]); ?></legend>
        <div class="layui-field-box">
            <form class="layui-form" method="post" name="search-form2" id="search-form2">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["keywords"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 300px;">
                            <input name="keywords"  placeholder="<?php echo ($language["keywords"]); ?>" class="layui-input" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="layui-inline" style="float:right;margin-right:25px;">
                        <button class="layui-btn" onclick="ajax_get_table('search-form2',1,true)" type="button"><?php echo ($language["search"]); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?php echo ($language["users"]); echo ($language["menu-management"]); ?></legend>
    </fieldset>
    <fieldset class="layui-elem-field">
        <div class="layui-field-box">
            <div class="layui-form-item">
                <div class="layui-inline" style="float:right;margin-right:25px;">
                    <button class="layui-btn" onclick="create()" type="button"><?php echo ($language["created"]); ?></button>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="layui-form">
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="30">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="100">
                <col width="50">
                <col width="100">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["head-image"]); ?></th>
                <th><?php echo ($language["account"]); ?></th>
                <th><?php echo ($language["nickname"]); ?></th>
                <th><?php echo ($language["phone"]); ?></th>
                <th><?php echo ($language["email"]); ?></th>
                <th><?php echo ($language["status"]); ?></th>
                <th><?php echo ($language["jurisdiction"]); ?></th>
                <th><?php echo ($language["login-time"]); ?></th>
                <th><?php echo ($language["operation"]); ?></th>
            </tr>
            </thead>
            <tbody id="ajax_return">
            </tbody>
        </table>
    </div>
    <div id="demo7"></div>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form', 'laydate','element'], function(){
            var $ = layui.jquery, form = layui.form, element = layui.element;

            /*修改状态*/
            form.on('switch(status)', function(obj){
                layer.load(1);
                var id = $(this).attr("data-id");
                if(obj.elem.checked){
                    var status = 'activation';
                }else{
                    var status = 'defaulted';
                }
                $.ajax({
                    type: 'POST',
                    url:'/admin.php/User/updateStatus',
                    data:"id="+id+"&status="+status,// 你的formid
                    dataType:'json',
                    success: function(json){
                        layer.closeAll('loading');
                        if(json.rel==1){
                            layer.msg(json.msg);
                        }else{
                            layer.msg(json.msg);
                        }
                    }
                });
            });
        });

        /*打开创建页面*/
        function create(){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["created"]); ?>'
                ,area: ['1000px', '500px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/User/createUser'
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].subData();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }

        /*打开编辑页面*/
        function update(id){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["updated"]); ?>'
                ,area: ['1000px', '500px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/User/updateUser/id/'+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].subData();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        /*打开修改密码页面*/
        function changePassword(id){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["updated"]); ?> <?php echo ($language["password"]); ?>'
                ,area: ['500px', '200px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/User/changePassword/id/'+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].subData();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        function userLogin(id){
            $.ajax({
                type : "POST",
                url:"/admin.php/User/login",//+tab,
                data : "id="+id,// 你的formid
                success: function(data){
                    parent.window.location.href="/admin.php/Index/index.html";
                }
            })
        }
        /*关闭二级页面*/
        function layer_back(){
            layer.closeAll();
            window.location.reload();
        }
    </script>

    <!--搜索功能-->
    <script type="text/javascript">
        window.onload=function(){
            ajax_get_table('search-form2',1,true);
        }
        function ajax_get_table(tab,page,flag){
            $.ajax({
                type : "POST",
                url:"/admin.php/User/ajaxUser/p/"+page,//+tab,
                data : $('#'+tab).serialize(),// 你的formid
                success: function(data){
                    layer.msg('<?php echo ($language["waiting-for-queries"]); ?>...', {
                        icon: 1,   // 成功图标
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){ // 关闭后执行的函数
                        $("#ajax_return").html('');
                        $("#ajax_return").append(data.html);
                    });
                    if(flag){
                        layui.use(['laypage', 'layer'], function(){
                            var laypage = layui.laypage
                                    ,layer = layui.layer;
                            var num = data.pagenum;
                            var pages = data.pages;
                            //调用分页
                            laypage.render({
                                elem: 'demo7'
                                ,count: num
                                ,limit:pages
                                ,layout: ['count', 'prev', 'page', 'next', 'skip']
                                ,jump: function(obj){
                                    var page_num = obj.curr;
                                    ajax_get_table('search-form2',page_num,false);
                                }
                            });

                        });
                    }
                }
            });
        }
    </script>

</body>
</html>