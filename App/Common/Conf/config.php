<?php
//应用配置文件
return array(
    'SHOW_PAGE_TRACE' =>true,
    'WEBSITE_NAME' =>'简易订单管理系统',

    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'xjy', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'sa111', // 密码 密码如果不对 会出这样的错误 ：SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => '', // 数据库表前缀,如果是要得很规范的话就需一个前缀，这是为了方便就不加前缀了
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

    'TMPL_ENGINE_TYPE' =>'PHP',//完全使用PHP本身作为模板引擎
    'TMPL_TEMPLATE_SUFFIX' =>'.php',// 模板后缀用.php作为模板文件的后缀
    'STATIC_VERSION' => time(),//静态文件版本号
    'STATIC_PATH' => '/statics',//静态文件(css,js)路径
    'URL_MODEL' => 0,
    'SHOW_PAGE_TRACE' =>true,//关闭跟踪信息
    'DB_FIELDS_CACHE' =>  true,//启用字段缓存
    'LOG_LEVEL' =>  'EMERG,ALERT,CRIT,ERR,WARN,DEBUG,SQL',

    'PRO_ARR'    => array('200' => '阿尔法牛','300' => '产品1','400' => '产品2','500' => '产品3'),
);