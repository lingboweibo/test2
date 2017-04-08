<!DOCTYPE HTML>
<html>
<head>
<title>修改管理员</title>
<?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/meta.php" ?>
</head>
<body>
<?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/header.php" ?>
<div class="main">
    <?php include APP_PATH.MODULE_NAME."/".C('DEFAULT_V_LAYER')."/include/left.php" ?>
    <div class="content">
        <h3 class="content_title">系统设置<small>/修改管理员个人信息</small></h3>
        <form class="form" action="<?php echo U('editSubmit')?>" method="post">
            <table class="form_table" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th>姓名:</th>
                    <td><input name="name" type="text" maxlength="32" size="22" value="<?php echo $data['name'];?>"></td>
                </tr>
                <tr>
                    <th>工号:</th>
                    <td><input name="work_code" type="text" maxlength="32" size="22" value="<?php echo $data['work_code'];?>"></td>
                </tr>
                <tr>
                    <th>用户名:</th>
                    <td><input name="username" type="text" maxlength="16" size="22" value="<?php echo $data['username'];?>"></td>
                </tr>
                <tr>
                    <th>密码:</th>
                    <td>
                    <input name="password" type="text" maxlength="32" size="22"> 为空表示不修改
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td class="submit">
                        <input name="id" type="hidden" value="<?php echo $data['id'];//此表单提交后用这个ID作为条件更新记录 ?>">
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