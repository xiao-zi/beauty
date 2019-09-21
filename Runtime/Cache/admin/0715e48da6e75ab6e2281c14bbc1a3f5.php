<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): foreach($data as $k=>$vo): ?><tr id="<?php echo ($vo["id"]); ?>">
        <td><?php echo ($vo["cart"]); ?></td>
        <td><?php echo ($vo["username"]); ?></td>
        <td><?php echo ($vo["title"]); ?></td>
        <td><?php echo (date("Y-m-d H:i:s",$vo["create_at"])); ?></td>
        <td>
            <?php switch($vo["status"]): case "1": echo ($language["NO"]); break;?>
                <?php case "2": echo ($language["YES"]); break; endswitch;?>
        </td>
        <td><?php echo (date("Y-m-d",$vo["over_time"])); ?></td>
        <td><?php if(!empty($vo["use_time"])): echo (date("Y-m-d H:i:s",$vo["use_time"])); endif; ?></td>
        <td>
            <button type="button" onclick="delCustomerCoupon(<?php echo ($vo["id"]); ?>)" class="layui-btn layui-btn-danger"><i class="layui-icon"></i></button>
        </td>
    </tr><?php endforeach; endif; ?>