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
    
    <style type="text/css">
        /*设置 layui 表格中单元格内容溢出可见样式*/
        .table-overlay .layui-table-view,
        .table-overlay .layui-table-box,
        .table-overlay .layui-table-body {
            overflow: visible;
        }

        .table-overlay .layui-table-cell {
            height: auto;
            overflow: visible;
        }
    </style>

    <!--head script块-->
    
</head>
<body>
    <!-- 内容区 -->
    
    <!--左边-->
    <form class="layui-form" id="form" action="">
        <div class="layui-col-md12">
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Chinese-title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="chinese" placeholder="<?php echo ($language["Chinese-title"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["English-title"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="english" placeholder="<?php echo ($language["English-title"]); ?>"  value="" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["package"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <div id="toolbar">
                        <div>
                            <button type="button" class="layui-btn layui-btn-sm" data-type="addRow" title="<?php echo ($language["add"]); ?>">
                                <i class="layui-icon layui-icon-add-1"></i> <?php echo ($language["add"]); ?>
                            </button>
                        </div>
                    </div>
                    <div id="tableRes" class="table-overlay">
                        <table id="dataTable" lay-filter="dataTable" class="layui-hide"></table>
                    </div>
                    <div class="layui-form  layui-table-view">
                        <table cellspacing="0" cellpadding="0" border="0" class="layui-table" lay-even="">
                            <thead>
                            <tr>
                                <th data-field="project" data-key="1-0-0" class="">
                                    <div class="layui-table-cell laytable-cell-1-0-0"><span><?php echo ($language["Total-price"]); ?>:</span></div>
                                </th>
                                <th data-field="price" data-key="1-0-1" class="">
                                    <div class="layui-table-cell laytable-cell-1-0-2">
                                        <input name="total" placeholder="0.00"  value="" autocomplete="off" class="layui-input priceTol" type="text">
                                    </div>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["present"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="present" lay-event="present" placeholder="<?php echo ($language["present"]); ?>"  value="0.00" autocomplete="off" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo ($language["Term-validity"]); ?>：<b style="color:#d70101">*</b></label>
                <div class="layui-input-block">
                    <input name="date" placeholder="<?php echo ($language["Term-validity"]); ?>"  value="0" autocomplete="off" class="layui-input" type="text">
                    <div class="layui-form-mid layui-word-aux">单位：天，0代表无限期</div>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-layout-admin">
            <div class="layui-footer" style="left: auto;">
                <a class="layui-btn" onclick="subCreate()"><i class="layui-icon">&#xe605;</i><?php echo ($language["Submission"]); ?> </a>
                <button type="reset" class="layui-btn layui-btn-primary"><i class="layui-icon">&#x1006;</i><?php echo ($language["Reset"]); ?></button>
                <a class="layui-btn layui-btn-primary" onclick="closeBtns()"><i class="layui-icon">&#x1006;</i><?php echo ($language["close"]); ?> </a>
            </div>
        </div>
    </form>

    <!-- 内容区 -->
    <script src="/Public/Layui/layui.js" type="text/javascript" charset="utf-8"></script>
    
    <script type="text/javascript">
        //准备视图对象
        window.viewObj = {
            tbData: [{
                tempId: new Date().valueOf(),
                project: 0,
                price: '0.00',
                num:1,
            }],
            typeData: <?php echo ($projectGroup); ?>,
            renderSelectOptions: function(data, settings) {
                settings = settings || {};
                var valueField = settings.valueField || 'value',
                        textField = settings.textField || 'text',
                        selectedValue = settings.selectedValue || "";
                var html = [];
                for (var i = 0, item; i < data.length; i++) {
                    item = data[i];
                    html.push('<option value="');
                    html.push(item[valueField]);
                    html.push('"');
                    if (selectedValue && item[valueField] == selectedValue) {
                        html.push(' selected="selected"');
                    }
                    html.push('>');
                    html.push(item[textField]);
                    html.push('</option>');
                }
                return html.join('');
            }
        };

        //layui 模块化引用
        layui.use(['jquery', 'table', 'layer'], function() {
            var $ = layui.$,
                    table = layui.table,
                    form = layui.form,
                    layer = layui.layer;

            //数据表格实例化
            var tbWidth = $("#tableRes").width();
            var layTableId = "layTable";
            var tableIns = table.render({
                elem: '#dataTable',
                id: layTableId,
                data: viewObj.tbData,
                width: tbWidth,
                page: false,
                limit:100,
                loading: true,
                even: true, //不开启隔行背景
                cols: [
                    [ {
                        field: 'project',
                        title: '<?php echo ($language["project"]); ?>',
                        templet: function(d) {
                            var options = viewObj.renderSelectOptions(viewObj.typeData, {
                                valueField: "id",
                                textField: "title",
                                selectedValue: d.project
                            });
                            return '<a lay-event="project"></a><select name="project[]" lay-filter="project"    lay-search=""><option value=""><?php echo ($language["project"]); ?></option>' + options + '</select>';
                        },
                    }, {
                        field: 'price',
                        title: '<?php echo ($language["price"]); ?>',
                        templet: function(d) {
                            return '<input name="price[]" lay-event="price" value="'+d.price+'"  autocomplete="off"    class="layui-input" type="text">';
                        }
                    }, {
                        field: 'num',
                        title: '<?php echo ($language["Number"]); ?>',
                        templet: function(d) {
                            return '<input name="num[]" lay-event="num" value="'+d.num+'"  autocomplete="off"    class="layui-input" type="text">';
                        }
                    },{
                        field: 'tempId',
                        title: '<?php echo ($language["operation"]); ?>',
                        templet: function(d) {
                            return '<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del" lay-id="' + d.tempId + '"><i class="layui-icon layui-icon-delete"></i><?php echo ($language["delete"]); ?></a>';
                        }
                    }]
                ],
                done: function(res, curr, count){
                    viewObj.tbData = res.data;
                }
            });
            //浮点数乘法
            function accMul(price,num,total)
            {
                var m=0,s1=price.toString(),s2=num.toString();
                try{m+=s1.split(".")[1].length}catch(e){}
                try{m+=s2.split(".")[1].length}catch(e){}
                return accAdd(Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m),total);
            }

            // 浮点数相加
            function accAdd(arg1, arg2) {
                var r1, r2, m;
                try {
                    r1 = arg1.toString().split(".")[1].length
                } catch (e) {
                    r1 = 0
                }
                try {
                    r2 = arg2.toString().split(".")[1].length
                } catch (e) {
                    r2 = 0
                }
                m = Math.pow(10, Math.max(r1, r2))
                return (arg1 * m + arg2 * m) / m
            }
            //定义事件集合
            var active = {
                addRow: function() { //添加一行
                    var oldData = table.cache[layTableId];
                    var newRow = {
                        tempId: new Date().valueOf(),
                        project: 0,
                        price: '0.00',
                        num:1,
                        name: '<?php echo ($language["project"]); ?>',
                    };
                    oldData.push(newRow);
                    tableIns.reload({
                        data: oldData
                    });
                },
                updateRow: function(obj) {
                    var oldData = table.cache[layTableId];

                    //总计
                    var priceTotal = 0; //价格小计
                    // 一秒后执行的原因？同时执行加不上当前修改的input
                    setTimeout(function() {
                        for (let item of table.cache[layTableId]) {
                            priceTotal = accMul(item.price,item.num,priceTotal);
                        }
                        $('.priceTol').val(priceTotal);
                    }, 500);

                    for (var i = 0, row; i < oldData.length; i++) {
                        row = oldData[i];
                        if (row.tempId == obj.tempId) {
                            $.extend(oldData[i], obj);
                            return;
                        }
                    }
                    tableIns.reload({
                        data: oldData
                    });
                },
                removeEmptyTableCache: function() {
                    var oldData = table.cache[layTableId];
                    for (var i = 0, row; i < oldData.length; i++) {
                        row = oldData[i];
                        if (!row || !row.tempId) {
                            oldData.splice(i, 1); //删除一项
                        }
                        continue;
                    }
                    tableIns.reload({
                        data: oldData
                    });
                },
                save: function() {
                    var oldData = table.cache[layTableId];
                    for (var i = 0, row; i < oldData.length; i++) {
                        row = oldData[i];
                        if (!row.type) {
                            layer.msg("检查每一行，请选择分类！", {
                                icon: 5
                            }); //提示
                            return;
                        }
                    }
                    document.getElementById("jsonResult").innerHTML = JSON.stringify(table.cache[layTableId], null, 2); //使用JSON.stringify() 格式化输出JSON字符串
                }
            }

            //激活事件
            var activeByType = function(type, arg) {
                if (arguments.length === 2) {
                    active[type] ? active[type].call(this, arg) : '';
                } else {
                    active[type] ? active[type].call(this) : '';
                }
            }

            //注册按钮事件
            $('.layui-btn[data-type]').on('click', function() {
                var type = $(this).data('type');
                activeByType(type);
            });

            //监听select下拉选中事件
            form.on('select(project)', function(data) {
                var curIndex = $('tr').index($(this).parent().parent().parent().parent().parent()) - 1;  //获取当前tr行数，减1即为input的index
                var value = data.value;
                $.ajax({
                    cache: true,
                    type: 'get',
                    url:'/admin.php/Product/getProductPrice?id='+value,
                    dataType:'json',
                    success: function(json){
                        $("input[name='price[]']").eq(curIndex).val(json);
                        $("input[lay-event='price']").eq(curIndex).trigger("click");
                        var elem = data.elem; //得到select原始DOM对象
                        $(elem).prev("a[lay-event='project']").trigger("click");
                    }
                });
            });
            $(document).on('input propertychange','input[name="present"]',function () {
                bindKeyEvent($(this));
            });

            $(document).on('input propertychange','input[name="price[]"]',function () {
                bindKeyEvent($(this));
                var curIndex = $('input[name="price[]').index($(this));  //获取当前tr行数，减1即为input的index
                $("input[lay-event='price']").eq(curIndex).trigger("click");
            });
            $(document).on('input propertychange','input[name="num[]"]',function () {
                bindKeyEvent2($(this));
                var curIndex = $('input[name="num[]').index($(this));  //获取当前tr行数，减1即为input的index
                $("input[lay-event='num']").eq(curIndex).trigger("click");
            });
            //价格的正则判断
            var bindKeyEvent = function(obj){
                obj.keyup(function () {
                    var reg = $(this).val().match(/\d+\.?\d{0,2}/);
                    var txt = '';
                    if (reg != null) {
                        txt = reg[0];
                    }
                    $(this).val(txt);
                }).change(function () {
                    $(this).keypress();
                    var v = $(this).val();
                    if (/\.$/.test(v))
                    {
                        $(this).val(v.substr(0, v.length - 1));
                    }
                });
            }
            //正整数判断
            var bindKeyEvent2 = function(obj){
                obj.keyup(function () {
                    var reg = $(this).val().match(/\d+/);
                    var txt = '';
                    if (reg != null) {
                        txt = reg[0];
                    }
                    $(this).val(txt);
                }).change(function () {
                    $(this).keypress();
                    var v = $(this).val();
                    if (/\.$/.test(v))
                    {
                        $(this).val(v.substr(0, v.length - 1));
                    }
                });
            }
            //监听工具条
            table.on('tool(dataTable)', function(obj) {
                var data = obj.data,
                        event = obj.event,
                        tr = obj.tr; //获得当前行 tr 的DOM对象
                switch (event) {
                    case "project":
                        var select = tr.find("select[name='project[]']");
                        if (select) {
                            var selectedVal = select.val();
                            $.extend(obj.data, {
                                'project': selectedVal
                            });
                            activeByType('updateRow', obj.data); //更新行记录对象
                        }
                        break;
                    case "price":
                        var price = tr.find("input[name='price[]']");
                        if (price) {
                            var value = price.val();
                            $.extend(obj.data, {
                                'price': value
                            });
                            activeByType('updateRow', obj.data); //更新行记录对象
                        }
                        break;
                    case "num":
                        var num = tr.find("input[name='num[]']");
                        if (num) {
                            var value = num.val();
                            $.extend(obj.data, {
                                'num': value
                            });
                            activeByType('updateRow', obj.data); //更新行记录对象
                        }
                        break;
                    case "del":
                        layer.confirm('真的删除行么？', function(index) {
                            obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                            layer.close(index);
                            activeByType('removeEmptyTableCache');
                        });
                        break;
                }
            });
        });

    </script>
    <script>
        function closeBtns(){
            parent.window.layer_back();
        }
        function subCreate(){
            $.ajax({
                cache: true,
                type: 'POST',
                url:'/admin.php/Package/create',
                data:$('#form').serialize(),// 你的formid
                dataType:'json',
                success: function(json){
                    if(json.rel==1){
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["define"]); ?>'] //按钮
                        }, function(){
                            parent.window.layer_back();
                        });
                    }else{
                        layer.confirm(json.msg, {
                            btn: ['<?php echo ($language["close"]); ?>'] //按钮
                        }, function(){
                            parent.window.layer_back();
                        });
                    }
                }
            });
        }
    </script>

</body>
</html>