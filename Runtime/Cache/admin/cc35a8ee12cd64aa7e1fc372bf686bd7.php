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
                        <label class="layui-form-label"><?php echo ($language["Scheduled-time"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <input name="date" autocomplete="off" id="birth" placeholder="MM-dd" class="layui-input" type="text">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["time"]); ?>：</label>
                        <div class="layui-input-inline">
                            <select name="time" lay-search="">
                                <option value=""><?php echo ($language["time"]); ?></option>
                                <option value="10:00-11:00">10:00-11:00</option>
                                <option value="11:30-12:30">11:30-12:30</option>
                                <option value="13:00-14:00">13:00-14:00</option>
                                <option value="14:30-15:30">14:30-15:30</option>
                                <option value="16:00-17:00">16:00-17:00</option>
                                <option value="17:30-18:30">17:30-18:30</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["status"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="status" lay-search="">
                                <option value=""><?php echo ($language["status"]); ?></option>
                                <option value="0"><?php echo ($language["Untreated"]); ?></option>
                                <option value="1"><?php echo ($language["Completed"]); ?></option>
                                <option value="2"><?php echo ($language["Abandoned"]); ?></option>
                            </select>
                        </div>
                    </div>
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
        <legend><?php echo ($language["customer"]); echo ($language["menu-management"]); ?></legend>
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
                <col width="150">
                <col width="50">
                <col width="50">
                <col width="100">
                <col width="200">
                <col width="50">
                <col width="100">
                <col width="100">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["last-name"]); ?>(<?php echo ($language["first-name"]); ?>)</th>
                <th>(<?php echo ($language["phoneCode"]); ?>)<?php echo ($language["phone"]); ?></th>
                <th><?php echo ($language["email"]); ?></th>
                <th><?php echo ($language["Scheduled-time"]); ?></th>
                <th><?php echo ($language["project"]); ?></th>
                <th><?php echo ($language["status"]); ?></th>
                <th><?php echo ($language["Entry-time"]); ?></th>
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
            var $ = layui.jquery, form = layui.form, element = layui.element,laydate = layui.laydate;
             //全选
            form.on('checkbox(allChoose)', function(data){

                var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });

            //日期
            laydate.render({
                elem: '#birth',
                type: 'date'
            });
        });

        /*打开创建页面*/
        function create(){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["created"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe1'
                ,content: '/admin.php/Reservation/createReservation'
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe1").children("iframe").attr("id");
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
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe2'
                ,content: '/admin.php/Reservation/updateReservation/id/'+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe2").children("iframe").attr("id");
                    window.frames[iframe].updateData();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        function updateStatus(id,status){
            $.getJSON('/admin.php/Reservation/updateStatus',{'id':id,'status':status},function(json){
                layer.confirm(json.msg, {
                    btn: ['<?php echo ($language["close"]); ?>'] //按钮
                }, function(){
                    layer_back();
                });
            });
        }
        /*关闭二级页面*/
        function layer_back(){
            layer.closeAll();
        }
    </script>

    <script>
        //发送短信
        function sendMessage(id){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["send-short-messages"]); ?>'
                ,area: ['500px', '300px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe3'
                ,content: '/admin.php/Reservation/getPhone?id='+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe3").children("iframe").attr("id");
                    window.frames[iframe].sendMessage();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        //发送短信
        function sendMail(id){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["send-mail"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe4'
                ,content: '/admin.php/Reservation/getEmail?id='+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe4").children("iframe").attr("id");
                    window.frames[iframe].sendMail();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        function updateRemark(id){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["remark"]); ?>'
                ,area: ['500px', '300px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe5'
                ,content: '/admin.php/Reservation/getRemark?id='+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe5").children("iframe").attr("id");
                    window.frames[iframe].updateRemark();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
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
                url:"/admin.php/Reservation/ajaxReservation/p/"+page,//+tab,
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