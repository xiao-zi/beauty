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
                <div class="layui-inline" style="float:left;margin-right:25px;">
                    <button class="layui-btn" onclick="sendMessage()" type="button"><?php echo ($language["send-short-messages"]); ?></button>
                </div>
                <div class="layui-inline" style="float:left;margin-right:25px;">
                    <button class="layui-btn" onclick="sendMail()" type="button"><?php echo ($language["send-mail"]); ?></button>
                </div>
                <div class="layui-inline" style="float:right;margin-right:25px;">
                    <button class="layui-btn" onclick="create()" type="button"><?php echo ($language["created"]); ?></button>
                </div>
            </div>
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
                ,id:'print_iframe'
                ,content: '/admin.php/Customer/createCustomer'
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
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Customer/updateCustomer/id/'+id
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
        /*关闭二级页面*/
        function layer_back(){
            layer.closeAll();
            window.location.reload();
        }
    </script>

    <script>
        //发送短信
        function sendMessage(){
            var productArr = new Array();
            $("input[name='checkid[]']").each(function(index,item){
                var ch = $(this).is(':checked');
                if(ch){
                    productArr[index] = $(this).val();
                };
            });
            if (productArr === undefined || productArr.length == 0) {
                alert('请选择需要发送的客户')
                return false;
            }
            var idArr = new Array();
            for(var i=0;i<productArr.length;i++){
                if(productArr[i] > 0){
                    idArr.push(productArr[i]) ;
                }
            }
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["send-short-messages"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Customer/getPhoneArr?id='+idArr
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].sendMessage();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
            });
        }
        //发送短信
        function sendMail(){
            var productArr = new Array();
            $("input[name='checkid[]']").each(function(index,item){
                var ch = $(this).is(':checked');
                if(ch){
                    productArr[index] = $(this).val();
                };
            });
            if (productArr === undefined || productArr.length == 0) {
                alert('请选择需要发送的客户')
                return false;
            }
            var idArr = new Array();
            for(var i=0;i<productArr.length;i++){
                if(productArr[i] > 0){
                    idArr.push(productArr[i]) ;
                }
            }
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["send-mail"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Customer/getEmailArr?id='+idArr
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].sendMessage();
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
                url:"/admin.php/Customer/ajaxCustomer/p/"+page,//+tab,
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