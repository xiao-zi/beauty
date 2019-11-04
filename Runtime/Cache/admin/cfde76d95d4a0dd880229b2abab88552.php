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
                        <label class="layui-form-label"><?php echo ($language["Administrators"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="aid" lay-search="">
                                <option value=""><?php echo ($language["Administrators"]); ?></option>
                                <?php if(is_array($userGroup)): $i = 0; $__LIST__ = $userGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["realname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["customer"]); ?>：</label>
                        <div class="layui-input-inline">
                            <select name="cid" lay-search="">
                                <option value=""><?php echo ($language["customer"]); ?></option>
                                <?php if(is_array($customerGroup)): $i = 0; $__LIST__ = $customerGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["username"]); ?>（<?php echo ($val["cartnum"]); ?>）</option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["Payment-status"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="status" lay-search="">
                                <option value=""><?php echo ($language["Payment-status"]); ?></option>
                                <option value="0"><?php echo ($language["Outstanding-account"]); ?></option>
                                <option value="1"><?php echo ($language["Arrival-account"]); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["Payment-method"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <select name="status" lay-search="">
                                <option value=""><?php echo ($language["Payment-method"]); ?></option>
                                <option value="1"><?php echo ($language["Pay-card"]); ?></option>
                                <option value="2"><?php echo ($language["cash"]); ?></option>
                                <option value="3"><?php echo ($language["Bank-transfer"]); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["start-time"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <input name="start" autocomplete="off" id="start" class="layui-input" type="text">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["end-time"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 130px;">
                            <input name="end" autocomplete="off" id="end" class="layui-input" type="text">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><?php echo ($language["Order-number"]); ?>：</label>
                        <div class="layui-input-inline" style="width: 300px;">
                            <input name="keywords"  placeholder="<?php echo ($language["Order-number"]); ?>" class="layui-input" type="text" autocomplete="off">
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
        <legend><?php echo ($language["Order-list-management"]); ?></legend>
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
                <col width="5">
                <col width="5">
                <col width="80">
                <col width="50">
                <col width="50">
                <col width="50">
                <col width="100">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><input name="" lay-skin="primary" lay-filter="allChoose" type="checkbox"></th>
                <th><?php echo ($language["id"]); ?></th>
                <th><?php echo ($language["sender"]); ?></th>
                <th><?php echo ($language["phone"]); ?></th>
                <th><?php echo ($language["Receiver"]); ?></th>
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
        layui.use(['form', 'laydate','element','laypage'], function(){
            var $ = layui.jquery, form = layui.form, element = layui.element,laydate = layui.laydate,laypage = layui.laypage;
            //日期
            laydate.render({
                elem: '#start',
                type: 'date'
            });
            laydate.render({
                elem: '#end',
                type: 'date'
            });
            var num = <?php echo ($page["pagenum"]); ?>;
            var pages = <?php echo ($page["pages"]); ?>;
            var page = <?php echo ($page["page"]); ?>;
            //调用分页
            laypage.render({
                elem: 'demo7'
                ,count: num
                ,limit:pages
                ,curr:page
                ,layout: ['count', 'prev', 'page', 'next', 'skip']
//                ,jump: function(obj){
//                    var page_num = page;
//                    console.log(page_num);
////                    ajax_get_table('search-form2',page_num,false);
//                }
            });
        });
    </script>
    <script>
        /*打开创建页面*/
        function create(){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["created"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_frame1'
                ,content: '/admin.php/Order/createOrder'
                ,
            });
        }
        //短信内容展示
        function showDetail(id){
            $.getJSON('/admin.php/Order/showMessage',{'id':id},function(json){
                layer.open({
                    type: 1
                    ,title: false //不显示标题栏
                    ,closeBtn: false
                    ,area: '300px;'
                    ,shade: 0.8
                    ,btn: ['关闭']
                    ,btnAlign: 'c'
                    ,moveType: 1 //拖拽模式，0或者1
                    ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">'+json.message+'</div>'
                    ,success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                    }
                });
            });
        }
    </script>

</body>
</html>