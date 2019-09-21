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
    </tr><?php endforeach; endif; ?>
<script>
    var form = layui.form;
    form.render('checkbox');
</script>