<!DOCTYPE HTML>
<html>
<head>
<title>订单列表</title>
<?php  include APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/include/meta.php'; ?> 
</head>
<body>
<?php  include APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/include/header.php'; ?> 
<div class="main">
    <?php  include APP_PATH.MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/include/left.php'; ?> 
    <div class="content">
        <h3 class="content_title"><a href="<?php echo U('index'); ?>">订单列表</a><small>/共<?php echo $count ?>条记录</small></h3>
        <form action="<?php echo __APP__;?>" method="get" name="form1">
            <table class="action" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                        <label><input type="radio" value="0" name="is_out"<?php if($is_out === '0'){echo ' checked';}?>>显示未导出</label>
                        <label><input type="radio" value="1" name="is_out"<?php if($is_out === '1'){echo ' checked';}?>>显示已导出</label>
                        <label><input type="radio" value="2" name="is_out"<?php if($is_out === '2'){echo ' checked';}?>>显示全部</label>
                    </td>
                    <td align="center">
                        <?php
                        $arr = array();
                        $arr['addValue']  = '';
                        $arr['addText']   = '不限产品';
                        $arr['name']      = 'pro_name';
                        foreach ($proArr as $key => $value) {
                            $arr['data'][] = array('id' => $value  ,'name' => $value);
                        }
                        $arr['value'] = $pro_name;
                        echo selectHtml($arr);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        开始时间：<input type="datetime-local" name="time_star" value="<?php echo $time_star;?>">
                        结束时间：<input type="datetime-local" name="time_end" value="<?php echo $time_end;?>">
                    </td>
                    <td align="center" style="padding-top:5px">
                        <input type="submit" value="搜索">
                        <input type="hidden" name="to_excel">
                        <input type="button" value="导出" onclick="this.form.to_excel.value='1';this.form.target='_blank';this.form.submit();this.form.target='_self';this.form.to_excel.value='';">
                    </td>
                </tr>
            </table>
            <input type="hidden" name="m" value="<?php echo MODULE_NAME;?>">
            <input type="hidden" name="c" value="<?php echo CONTROLLER_NAME;?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME;?>">
        </form>
        <table class="list_tab" border="0" cellpadding="0" cellspacing="0">
            <tr>            
                <th>序列</th>
                <th>购买产品</th>
                <th>姓名</th>
                <th>电话</th>
                <th>地址</th>
                <th>日期</th>
                <th>来源</th>
                <th>状态</th>
            </tr>
        <?php
        if($count > 0){
            foreach ($data as $value) {
                $status = $value['is_out'] == '1' ? '已导出' : '未导出';
                echo '<tr>';
                echo '    <td>' , $value['order_sn' ] , '</td>';
                echo '    <td>' , $value['pro_name' ] , '</td>';
                echo '    <td>' , $value['consignee'] , '</td>';
                echo '    <td>' , $value['mobile'   ] , '</td>';
                echo '    <td>' , $value['address'  ] , '</td>';
                echo '    <td>' , $value['add_time' ] , '</td>';
                echo '    <td>' , $value['for'      ] , '</td>';
                echo '    <td>' , $status             , '</td>';
                echo '</tr>';
            }
        }else{
            echo '<tr><td colspan="7">找不到符合条件的记录</td></tr>';
        }
        ?>
        </table>
        <?php echo $pageHtml; ?>
    </div>
</div>
</body>
</html>