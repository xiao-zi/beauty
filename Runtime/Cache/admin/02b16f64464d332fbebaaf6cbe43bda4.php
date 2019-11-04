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
                    <button class="layui-btn" onclick="javascript:window.location.href='/admin.php/Package/buy'" type="button"><?php echo ($language["purchase"]); ?></button>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="layui-form">
        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="detail">详情</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
    </div>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
        //准备视图对象
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#test'
                ,data: <?php echo ($data); ?>
                ,loading: true
                ,even: true //不开启隔行背景
                ,limit:10
                ,totalRow: true //开启合计行
                ,cols: [[
                    {field:'id', width:50, title: 'ID', sort: true}
                    ,{field:'username', width:200, title: '<?php echo ($language["customer"]); ?>',totalRowText: '合计：'}
                    ,{field:'package', width:200, title: '<?php echo ($language["package"]); ?>'}
                    ,{field:'admin', width:200, title: '<?php echo ($language["Administrators"]); ?>'}
                    ,{field:'term', title: '<?php echo ($language["Expiration-date"]); ?>', width: 200}
                    ,{field:'num', width:100, title: '<?php echo ($language["Number-Use"]); ?>',totalRow: true, sort: true}
                    ,{field:'residue', width:100, title: '<?php echo ($language["Residual-times"]); ?>',totalRow: true, sort: true}
                    ,{field:'create_at', width:200, title: '<?php echo ($language["Buying-time"]); ?>',sort: true}
                    ,{field:'update_at', width:200, title: '<?php echo ($language["Use-time"]); ?>', sort: true}
                    ,{fixed: 'right', title:'<?php echo ($language["operation"]); ?>', toolbar: '#barDemo', minWidth:150}
                ]]
                ,page: true
            });
            //监听行工具事件
            table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                        ,layEvent = obj.event,id = obj.data.id; //获得 lay-event 对应的值
                if(layEvent === 'detail'){
                    $.getJSON('/admin.php/Package/showPackageDetail/id/'+id,function(json){
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
                } else if(layEvent === 'del'){
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({
                            type: 'get',
                            url:'/admin.php/Package/delCustomerPackage/id/'+id,
                            dataType:'json',
                            success: function(json){
                                console.log(json);
                                if(json.rel==1){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                    layer.close(index);
                                }else{
                                    layer.confirm(json.msg, {
                                        btn: ['<?php echo ($language["close"]); ?>'] //按钮
                                    }, function(){
                                        layer.close(index);
                                    });
                                }
                            }
                        });
                    });
                }
            });
        });
    </script>

</body>
</html>