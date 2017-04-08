<!DOCTYPE HTML>
<html>
<head>
<title>添加管理员</title>
<?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/meta.php'; ?>
</head>
<body>
<?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/header.php'; ?>
<div class="main">
    <?php include APP_PATH . MODULE_NAME . '/' . C('DEFAULT_V_LAYER') . '/include/left.php'; ?>
    <div class="content">
        <h3 class="content_title">系统设置<small>/添加管理员</small></h3>
        <form class="form" action="<?php echo U('addSubmit');?>" method="post">
            <table class="form_table" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th>姓名:</th>
                    <td><input name="name" value="test1" type="text" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th>工号:</th>
                    <td><input name="work_code" value="test1" type="text" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th>用户名:</th>
                    <td><input name="username" value="test1" type="text" maxlength="16" size="22"></td>
                </tr>
                <tr>
                    <th>密码:</th>
                    <td><input name="password" value="test1" type="password" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th>确认密码:</th>
                    <td><input name="repassword" value="test1" type="password" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th></th>
                    <td class="submit">
                        <input name="" type="submit" value="提交添加">
                        <input name="" type="reset" value="重置">
                        <input name="button" type="button" onclick="history.back();" value="不添加了|返回上一页" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>