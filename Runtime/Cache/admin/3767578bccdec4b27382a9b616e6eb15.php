<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr id="<?php echo ($vo["id"]); ?>">
        <td>
            <img src="<?php echo ($vo["img"]); ?>" style="height: 100px;width: auto"/>
        </td>
        <td><?php echo ($vo["title"]); ?></td>
        <td>
            <?php switch($vo["type"]): case "1": echo ($language["Full-reduction"]); break;?>
                <?php case "2": echo ($language["discount"]); break; endswitch;?>
        </td>
        <td>
            <?php if(is_array($vo["rule"])): $i = 0; $__LIST__ = $vo["rule"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; switch($vo["type"]): case "1": ?>满<?php echo ($val["money"]); ?>减<?php echo ($val["discount"]); ?><br/><?php break;?>
                    <?php case "2": ?>满<?php echo ($val["money"]); ?>,<?php echo $val['discount']/10?>折<br/><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>

        </td>
        <td><?php echo (date("Y-m-d",$vo["start"])); ?></td>
        <td><?php echo (date("Y-m-d",$vo["end"])); ?></td>
        <td><?php echo ($vo["sum"]); ?></td>
        <td><?php echo ($vo["num"]); ?></td>
        <td><?php echo (date("Y-m-d H:i:s",$vo["create_at"])); ?></td>
        <td>
            <ul class="pullDown-nav">
                <li class="pullDown-nav-item">
                    <a href="javascript:;"><?php echo ($language["operation"]); ?></a>
                    <dl class="pullDown-nav-child">
                        <dd><a href="javascript:;" style="background-color: #00a65a;" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></a></dd>
                        <dd><a href="javascript:;" style="background-color: red;" onclick="delCoupon(<?php echo ($vo["id"]); ?>)"><?php echo ($language["delete"]); ?></a></dd>
                    </dl>
                </li>
            </ul>
        </td>
    </tr><?php endforeach; endif; ?>
<script>
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