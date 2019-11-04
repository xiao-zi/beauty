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
        <legend><?php echo ($language["package-list"]); ?></legend>
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
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="100">
                <col width="200">
            </colgroup>
            <thead>
            <tr>
                <th><?php echo ($language["title"]); ?></th>
                <th><?php echo ($language["original"]); ?></th>
                <th><?php echo ($language["present"]); ?></th>
                <th><?php echo ($language["Term-validity"]); ?></th>
                <th><?php echo ($language["create-time"]); ?></th>
                <th><?php echo ($language["update-time"]); ?></th>
                <th><?php echo ($language["operation"]); ?></th>
            </tr>
            </thead>
            <tbody id="ajax_return">
                <?php if(is_array($data)): foreach($data as $k=>$vo): ?><tr id="<?php echo ($vo["id"]); ?>">
                        <td><?php echo ($vo["title"]); ?></td>
                        <td><?php echo ($vo["original"]); ?></td>
                        <td><?php echo ($vo["present"]); ?></td>
                        <td><?php echo ($vo["date"]); ?></td>
                        <td><?php echo (date("Y-m-d H:i:s",$vo["create_at"])); ?></td>
                        <td><?php echo (date("Y-m-d H:i:s",$vo["update_at"])); ?></td>
                        <td>
                            <button class="layui-btn layui-btn-mini" style="background-color: #17a2b8;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></button>
                            <button class="layui-btn layui-btn-mini" style="background-color: #17a2b8;" onclick="showDetail(<?php echo ($vo["id"]); ?>)"><?php echo ($language["See-details"]); ?></button>
                            <button class="layui-btn layui-btn-mini" style="background-color: red;" onclick="packageDelete(<?php echo ($vo["id"]); ?>)"><?php echo ($language["delete"]); ?></button>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form'], function(){});
        /*打开创建页面*/
        function create(){
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '<?php echo ($language["created"]); ?>'
                ,area: ['100%', '100%']
                ,shade: 0
                ,maxmin: true
                ,id:'created'
                ,content: '/admin.php/Package/create',
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
                ,id:'updated'
                ,content: '/admin.php/Package/update/id/'+id,
            });
        }
        /*打开详情页面*/
        function showDetail(id){
            $.getJSON('/admin.php/Package/showDetail/id/'+id,function(json){
                layer.open({
                    type: 1
                    ,title: false //不显示标题栏
                    ,closeBtn: false
                    ,area: '50%;'
                    ,shade: 0.8
                    ,btn: ['关闭']
                    ,btnAlign: 'c'
                    ,moveType: 1 //拖拽模式，0或者1
                    ,content:json
                    ,success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                    }
                });
            });
        }
        /*删除套餐*/
        function packageDelete(id){
            $.getJSON('/admin.php/Package/deletePackage/id/'+id,function(json){
                if(json.rel == 1){
                    $('tr#'+id).remove();
                    layer.msg(json.msg, {icon: 1});
                }else{
                    layer.msg(json.msg, {icon: 2});
                }
            });
        }
    </script>

</body>
</html>