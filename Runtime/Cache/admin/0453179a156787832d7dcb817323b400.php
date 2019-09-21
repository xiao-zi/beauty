<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
        <td>
            <input name="checkid[]" lay-skin="primary" value="<?php echo ($vo["id"]); ?>" type="checkbox">
        </td>
        <td><?php echo ($vo["cartnum"]); ?></td>
        <td><?php echo ($vo["username"]); ?></td>
        <td>(<?php echo ($vo["phonecode"]); ?>)<?php echo ($vo["phone"]); ?></td>
        <td><?php echo ($vo["email"]); ?></td>
        <td>
            <?php switch($vo["sex"]): case "male": echo ($language["male"]); break;?>
                <?php default: ?>	<?php echo ($language["female"]); endswitch;?>
        </td>
        <td><?php echo ($vo["birth"]); ?></td>
        <td>
            <?php switch($vo["activitylevel"]): case "active": echo ($language["active"]); break;?>
                <?php case "inactive": echo ($language["inactive"]); break;?>
                <?php default: ?>	<?php echo ($language["masked"]); endswitch;?>
        </td>
        <td><?php echo ($vo["register_time"]); ?></td>
        <td>
            <ul class="pullDown-nav">
                <li class="pullDown-nav-item">
                    <a href="javascript:;"><?php echo ($language["operation"]); ?></a>
                    <dl class="pullDown-nav-child">
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="userLogin(<?php echo ($vo["id"]); ?>)"><?php echo ($language["See-details"]); ?></a></dd>
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