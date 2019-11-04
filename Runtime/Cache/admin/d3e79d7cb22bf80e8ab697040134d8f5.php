<?php if (!defined('THINK_PATH')) exit();?><label class="layui-form-label"><?php echo ($language["project"]); ?>：<b style="color:#d70101">*</b></label>
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
                <th data-field="user" data-key="1-0-1" class="" colspan="2">
                    <div class="layui-table-cell laytable-cell-1-0-1"><span><?php echo ($language["Tip-price"]); ?>:</span></div>
                </th>
                <th data-field="tip" data-key="1-0-3" class="" colspan="2">
                    <div class="layui-table-cell laytable-cell-1-0-3"><span class="tipTol">0.00</span></div>
                </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    //准备视图对象
    window.viewObj = {
        tbData: [{
            tempId: new Date().valueOf(),
            project: 0,
            user: 0,
            tip: '0.00',
            name: '<?php echo ($language["project"]); ?>',
        }],
        typeData: <?php echo ($projectGroup); ?>,
        jsData:<?php echo ($user); ?>,
        content:<?php echo ($content1); ?>,
        content1:<?php echo ($content1); ?>,
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
                    field: 'user',
                    title: '<?php echo ($language["technician"]); ?>',
                    templet: function(d) {
                        var options = viewObj.renderSelectOptions(viewObj.jsData, {
                            valueField: "id",
                            textField: "realname",
                            selectedValue: d.user
                        });
                        return '<a lay-event="user"></a><select name="user[]" lay-filter="user"  lay-search=""><option value=""><?php echo ($language["technician"]); ?></option>' + options + '</select>';
                    }
                },{
                    field: 'tip',
                    title: '<?php echo ($language["tip"]); ?>',
                    templet: function(d) {
                        return '<input name="tip[]" lay-event="tip"  value="'+d.tip+'"  autocomplete="off"  class="layui-input" type="text">';
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
                    user: 0,
                    tip: '0.00',
                    name: '<?php echo ($language["project"]); ?>',
                };
                oldData.push(newRow);
                tableIns.reload({
                    data: oldData
                });
            },
            updateRow: function(obj) {
                var oldData = table.cache[layTableId];

                var tipTotal = 0; //消费小计
                // 一秒后执行的原因？同时执行加不上当前修改的input
                setTimeout(function() {
                    for (let item of table.cache[layTableId]) {
                        tipTotal = accAdd(item.tip, tipTotal);
                    }
                    $('.tipTol').text(tipTotal);
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
                var tipTotal = 0; //消费小计
                // 一秒后执行的原因？同时执行加不上当前修改的input
                setTimeout(function() {
                    for (let item of table.cache[layTableId]) {
                        tipTotal = accAdd(item.tip, tipTotal);
                    }
                    $('.tipTol').text(tipTotal);
                }, 500);
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
        //项目的数量计算，
        var activeProject = function(p){
           var project =  viewObj.content;
            for(var i = 0;i<project.length;i++){
                if(project[i].project == p){
                    if(project[i].num >= project[i].sum){
                        return project[i].title+ '使用次数已达到上限';
                    }else{

                        return 'success';
                    }
                }
            }
        }
        var projectNum = function(){
            var project =  viewObj.content,project1 =  viewObj.content1,json = viewObj.tbData;
            for(var i = 0;i<project.length;i++){
                project[i].num = project1[i].num;
                for(var j = 0;j<json.length;j++){
                    if(project[i].project == json[j].project){
                        project[i].num = project[i].num+1;
                    }
                }
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
            var value = data.value;
            var result = activeProject(value);
            if(result === 'success'){
                var elem = data.elem; //得到select原始DOM对象
                $(elem).prev("a[lay-event='project']").trigger("click");
                projectNum();
            }else{
                var oldData = table.cache[layTableId];
                tableIns.reload({
                    data: oldData
                });
                layer.confirm(result);
            }

        });

        form.on('select(user)', function(data) {
            var elem = data.elem; //得到select原始DOM对象
            $(elem).prev("a[lay-event='user']").trigger("click");
        });
        $(document).on('input propertychange','input[name="tip[]"]',function () {
            bindKeyEvent($(this));
            var curIndex = $('input[name="tip[]').index($(this));  //获取当前tr行数，减1即为input的index
            $("input[lay-event='tip']").eq(curIndex).trigger("click");
        })
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
                case "user":
                    var select = tr.find("select[name='user[]']");
                    if (select) {
                        var selectedVal = select.val();
                        $.extend(obj.data, {
                            'user': selectedVal
                        });
                        activeByType('updateRow', obj.data); //更新行记录对象
                    }
                    break;
                case "tip":
                    var tip = tr.find("input[name='tip[]']");
                    if (tip) {
                        var value = tip.val();
                        $.extend(obj.data, {
                            'tip': value
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