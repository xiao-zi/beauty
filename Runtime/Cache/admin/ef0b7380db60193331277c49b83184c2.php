<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
        <td><img src="<?php echo ($vo["image"]); ?>" style="width: 100%;height: auto;"/></td>
        <td><?php echo ($vo["username"]); ?></td>
        <td><?php echo ($vo["realname"]); ?></td>
        <td><?php echo ($vo["phone"]); ?></td>
        <td><?php echo ($vo["email"]); ?></td>
        <td>
            <?php switch($vo["status"]): case "activation": ?><input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch"  lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status" checked ><?php break;?>
                <?php default: ?>	<input type="checkbox"  data-id="<?php echo ($vo["id"]); ?>" lay-skin="switch" lay-text="<?php echo ($language["activation"]); ?>|<?php echo ($language["defaulted"]); ?>" lay-filter="status"  ><?php endswitch;?>
        </td>
        <td><?php echo ($vo["groups"]); ?></td>
        <td><?php echo ($vo["login_time"]); ?></td>
        <td>
            <ul class="pullDown-nav">
                <li class="pullDown-nav-item">
                    <a href="javascript:;"><?php echo ($language["operation"]); ?></a>
                    <dl class="pullDown-nav-child">
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); echo ($language["account"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="userLogin(<?php echo ($vo["id"]); ?>)"><?php echo ($language["login"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: red" onclick="changePassword(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); echo ($language["password"]); ?></a></dd>
                    </dl>
                </li>
            </ul>
            <!--<button class="layui-btn layui-btn-sm" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); echo ($language["account"]); ?></button>-->
            <!--<button class="layui-btn layui-btn-sm" onclick="userLogin(<?php echo ($vo["id"]); ?>)"><?php echo ($language["login"]); ?></button>-->
            <!--<button class="layui-btn layui-btn-sm layui-btn-danger" onclick="changePassword(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); echo ($language["password"]); ?></button>-->
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