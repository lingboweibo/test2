<!DOCTYPE HTML>
<html>
<head>
<title>修改我的密码</title>
<?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/meta.php" ?>
</head>
<body>
<?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/header.php" ?>
<div class="main">
    <?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/left.php" ?>
    <div class="content">
        <h3 class="content_title">系统设置<small>/修改我的密码</small></h3>
        <form class="form" action="<?php echo U('editMySubmit') ?>" method="post">
            <table class="form_table" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th>用户名:</th>
                    <td><input name="username" type="text" maxlength="16" size="22" value="<?php echo session('adminLoginData.username');?>"></td>
                </tr>
                <tr>
                    <th>旧密码:</th>
                    <td><input name="old_password" type="password" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th>新密码:</th>
                    <td><input name="password" type="password" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th>确认新密码:</th>
                    <td><input name="repassword" type="password" maxlength="32" size="22"></td>
                </tr>
                <tr>
                    <th></th>
                    <td class="submit">
                        <input name="" type="submit" value="提交修改">
                        <input name="" type="reset" value="重置">
                        <input name="button" type="button" onclick="history.back();" value="不修改了|返回上一页" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>