<?php
function but_link($arr){
	//作用是返回像按钮那样的链接的HTML
	//参数是一个数组，有下面的键
	//url 链接的url
	//title 链接文字       这个键可以没有
	//ico 图标的class      这个键可以没有
	//attribute 附加属性   这个键可以没有
	//allClass 附加样式    这个键可以没有
	//
	//有些属性是可以为空就用默认值
	//要判断传来的数组有没有某个键如果没有就给他赋默认值
	if(array_key_exists('attribute',$arr) === false)$arr['attribute'] = '';//附加属性 默认值为空
	if(array_key_exists('allClass' ,$arr) === false)$arr['allClass' ] = '';//附加样式 默认值为空
	if(array_key_exists('ico'      ,$arr) === false)$arr['ico'      ] = '';//图标的class 默认值为 icon-link
	if(array_key_exists('title'    ,$arr) === false)$arr['title'    ] = '';//文字

	if($arr['allClass'] != '') $arr['allClass'] = ' ' . $arr['allClass'];//如果附加样式名不为空就在前面加一个空格

	return '<a' . $arr['attribute'] . ' href="' . $arr['url'] . '" class="btn' . $arr['allClass'] . '"><span class="' . $arr['ico'] . '"></span>' . $arr['title'] . '</a>';
}