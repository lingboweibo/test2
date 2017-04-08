<?php
namespace Admin\Controller;//注意模块名首字母大写
use Think\Controller;
class PubController extends Controller {//注意控制器名首字母大写
    function __construct(){
        parent::__construct();//调用父类的构造函数。这里的父类是TP的核心控制器
        //现在后台除登录控制器之外，其它的控制器都要先经过登录才能进入
        //所以这里要判断当前不是  登录控制器 才调用【断是否登录，如果没登录就跳转到登录页面】这个方法
        //判断当前控制器名就能识别出来是不是登录控制器
        if(CONTROLLER_NAME != 'Login'){
            $this->_ifLoginGo();
        }
        //读取配置文件里的产品，赋值给当前这个控制器的proArr属性，因为这是公共控制器，然后其它继承这个公共控制器的控制器都会有proArr属性
        $this->proArr = C('PRO_ARR');

        //把控制器的proArr属性传给模板文件，因为这是公共控制器，然后其它继承这个公共控制器的控制器渲染的模板都能直接用这个proArr变量
        $this->assign('proArr',$this->proArr);
    }

    protected function _ifLogin(){//判断是否登录 有的情况下没登录也不跳转。此方法实现判断是否登录，如果是已登录就返回true，没登录就返回false
        $adminId = session('adminLoginData.id');//把登录时保存登录用户信息的id读取出来
        $adminIp = session('adminLoginData.ip');//把登录时保存登录用户信息的ip读取出来
        if(empty($adminId))return false;
        if(empty($adminIp))return false;
        if($adminIp != get_client_ip())return false;//如果登录时的IP跟现在的IP不一样，也把他当作没有登录，这样是为安全考虑
        //优点是安全，缺点是如果真正管理员登录之后又换了IP他就会当作没有登录，就需要再登录新登录，如果客户不喜欢这样，他也不是需要这么安全，那就可以不判断IP是否相同
        return true;
    }
    protected function _ifLoginGo(){//判断是否登录，如果没登录就跳转到登录页面
        $ifLogin = $this->_ifLogin();//判断是否登录 如果是已登录就返回true，没登录就返回false
        if($ifLogin === false)$this->error('请登录',U('Login/login'));
    }
    protected function _setIsDel($num,$str,$tabName){//方法名前面加了_ 或加修饰符 修饰为私有的或受保护的，这样的方法 就不能通过网址访问
        //这样不能通过网址直接访问的控制器里的方法就不属于操作
        $id = I('get.id','',FILTER_SANITIZE_NUMBER_INT);//FILTER_SANITIZE_NUMBER_INT 表示过滤非数字
        if($id == '')$this->error('id不能为空');
        $model= M($tabName);
        $ok = $model-> where(array('id' => $id))->setField('is_del',$num);
        if($ok === false)$this->error($model->getError());//如果调用了$this->error 之后不会执行后面的代码
        if($ok === 0){
            $this->success('数据没有被改变，可能之前已经' . $str . '过', U('index'));//注意：如果调用了$this->success 之后还会执行后面的代码
        }
    }
}