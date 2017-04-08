<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>提交订单</title>
</head>
<body>
<form action="<?php echo U('addSubmit');?>" method="post">
    请选择产品：
    <?php
    $pro_arr = C('PRO_ARR');
    $arr = array();
    $arr['addValue']  = '';
    $arr['addText']   = '请选择您要购买的产品';
    $arr['name']      = 'pro_name';
    foreach (C('PRO_ARR') as $key => $value) {
        $arr['data'][] = array('id' => $value  ,'name' => $value);
    }
    $arr['value'] = '产品2';
    echo selectHtml($arr);
    ?><br>
    收货人：<input size="6" type="text" name="consignee" value="收货人"><br>
    手机：<input size="12" type="text" name="mobile" value="15666777899"><br>
    地址：<input size="80" type="text" name="address" value="地址123"><br>
    来源：<input size="50" type="text" value="网站1" name="for"><br>
    <input type="submit" value="提交订单">
</form>
</body>
</html>