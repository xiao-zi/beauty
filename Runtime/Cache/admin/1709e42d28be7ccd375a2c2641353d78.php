<?php if (!defined('THINK_PATH')) exit();?><table class="layui-table" lay-size="sm">
    <colgroup>
        <col width="100">
        <col width="100">
        <col width="100">
    </colgroup>
    <thead>
    <tr>
        <th><?php echo ($language["project"]); ?></th>
        <th><?php echo ($language["package-sum"]); ?></th>
        <th><?php echo ($language["package-num"]); ?></th>
    </tr>
    </thead>
    <tbody id="ajax_return">
    <?php if(is_array($content)): foreach($content as $k=>$vo): ?><tr>
            <td><?php echo ($vo["title"]); ?></td>
            <td><?php echo ($vo["sum"]); ?></td>
            <td><?php echo ($vo["num"]); ?></td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>