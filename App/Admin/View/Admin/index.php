<!DOCTYPE HTML>
<html>
<head>
<title>管理员列表</title>
<?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/meta.php'; ?>
</head>
<body>
<?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/header.php'; ?>
<div class="main">
<?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/left.php'; ?>
    <div class="content">
        <h3 class="content_title">管理员列表<small>/共<?php echo $count;?>条记录</small></h3>
        <form action="<?php echo __APP__;?>" method="get" name="form1">
            <table class="action" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <a href="<?php echo U('add') ?>" class="btn bg_gray" type="button"><span class="icon-edit"></span>添加管理员</a>
                    </td>
                    <td align="right">
                        <?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/key_word.php'; ?>
                    </td>
                </tr>
            </table>
        </form>
        <form action="friend_del.php" method="get" name="form1">
            <table class="list_tab" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>工号</th>
                    <th>用户名</th>
                    <th>姓名</th>
                    <th>上次登录时间</th>
                    <th>上次登录IP</th>
                    <th>上次登录地点</th>
                    <th>状态</th>
                    <th></th>
                </tr>
                <?php
                foreach ($data as $value) {
                    if($value['is_del'] == 0){
                        $state = '正常';
                        $stateBut = '停用';
                        $url      = 'stop';
                    }
                    if($value['is_del'] == 2){
                        $state = '已停用';
                        $stateBut = '恢复';
                        $url      = 'recovery';
                    }
                    echo '<tr>';
                    echo '    <td>' , $value['id'] , '</td>';
                    echo '    <td>' , $value['work_code'] , '</td>';
                    echo '    <td>' , $value['username'] , '</td>';
                    echo '    <td>' , $value['name'] , '</td>';
                    echo '    <td>' , $value['last_time'] , '</td>';
                    echo '    <td>' , $value['ip'] , '</td>';
                    echo '    <td>' , ipToCity($value['ip']) , '</td>';
                    echo '    <td>' , $state , '</td>';
                    echo '    <td>';
                    $arr             = array();//让arr重新是一个空数组，避免有上次循环时得到的旧数据
                    $arr['url']      = U('edit',array('id' => $value['id']));
                    $arr['title']    = '编辑';
                    $arr['ico']      = 'icon-edit';
                    $arr['allClass'] = 'blue';
                    echo but_link($arr);

                    $arr             = array();
                    $arr['url']      = U($url,array('id' => $value['id']));
                    $arr['title']    = $stateBut;
                    $arr['ico']      = 'icon-key';
                    $arr['allClass'] = 'blue';
                    echo but_link($arr);

                    $arr             = array();
                    $arr['url']       = U('del',array('id' => $value['id']));
                    $arr['title']     = '删除';
                    $arr['ico']       = 'icon-trash';
                    $arr['allClass']  = 'red';
                    $arr['attribute'] = ' onclick="return confirm(\'确认要删除这个管理员吗？\');"';
                    echo but_link($arr);
                    echo '    </td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </form>
    </div>
</div>
</body>
</html>

<!-- function but_link($arr){
    //作用是返回像按钮那样的链接的HTML
    //参数是一个数组，有下面的键
    //url 链接的url
    //title 链接文字
    //ico 图标的class      这个键可以没有
    //attribute 附加属性   这个键可以没有
    //allClass 附加样式    这个键可以没有 -->