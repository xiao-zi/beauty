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
                        <label class="layui-form-label"><?php echo ($language["status"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="status" lay-search="">
                                <option value=""><?php echo ($language["status"]); ?></option>
                                <option value="1"><?php echo ($language["available"]); ?></option>
                                <option value="2"><?php echo ($language["Be-overdue"]); ?></option>
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
        <legend><?php echo ($language["Coupon-List-Management"]); ?></legend>
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
                <col width="100">
                <col width="100">
                <col width="50">
                <col width="200">
                <col width="100">
                <col width="100">
                <col width="50">
                <col width="100">
                <col width="100">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["picture"]); ?></th>
                <th><?php echo ($language["title"]); ?></th>
                <th><?php echo ($language["Preferential-mode"]); ?></th>
                <th><?php echo ($language["Coupon-Rules"]); ?></th>
                <th><?php echo ($language["start-time"]); ?></th>
                <th><?php echo ($language["end-time"]); ?></th>
                <th><?php echo ($language["Number-Releases"]); ?></th>
                <th><?php echo ($language["Number-Use"]); ?></th>
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
                ,id:'print_frame1'
                ,content: '/admin.php/Coupon/createCoupon'
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_frame1").children("iframe").attr("id");
                    window.frames[iframe].createCoupon();
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
                ,id:'updateCoupon'
                ,content: '/admin.php/Coupon/updateCoupon/id/'+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#updateCoupon").children("iframe").attr("id");
                    window.frames[iframe].updateCoupon();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        //删除优惠券
        function delCoupon(id){
            layer.confirm('<?php echo ($language["delete-information"]); ?>', {
                btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //按钮
            }, function(){
                $.getJSON('/admin.php/Coupon/deleteCoupon',{'id':id,},function(json){
                    if(json.rel == 1){
                        $('tr#'+id).remove();
                        layer.msg("<?php echo ($language["Successful-deletion"]); ?>", {icon: 1});
                    }else{
                        layer.msg("<?php echo ($language["Delete-failed"]); ?>", {icon: 2});
                    }
                });
            }, function(){
                layer.msg("<?php echo ($language["cancelled-operation"]); ?>", {icon: 1});
            });
        }
        /*关闭二级页面*/
        function layer_back(){
            layer.closeAll();
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
                url:"/admin.php/Coupon/ajaxCoupon/p/"+page,//+tab,
                data : $('#'+tab).serialize(),// 你的formid
                success: function(data){
                    layer.msg('<?php echo ($language["waiting-for-queries"]); ?>...', {
                        icon: 1,   // 成功图标
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){ // 关闭后执行的函数
                        $("#ajax_return").html('');
                        $("#ajax_return").append(data.html);
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
                    });

                }
            });
        }
    </script>

</body>
</html>