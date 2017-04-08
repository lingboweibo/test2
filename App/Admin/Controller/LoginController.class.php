<?php
namespace Admin\Controller;//注意模块名首字母大写
use Think\Controller;
class LoginController extends PubController {//注意控制器名首字母大写
    public function login(){
        //$this->_test();
        $this->display();//渲染模板
    }
    public function loginSubmit(){
        //获取提交来的用户名
        $username = I('post.username');
        $password = I('post.password');
        $model = M('admin');//得到一个员工表的模型

        //定义一个动态验证规则(它是一个数组)
        $rules = array(
            array('username','require','用户名不能为空',1),
            array('username','3,32','用户名字数必须在3到32之间',1,'length'),
            array('password','require','密码不能为空',1),
            array('password','3,32','密码字数必须在3到32之间',1,'length'),
        );
        if (!$model->validate($rules)->create()){//如果创建失败 表示验证没有通过 输出错误提示信息
             $this->error($model->getError());//$model->getError()是获取模型的错误信息的方法
        }
        $model->where(array('username' => $username,'is_del' => 0));//加了条件
        //where username = 传来username AND is_del = 0
        $data = $model->field('id,username,password')->find();//调用模型的查询一条记录的方法,把返回的记录赋值给 $data变量，它是一个一维数组，数组的键就是字段名，值就是字段值

        if($data === null)$this->error('用户名或密码不对');//这里是用户名不对，但不能提示他用户名不对，是为了考虑安全
        if($data['password'] != myPassword($password))$this->error('用户名或密码不对');//这里是密码不对，但不能提示他密码不对，是为了考虑安全
        //如果代码能运行到这里就说明用户名和密码都对，登录成功
        //
        //现在数据库里的密码是80a983fdb7bb33e880ce322b56588fb1 （是用admin经过我们加密函数加密的）
        //                    80a983fdb7bb33e880ce322b56588fb1 （登录时提交的密码是admin，再把它经过我们加密函数加密）

        //get_client_ip 是TP的公共的函数，作用是用来获取用户的IP的
        $data['ip'] = get_client_ip();//给$data['ip'] 赋值为现在获取到的用户IP
        unset($data['password']);//销毁$data['password']
        session('adminLoginData',$data);//保存到session 作为登录凭据

        //所以登录控制器的loginSubmit操作里要增加给登录成功的用户更新他的上次登录时间、上次登录IP字段的功能
        //更新数据用模型的save 方法 ，可以传一个数据数组，这个数组是一个一维关联数组，键名要跟字段名对应，值就是要保存的值。
        $data['last_time'] = date('Y-m-d H:i:s');
        $model->where(array('id' => $data['id']))->save($data); //根据条件更新记录
        redirect(U('Admin/index'), 0, '页面跳转中...');
    }
    public function quit(){//注销
        session('adminLoginData',null);
        $this->success('注销成功',U('login'));
    }
}
// http://localhost:8015/app.php?m=Admin&c=Login&a=login