<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr>
        <td><?php echo ($vo["id"]); ?></td>
        <td><?php echo ($vo["model"]); ?></td>
        <td><?php echo ($vo["chinese"]); ?></td>
        <td><?php echo ($vo["english"]); ?></td>
        <td><?php echo ($vo["create_time"]); ?></td>
        <td><?php echo ($vo["update_time"]); ?></td>
        <td>
            <button class="layui-btn layui-btn-sm" onclick="update(<?php echo ($vo["id"]); ?>)"><?php echo ($language["updated"]); ?></button>
        </td>
    </tr><?php endforeach; endif; ?>
<script>
    var form = layui.form;
    form.render('checkbox');
</script>