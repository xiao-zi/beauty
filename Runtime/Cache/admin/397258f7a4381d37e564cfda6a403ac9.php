<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
        <td>
            <input name="checkid[]" lay-skin="primary" value="<?php echo ($vo["id"]); ?>" type="checkbox">
        </td>
        <td><?php echo ($vo["id"]); ?></td>
        <td><?php echo ($vo["sender"]); ?></td>
        <td>(<?php echo ($vo["phone_code"]); ?>)<?php echo ($vo["phone"]); ?></td>
        <td><?php echo ($vo["receiver"]); ?></td>
        <td>
            <?php switch($vo["status"]): case "0": echo ($language["not-sent"]); break;?>
                <?php case "1": echo ($language["has-been-sent"]); break;?>
                <?php default: echo ($language["fill-in-sent"]); endswitch;?>
        </td>
        <td><?php echo (date("Y-m-d H:i:s",$vo["created_time"])); ?></td>
        <td>
            <ul class="pullDown-nav">
                <li class="pullDown-nav-item">
                    <a href="javascript:;"><?php echo ($language["operation"]); ?></a>
                    <dl class="pullDown-nav-child">
                        <?php switch($vo["status"]): case "1": ?><dd><a href="javascript:;" style="background-color: #00a65a;" onclick="sendMessage(<?php echo ($vo["id"]); ?>)"><?php echo ($language["Resend"]); ?></a></dd><?php break;?>
                            <?php case "2": ?><dd><a href="javascript:;" style="background-color: #00a65a;" onclick="sendMessage(<?php echo ($vo["id"]); ?>)"><?php echo ($language["Resend"]); ?></a></dd><?php break;?>
                            <?php default: endswitch;?>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="showDetail(<?php echo ($vo["id"]); ?>)"><?php echo ($language["See-details"]); ?></a></dd>
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