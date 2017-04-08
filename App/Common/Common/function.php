<?php
function my_dump($s,$f = 'p'){//断点显示调试数据$s ,第二个参数表示用什么函数来显示传来的数据，默认=p就会用print_r
    ob_end_clean();//清除前面的输出的内容
    header('Content-type: text/plain');
    if($f == 'p')$f = 'print_r';
    if($f == 'v')$f = 'var_export';
    if($f == 'd')$f = 'var_dump';
    $f($s);
    exit;//表示退出PHP程序的运行，不执行后面的代码
}
function _sql($m = ''){//断点显示传来的$m模型的最后执行的SQL
    if($m == '')$m = M();
    $sql = $m->_sql();//getLastSql();
    ob_end_clean();
    header('Content-type: text/plain');
    echo $sql;
    exit;
}
function mylog($word) {//在根目录写调试信息，文件名:log_file_fun
    $fp = fopen('LOG_FILE_FUN', 'a');
    flock($fp, LOCK_EX);
    fwrite($fp, date('Y-m-d H:i:s',time()) . ':' . $word . PHP_EOL);
    flock($fp, LOCK_UN);
    fclose($fp);
}
function selectHtml($arr){//根据传来的数据参数返回显示下拉菜单的HTML
    //该参数是一个二维数组，有下面的键
    //$data      选项数据，是一个二维数组，结构跟TP模型的select返回的数组一样，是一个像记录集的二维数组
    //$value     预选值       这个键可以没有,没有的将会使用空字符串
    //$name      select的name
    //attribute  附加属性     这个键可以没有,没有的将会用默认值
    //allClass   附加样式     这个键可以没有,没有的将会用默认值
    //addValue   附加选项值   这个键可以没有,没有的将不会显示
    //addText    附加选项文字 这个键可以没有,如果没有这个键但有附加选值那么文字将会和选项值一样。

    //$valueField  如果这个字段名的值跟value相同就让该下拉框被选中  这个键可以没有,默认值为id
    //$textField   显示在下拉框里的文字的数据字段  这个键可以没有,默认值为name

    //有些属性是可以为空就用默认值
    //要判断传来的数组有没有某个键如果没有就给他赋默认值
    if(! array_key_exists('value'      ,$arr))$arr['value'      ] = '';//预选值   默认值为空字符串
    if(! array_key_exists('attribute'  ,$arr))$arr['attribute'  ] = '';//附加属性 默认值为空字符串
    if(! array_key_exists('allClass'   ,$arr))$arr['allClass'   ] = '';//附加样式 默认值为空字符串
    if(! array_key_exists('valueField' ,$arr))$arr['valueField' ] = 'id';
    if(! array_key_exists('textField'  ,$arr))$arr['textField'  ] = 'name';

    $html = '<select ' . $arr['attribute'] . ' name="' . $arr['name'] . '">' . PHP_EOL;
    if(array_key_exists('addValue' ,$arr)){
        if(! array_key_exists('addText' ,$arr))$arr['addText'] = $arr['value'];
        $html .= '    <option value="' . $arr['addValue'] . '">' . $arr['addText'] . '</option>' . PHP_EOL;
    }
    $field     = $arr['valueField'];
    $textField = $arr['textField'];
    foreach ($arr['data'] as $rs){
        if($rs[$field] == $arr['value'] && strlen($rs[$field]) == strlen($arr['value'])){
            $html .= '<option value="' . $rs[$field] . '" selected>' . $rs[$textField] . '</option>' . PHP_EOL;
        }else{
            $html .= '<option value="' . $rs[$field] . '">' . $rs[$textField] . '</option>' . PHP_EOL;
        }
    }
    $html .= '</select>' . PHP_EOL;
    return $html;
}
function myPassword($password){//返回加密的密码
    $password = $password . '87L49d$%^^&46' . $password . '&#B50J5rrf8';
    return md5($password);
}
function rand_str($len)
{//生成随机字符
    $arr = explode(' ','0 1 2 3 4 5 6 7 8 9 a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z');
    $temp = '';
    $arr_count = count($arr);
    for($i = 0;$i < $len;$i++){
        $temp .= $arr[rand(0,$arr_count-1)];
    }
    return $temp;
}
function ipToCity($ip = ''){//根据IP返回城市
    if($ip == '')return '';
    $temp = substr($ip,0,3);
    if($temp == '192' || $temp == '127' || $temp == '0.0')return '局域网';
    $city = F('ip_to_city_' . $ip);//从缓存读取这个IP的所在地区
    if($city)return $city;//如果能读取就返回读取到的城市名
    //如果上面的从缓存读取不到就会执行下面的代码从第三方接口获取IP转地区JSON数据
    $json_str = myCurl('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip);
    if(strlen($json_str) < 20){
        F('ip_to_city_' . $ip,'获取失败');
        return '获取失败';
    }
    $json = json_decode($json_str,true);
    if(! $json)return '';//如果解析JSON失败就返回空值
    $re_arr = array();
    //下面的代码实现如果是正常的就从数组中取出省名 连接上 城市名 然后先缓存起来(用上面说的键)然后再返回
    if(array_key_exists('country',$json)){//判断是否有国家名
        if($json['country'] != '中国'){//如果不是中国的国名也取出存入数组里
            $re_arr[] = $json['country'];
        }
    }
    if(array_key_exists('province',$json)){//判断是否有省名
        $re_arr[] = $json['province'];//取出省名存入数组里
    }
    if(array_key_exists('city',$json)){//判断是否有市名
        $re_arr[] = $json['city'];//取出市名存入数组里
    }
    if(array_key_exists('district"',$json)){//判断是否有区名
        $re_arr[] = $json['district"'];//取出区名
    }
    $area_str = implode(' ',$re_arr);//把前面取出存入数组的国名，省名，市名，区名 连接起来
    F('ip_to_city_' . $ip,$area_str);//把结果缓存
    return $area_str;//返回结果
}

function myCurl($url,$post=array()) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//获取页面内容，不直接输出到页面
    if(count($post) > 0){
        curl_setopt($ch, CURLOPT_POST, 1);
        $post_str = '';
        foreach ($post as $key => $one) {
            $post_str .= $key . '=' . $one . '&';
        }
        $post_str = rtrim($post_str,'&');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
    }
    $re_str = curl_exec($ch);
    curl_close($ch);
    return $re_str;
}