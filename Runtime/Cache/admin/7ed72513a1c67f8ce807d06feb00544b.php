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
    
    <fieldset class="layui-elem-field">
        <legend><?php echo ($language["jurisdiction"]); echo ($language["menu-management"]); ?></legend>
        <div class="layui-field-box">
            <div class="layui-form-item">
                <div class="layui-inline" style="float:right;margin-right:25px;">
                    <button class="layui-btn" onclick="create()" type="button"><?php echo ($language["created"]); ?></button>
                </div>
            </div>
        </div>
        <div class="layui-form">
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="30">
                    <col width="30">
                    <col width="30">
                    <col width="100">
                    <col width="100">
                </colgroup>
                <thead>
                <tr>
                    <th>ID</th>
                    <th><?php echo ($language["module"]); ?></th>
                    <th><?php echo ($language["chinese"]); echo ($language["title"]); ?></th>
                    <th><?php echo ($language["description"]); ?></th>
                    <th><?php echo ($language["operation"]); ?></th>
                </tr>
                </thead>
                <tbody id="ajax_return">
                <?php if(is_array($group)): foreach($group as $k=>$val): ?><tr>
                        <td><?php echo ($val["id"]); ?></td>
                        <td><?php echo ($val["module"]); ?></td>
                        <td><?php echo ($val["title"]); ?></td>
                        <td><?php echo ($val["description"]); ?></td>
                        <td>
                            <button class="layui-btn layui-btn-sm" onclick="update(<?php echo ($val["id"]); ?>)"><?php echo ($language["updated"]); echo ($language["jurisdiction"]); ?></button>
                        </td>
                    </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </fieldset>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form','element'], function(){
            var $ = layui.jquery
                    ,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
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
                ,content: '/admin.php/Group/createGroup'
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
                ,content: '/admin.php/Group/updateGroup/id/'+id
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

</body>
</html>