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
                        <label class="layui-form-label"><?php echo ($language["over-time"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="over" lay-search="">
                                <option value=""><?php echo ($language["over-time"]); ?></option>
                                <option value="yes"><?php echo ($language["YES"]); ?></option>
                                <option value="no"><?php echo ($language["NO"]); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["USE"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="use" lay-search="">
                                <option value=""><?php echo ($language["USE"]); ?></option>
                                <option value="2"><?php echo ($language["YES"]); ?></option>
                                <option value="1"><?php echo ($language["NO"]); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["users"]); ?>：</label>
                        <div class="layui-input-inline">
                            <select name="user" lay-search="">
                                <option value=""><?php echo ($language["users"]); ?></option>
                                <?php if(is_array($customerGroup)): $i = 0; $__LIST__ = $customerGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["coupon"]); ?>：</label>
                        <div class="layui-input-inline">
                            <select name="coupon" lay-search="">
                                <option value=""><?php echo ($language["coupon"]); ?></option>
                                <?php if(is_array($coupon)): $i = 0; $__LIST__ = $coupon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
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
        <legend><?php echo ($language["User-coupon"]); echo ($language["menu-management"]); ?></legend>
    </fieldset>
    <div class="layui-form">
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="50">
                <col width="80">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["Membership-card"]); ?></th>
                <th><?php echo ($language["nickname"]); ?></th>
                <th><?php echo ($language["coupon"]); ?></th>
                <th><?php echo ($language["give"]); ?></th>
                <th><?php echo ($language["USE"]); ?></th>
                <th><?php echo ($language["over-time"]); ?></th>
                <th><?php echo ($language["user-time"]); ?></th>
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
            var $ = layui.jquery, form = layui.form;
        });
        /**
         * @param id 删除关系表的id
         */
        function delCustomerCoupon(id){
            $.getJSON('/admin.php/Coupon/delCustomerCoupon',{'id':id,},function(json){
                if(json.rel == 1){
                    $('tr#'+id).remove();
                    layer.msg("<?php echo ($language["Successful-deletion"]); ?>", {icon: 1});
                }else{
                    layer.msg("<?php echo ($language["Delete-failed"]); ?>", {icon: 2});
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
                url:"/admin.php/Coupon/ajaxCustomerCoupon/p/"+page,//+tab,
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