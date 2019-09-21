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
    
    <!--head script块-->
    
</head>
<body>
    <!-- 内容区 -->
    
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?php echo ($language["Product-Management-List"]); ?></legend>
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
                <col width="150">
                <col width="150">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["chinese"]); ?></th>
                <th><?php echo ($language["english"]); ?></th>
                <th><?php echo ($language["category"]); ?></th>
                <th><?php echo ($language["status"]); ?></th>
                <th><?php echo ($language["create-time"]); ?></th>
                <th><?php echo ($language["update-time"]); ?></th>
                <th><?php echo ($language["operation"]); ?></th>
            </tr>
            </thead>
            <tbody id="ajax_return">
                <?php if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
                        <td><?php echo ($vo["chinese"]); ?></td>
                        <td><?php echo ($vo["english"]); ?></td>
                        <td><?php echo ($vo["category"]["chinese"]); ?>(<?php echo ($vo["category"]["english"]); ?>)</td>
                        <td>
                            <?php switch($vo["status"]): case "activation": ?><input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch"  lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status" checked ><?php break;?>
                                <?php default: ?>	<input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch" lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status"  ><?php endswitch;?>
                        </td>
                        <td><?php echo (date("Y-m-d H:i:s",$vo["create_at"])); ?></td>
                        <td><?php echo (date("Y-m-d H:i:s",$vo["update_at"])); ?></td>
                        <td><button class="layui-btn layui-btn-mini" style="background-color: #17a2b8;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></button></td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <div id="demo7"></div>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form'], function(){
            var $ = layui.jquery, form = layui.form;
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
                    url:'/admin.php/Product/ProductStatus',
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
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Product/createProduct'
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
                ,content: '/admin.php/Product/updateProduct/id/'+id
                ,btn: ['<?php echo ($language["define"]); ?>','<?php echo ($language["close"]); ?>'] //只是为了演示
                ,yes: function(){
                    var iframe = $("#print_iframe").children("iframe").attr("id");
                    window.frames[iframe].subData(id);
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

</body>
</html>