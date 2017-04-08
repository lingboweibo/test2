<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>上传文件</title>
</head>
<body>
	<form action="<?php echo U('upfileSubmit');?>" enctype="multipart/form-data" method="post" >
	<input type="text" name="name" />
	<input type="file" name="photo" />
	<input type="submit" value="提交" >
	</form>
</body>
</html>