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
        <legend><?php echo ($language["screen"]); ?></legend>
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
                <col width="30">
                <col width="200">
                <col width="200">
                <col width="60">
                <col width="10">
                <col width="100">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th><input name="" lay-skin="primary" lay-filter="allChoose" type="checkbox"></th>
                <th>ID</th>
                <th><?php echo ($language["Chinese-title"]); ?>（<?php echo ($language["English-title"]); ?>）</th>
                <th><?php echo ($language["Link-Address"]); ?></th>
                <th><?php echo ($language["status"]); ?></th>
                <th><?php echo ($language["sort"]); ?></th>
                <th><?php echo ($language["Option-type"]); ?></th>
                <th><?php echo ($language["operation"]); ?></th>
            </tr>
            </thead>
            <tbody id="ajax_return">
            <?php if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
                    <td class="check">
                        <input name="checkid[]" lay-skin="primary" value="<?php echo ($vo["id"]); ?>" type="checkbox">
                    </td>
                    <td class="parentTd" id="<?php echo ($vo["id"]); ?>"><i class="layui-icon layui-icon-triangle-r"></i><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["title"]); ?>（<?php echo ($vo["english"]); ?>）</td>
                    <td><?php echo ($vo["url"]); ?></td>
                    <td>
                        <?php switch($vo["status"]): case "activation": ?><input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch"  lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status" checked ><?php break;?>
                            <?php default: ?>	<input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch" lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status"  ><?php endswitch;?>
                    </td>
                    <td><?php echo ($vo["sort"]); ?></td>
                    <td>
                        <?php switch($vo["type"]): case "select": echo ($language["drop-down"]); break;?>
                            <?php default: echo ($language["Title-Link"]); endswitch;?>
                    </td>
                    <td><button class="layui-btn layui-btn-mini" style="background-color: #17a2b8;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></button></td>
                </tr>
                <?php if(is_array($vo["child"])): foreach($vo["child"] as $k=>$val): ?><tr style="background-color: #C9C9C9;" hidden>
                        <td class="check">
                            <input name="checkid[]" lay-skin="primary" value="<?php echo ($val["id"]); ?>" type="checkbox">
                        </td>
                        <td><?php echo ($val["id"]); ?></td>
                        <td class="childTd" pid="<?php echo ($val["pid"]); ?>"><?php echo ($val["title"]); ?>（<?php echo ($val["english"]); ?>）</td>
                        <td><?php echo ($val["url"]); ?></td>
                        <td>
                            <?php switch($vo["status"]): case "activation": ?><input type="checkbox"  data-id="<?php echo ($val["id"]); ?>" lay-skin="switch"  lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status" checked ><?php break;?>
                                <?php default: ?>	<input type="checkbox"  data-id="<?php echo ($val["id"]); ?>" lay-skin="switch" lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status"  ><?php endswitch;?>
                        </td>
                        <td><?php echo ($val["sort"]); ?></td>
                        <td>
                            <?php switch($val["type"]): case "select": echo ($language["drop-down"]); break;?>
                                <?php default: echo ($language["Title-Link"]); endswitch;?>
                        </td>
                        <td><button class="layui-btn layui-btn-mini" style="background-color: #17a2b8;" onclick="update(<?php echo ($val["id"]); ?>)"><?php echo ($language["updated"]); ?></button></td>
                    </tr><?php endforeach; endif; endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <div id="demo7"></div>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        layui.use(['form', 'laydate'], function(){
            var $ = layui.jquery, form = layui.form;
            $(".layui-table").find("td.parentTd").on("click", function () {
                var idStr = $(this).prop("id");
                var childTr = $(".layui-table").find("td.childTd");
                console.log($(this).children(i).hasClass('layui-icon-triangle-r'))
                if($(this).children(i).hasClass('layui-icon-triangle-r')){
                    $(this).children('i').removeClass('layui-icon-triangle-r')
                    $(this).children('i').addClass('layui-icon-triangle-d')
                }else if($(this).children(i).hasClass('layui-icon-triangle-d')){
                    $(this).children('i').addClass('layui-icon-triangle-r')
                    $(this).children('i').removeClass('layui-icon-triangle-d')
                }

                for (var i = 0; i < childTr.length; i++) {
                    if ($(childTr.eq(i)).attr("pid")) {
                        if ($(childTr[i]).attr("pid") == idStr) {
                            if ($(childTr[i]).parent("tr").css("display") == "none") {
                                $(childTr[i]).parent("tr").show();
                            } else {
                                $(childTr[i]).parent("tr").hide();
                            }
                        }
                    }
                }
            });
            //全选
            form.on('checkbox(allChoose)', function(data){
                var child = $(data.elem).parents('table').find('tbody .check input[type="checkbox"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });

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
                    url:'/admin.php/Menu/updateStatus',
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
                ,area: ['500px', '500px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Menu/createMenu'
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
                ,area: ['500px', '500px']
                ,shade: 0
                ,maxmin: true
                ,id:'print_iframe'
                ,content: '/admin.php/Menu/updateMenu/id/'+id
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
        }
    </script>

</body>
</html>