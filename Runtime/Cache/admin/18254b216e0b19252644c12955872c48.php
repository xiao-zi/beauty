<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
        <td>
            <?php echo ($vo["last_name"]); ?>(<?php echo ($vo["first_name"]); ?>)
            <?php if($vo["status"] != 0): ?><br/><?php echo ($language["Administrators"]); ?>：<?php echo ($vo["adminName"]); ?> <br/><?php echo ($language["time"]); ?>：<?php echo (date("Y-m-d H:i:s",$vo["update_at"])); endif; ?>
        </td>
        <td>(<?php echo ($vo["phone_code"]); ?>)<?php echo ($vo["phone"]); ?></td>
        <td><?php echo ($vo["email"]); ?></td>
        <td><?php echo ($vo["date"]); ?>&nbsp;&nbsp;<?php echo ($vo["time"]); ?> </td>
        <td>
            <?php if(is_array($vo["product"])): $i = 0; $__LIST__ = $vo["product"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; echo ($val["chinese"]); ?>(<?php echo ($val["english"]); ?>)<br/><?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
        <td>
            <?php switch($vo["status"]): case "0": echo ($language["Untreated"]); ?><br/><button onclick="updateStatus(<?php echo ($vo["id"]); ?>,1)"><?php echo ($language["Completed"]); ?></button><br/><button onclick="updateStatus(<?php echo ($vo["id"]); ?>,2)"><?php echo ($language["Abandoned"]); ?></button><?php break;?>
                <?php case "1": echo ($language["Completed"]); break;?>
                <?php case "2": echo ($language["Abandoned"]); break;?>
                <?php default: ?>	<?php echo ($language["Untreated"]); ?><br/><button onclick="updateStatus(<?php echo ($vo["id"]); ?>,1)"><?php echo ($language["Completed"]); ?></button><br/><button onclick="updateStatus(<?php echo ($vo["id"]); ?>,2)"><?php echo ($language["Abandoned"]); ?></button><?php endswitch;?>
        </td>
        <td><?php echo (date("Y-m-d H:i:s",$vo["create_at"])); ?></td>
        <td>
            <ul class="pullDown-nav">
                <li class="pullDown-nav-item">
                    <a href="javascript:;"><?php echo ($language["operation"]); ?></a>
                    <dl class="pullDown-nav-child">
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="sendMessage(<?php echo ($vo["id"]); ?>)"><?php echo ($language["send-short-messages"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="sendMail(<?php echo ($vo["id"]); ?>)"><?php echo ($language["send-mail"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="updateRemark(<?php echo ($vo["id"]); ?>)"><?php echo ($language["remark"]); ?></a></dd>
                    </dl>
                </li>
            </ul>
        </td>
    </tr><?php endforeach; endif; ?>
<script>
    var form = layui.form;
    form.render('checkbox');
    $(function () {
        $(".layui-table tr td").find(".pullDown-nav").find("li.pullDown-nav-item").hover(function () {
            if (!$(this).hasClass("pullDown-this")) {
                $(this).addClass("pullDown-this").parent().parent().parent().siblings().find(
                        ".pullDown-nav").find("li.pullDown-nav-item").removeClass("pullDown-this");
                $(this).find("dl.pullDown-nav-child").css("display", "block");
                $(this).parent().parent().parent().siblings().find(".pullDown-nav").find(
                        "li.pullDown-nav-item").find("dl.pullDown-nav-child").css("display", "none");
                leavePullDownMenu();
            }
        },function(){
            $(this).addClass("pullDown-this").removeClass("pullDown-this");
            $(this).find(".pullDown-nav").find("dl.pullDown-nav-child").css("display", "none");
        });

        function leavePullDownMenu() {
            $("dl.pullDown-nav-child").on('mouseleave', function () {
                $(this).parentsUntil(".layui-table").find("tr").find("td").find(".pullDown-nav").find(
                        "li.pullDown-nav-item").removeClass("pullDown-this");
                $(this).parentsUntil(".layui-table").find("tr").find("td").find(".pullDown-nav").find(
                        "li.pullDown-nav-item").find("dl.pullDown-nav-child").css("display", "none");
            })
        }
    });
</script>