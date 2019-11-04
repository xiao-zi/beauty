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
    <?php if(is_array($info["content"])): foreach($info["content"] as $k=>$vo): ?><tr>
            <td><?php echo ($vo["project"]); ?></td>
            <td><?php echo ($vo["sum"]); ?></td>
            <td><?php echo ($vo["num"]); ?></td>
        </tr><?php endforeach; endif; ?>
    <tr>
        <th>
            <div class="layui-table-cell "><span><?php echo ($language["pay-sn"]); ?>:<?php echo ($info["sn"]); ?></span></div>
        </th>
        <th colspan="2">
            <div class="layui-table-cell "><span><?php echo ($language["money"]); ?>:<?php echo ($info["money"]); ?></span></div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="layui-table-cell "><span><?php echo ($language["Payment-method"]); ?>:<?php echo ($info["mode"]); ?></span></div>
        </th>
        <th colspan="2">
            <div class="layui-table-cell "><span><?php echo ($language["Payment-status"]); ?>:<?php echo ($info["status"]); ?></span></div>
        </th>
    </tr>
    </tbody>
</table>