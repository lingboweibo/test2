<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
    // array(1验证字段1,2验证规则,3错误提示,[4验证条件,5附加规则,6验证时间]),
   protected $_validate = array(
        array('username' ,'require','用户名不能为空'                 ,self::MUST_VALIDATE  ,'regex'  ,self::MODEL_INSERT,),//没有默认值的不能为空的字段新增时必须验证
        array('username' ,'0,16'   ,'用户名的字数必须在0到16之间'    ,self::EXISTS_VALIDATE,'length' ,self::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度

        array('password' ,'require','密码不能为空'                   ,self::MUST_VALIDATE  ,'regex'  ,self::MODEL_INSERT,),//新增时必须验证
        array('password' ,'0,32'   ,'密码的字数必须在0到32之间'      ,self::EXISTS_VALIDATE,'length' ,self::MODEL_INSERT,),//新增时必须验证

        array('name'     ,'0,32'   ,'姓名的字数必须在0到32之间'      ,self::EXISTS_VALIDATE,'length' ,self::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
        array('work_code','0,32'   ,'工号的字数必须在0到32之间'      ,self::EXISTS_VALIDATE,'length' ,self::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度

        //验证此字段的提交值，有没有在数据库的这个表的这个字段里存在
        //修改员工时不能用下面这条规则，因为自己使用的用户名也会被验证出是被别人使用
        array('username','','这个用户名已被别人使用',self::MUST_VALIDATE,'unique',self::MODEL_INSERT),//最后这个参数是1就表示新增数据时候验证

        array('password','repassword','密码跟确认密码不一致',self::MUST_VALIDATE,'confirm',self::MODEL_INSERT),
        //array(1验证字段1,2验证规则,3错误提示,4验证条件,5附加规则,6验证时间),
        //confirm   验证表单中的两个字段是否相同，定义的验证规则是一个字段名
   );
}