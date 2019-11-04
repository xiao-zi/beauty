<?php if (!defined('THINK_PATH')) exit();?><table class="layui-table" lay-size="sm">
    <colgroup>
        <col width="100">
        <col width="100">
        <col width="100">
    </colgroup>
    <thead>
    <tr>
        <th><?php echo ($language["project"]); ?></th>
        <th><?php echo ($language["price"]); ?></th>
        <th><?php echo ($language["Number"]); ?></th>
    </tr>
    </thead>
    <tbody id="ajax_return">
    <?php if(is_array($info["content"])): foreach($info["content"] as $k=>$vo): ?><tr>
            <td><?php echo ($vo["project"]); ?></td>
            <td><?php echo ($vo["price"]); ?></td>
            <td><?php echo ($vo["num"]); ?></td>
        </tr><?php endforeach; endif; ?>
    <tr>
        <th>
            <div class="layui-table-cell laytable-cell-1-0-0"><span><?php echo ($language["original"]); ?>:<?php echo ($info["original"]); ?></span></div>
        </th>
        <th>
            <div class="layui-table-cell laytable-cell-1-0-0"><span><?php echo ($language["present"]); ?>:<?php echo ($info["present"]); ?></span></div>
        </th>
        <th>
            <div class="layui-table-cell laytable-cell-1-0-0"><span><?php echo ($language["Term-validity"]); ?>:<?php if($info['date'] == 0): ?>无限期<?php else: echo ($info["date"]); ?>天<?php endif; ?></span></div>
        </th>
    </tr>
    </tbody>
</table>