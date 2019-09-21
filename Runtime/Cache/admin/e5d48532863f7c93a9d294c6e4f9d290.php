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
    <fieldset class="layui-elem-field">
        <legend><?php echo ($language["screen"]); ?></legend>
        <div class="layui-field-box">
            <form class="layui-form" id="form">
                <div class="layui-col-md12">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo ($language["ActivityLevel"]); ?>：</label>
                            <div class="layui-input-inline" style="width: 130px;">
                                <select name="ActivityLevel" lay-search="">
                                    <option value=""><?php echo ($language["ActivityLevel"]); ?></option>
                                    <option value="active"><?php echo ($language["active"]); ?></option>
                                    <option value="inactive"><?php echo ($language["inactive"]); ?></option>
                                    <option value="masked"><?php echo ($language["masked"]); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo ($language["source"]); ?>：</label>
                            <div class="layui-input-inline" style="width: 130px;">
                                <select name="source" lay-search="">
                                    <option value=""><?php echo ($language["source"]); ?></option>
                                    <?php if(is_array($source)): $i = 0; $__LIST__ = $source;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo ($language["country"]); ?>：</label>
                            <div class="layui-input-inline">
                                <select name="country" lay-search="">
                                    <option value=""><?php echo ($language["country"]); ?></option>
                                    <?php if(is_array($country)): $i = 0; $__LIST__ = $country;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo ($language["recommender"]); ?>：</label>
                            <div class="layui-input-inline">
                                <select name="recommender" lay-search="">
                                    <option value=""><?php echo ($language["recommender"]); ?></option>
                                    <?php if(is_array($customerGroup)): $i = 0; $__LIST__ = $customerGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">生日：</label>
                            <div class="layui-input-inline" style="width: 130px;">
                                <input name="birthday" autocomplete="off" id="birth" placeholder="MM-dd" class="layui-input" type="text">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><?php echo ($language["keywords"]); ?>：</label>
                            <div class="layui-input-inline" style="width: 300px;">
                                <input name="keywords"  placeholder="<?php echo ($language["keywords"]); ?>" class="layui-input" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-inline" style="float:right;margin-right:25px;">
                            <button class="layui-btn" onclick="ajax_get_table('form',1,true)" type="button"><?php echo ($language["search"]); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend><?php echo ($language["coupon"]); ?></legend>
        <div class="layui-field-box">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo ($language["coupon"]); ?>：<b style="color:#d70101">*</b></label>
                    <div class="layui-input-block">
                        <select class="category"  lay-search="" lay-filter="coupon" id="coupon" >
                            <?php if(is_array($coupon)): $i = 0; $__LIST__ = $coupon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <div class="layui-form">
        <table class="layui-table" lay-size="sm">
            <colgroup>
                <col width="5">
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
                <th><input name="" lay-skin="primary" lay-filter="allChoose" type="checkbox"></th>
                <th><?php echo ($language["Membership-card"]); ?></th>
                <th><?php echo ($language["nickname"]); ?></th>
                <th><?php echo ($language["phone"]); ?></th>
                <th><?php echo ($language["email"]); ?></th>
                <th><?php echo ($language["sex"]); ?></th>
                <th><?php echo ($language["birth"]); ?></th>
                <th><?php echo ($language["ActivityLevel"]); ?></th>
                <th><?php echo ($language["Entry-time"]); ?></th>
            </tr>
            </thead>
            <tbody id="ajax_return">
            </tbody>
        </table>
    </div>
    <fieldset class="layui-elem-field">
        <button class="layui-btn layui-btn-small" onClick="giveCoupon()" type="button"><?php echo ($language["give"]); ?></button>
    </fieldset>
    <div id="demo7"></div>
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery-2.0.3.min.js"></script>
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
   </script>
    <!--搜索功能-->
    <script type="text/javascript">
        window.onload=function(){
            ajax_get_table('form',1,true);
        }
        function ajax_get_table(tab,page,flag){
            $.ajax({
                type : "POST",
                url:"/admin.php/Coupon/ajaxCustomer/p/"+page,//+tab,
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
                                    ajax_get_table('form',page_num,false);
                                }
                            });

                        });
                    }
                }
            });
        }
    </script>
    <script>
        function giveCoupon(){
            var Arr = new Array();
            $("input[name='checkid[]']").each(function(index,item){
                var ch = $(this).is(':checked');
                if(ch){
                    Arr[index] = $(this).val();
                };
            });
            if (Arr === undefined || Arr.length == 0) {
                layer.msg('请选择赠送的用户');
                return false;
            }
            var idArr = new Array();
            for(var i=0;i<Arr.length;i++){
                if(Arr[i] > 0){
                    idArr.push(Arr[i]) ;
                }
            }
            var couponId = $('#coupon').val();
            if(couponId <=  0){
                layer.msg('请选择赠送的优惠券');
            }
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Coupon/giveCoupon',
                data:{arr:idArr,id:couponId},// 你的formid
                dataType:'json',
                success: function(json){
                    console.log(json)
                    if(json.rel==1){
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["define"]); ?>'] //按钮
                        }, function(){
                            layer.closeAll();
                        });
                    }else{
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["close"]); ?>'] //按钮
                        }, function(){
                            layer.closeAll();
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>