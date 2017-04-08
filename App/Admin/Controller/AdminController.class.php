<?php
namespace Admin\Controller;//注意模块名首字母大写
use Think\Controller;
class AdminController extends PubController{//注意控制器名首字母大写
    public function index(){
        $model = M('admin');
        $map['is_del']  = array('in','0,2');

        $key_word = I('get.key_word');//获取get提交来的搜索关键字
        $id = I('get.id','',FILTER_SANITIZE_NUMBER_INT);
        if($key_word != ''){//判断如果提交来的搜索关键字不为空，那就增加下面一个模糊搜索条件
            $key_word = trim($key_word);
            $name = '搜索结果';
            $map['name|username'] = array('LIKE','%' . $key_word . '%');
        }
        if($id != ''){
            $map = array('id' => $id);//如果用ID搜索，就忽略其它条件
            $name = '根据ID搜索';
        }

        $count = $model->field('count(id) as count')->where($map)->find();//先获取记录数 页面显示用和分页类要用
        $this->assign('count',$count['count']);
        $data = $model->where($map)->select();//给模型的where方法设置查询条件，再用模型的select 方法查询记录，最后返回的查询结果是一个二维数组，赋值$data这个变量
        $this->assign('data',$data);//把$data这个二维数组传给模板文件，模板文件也用data 变量来接收
        $this->assign('key_word',$key_word);
        $this->assign('id',$id);
        $this->display();
    }
    public function add(){
        $this->display();
    }
    public function addSubmit(){
        //获取POST提交来的值，赋值给$data数组
        $data['name'       ] = I('post.name');
        $data['work_code'  ] = I('post.work_code');
        $data['username'   ] = I('post.username');
        $data['password'   ] = I('post.password');
        $data['repassword' ] = I('post.repassword');

        $model = D('admin');//用D方法能获取自定义的模型类的实例，M方法获取就是TP的核心文件里定义的类的实例
        //获取到自定义的模型类的实例，里面有自定义的验证规则
        //这里获取到的是 C:\web_study\php\mou_shop\Application\Admin\Model\AdminModel.class.php这个类的一个实例

        if ($model->create($data) === false){//create是创建数据的方法，同时会验证 . 这里传一个$data过表示对data数据进行验证
            //如果create 返回 false 就表示没有通过验证
             $this->error($model->getError());//getError获取错误信息的方法，如果验证没有通过的话，获取错误信息就能获取到相应的验证规则里的错误信息
        }
        $data['password'] = myPassword($data['password']);
        //用模型的add方法添加记录，这里传data参数就是我们要加的记录的数据，它是一个一维数组，数组的键名就对应字段名，值就是要写入到表里的值
        $ok = $model->add($data);//add方法执行后如果成功会返回添加的记录的主键的值，如果不成功就会返回 false
        if($ok === false)$this->error('添加失败');//返回 false 就表示不成功，然后就显示错误提示
        $this->success('添加成功，正在返回员工列表', U('index'));
    }
    public function edit(){//修改员工的表单
        //先获取传来的id，经过过滤和判断
        $id = I('get.id','',FILTER_SANITIZE_NUMBER_INT);//FILTER_SANITIZE_NUMBER_INT 表示过滤非数字
        if($id == '')$this->error('id不能为空');

        //然后创建模型给模型增加ID条件，读取一条记录
        //因为这里只是读取，不是添加记录，也不是修改记录，所以不用验证提交来的字段值。修改是提交之后，提交到editSubmit这个方法里修改\
        //M方法因为不用获取自己定义模型类，少加载文件，少运行代码，这样性能就会比较好一点
        //where用数组作为条件是TP推荐的做法，这样能进行预处理，避免SQL注入的安全问题
        $model= M('admin');
        $data = $model->where(array('id' => $id))->find();//如果查询出错，find方法返回false，如果查询结果为空返回NULL，查询成功则返回一个关联数组（键值是字段名或者别名）
        if($data === false)$this->error('出错了，原因' . $model->getDbError());//提示出错之后，后面的代码不会执行
        if($data === NULL )$this->error('找不到这个员工');//提示出错之后，后面的代码不会执行
        $this->assign('data',$data);//把$data这个一维数组传给模板文件，模板文件也用data 变量来接收
        $this->display();
    }
    public function editSubmit(){//修改员工的表单的接收处理
        //获取POST提交来的值，赋值给$data数组
        $id = I('post.id','',FILTER_SANITIZE_NUMBER_INT);//FILTER_SANITIZE_NUMBER_INT 表示过滤非数字
        if($id == '')$this->error('id不能为空');

        $data['name'     ] = I('post.name');
        $data['work_code'] = I('post.work_code');
        $data['username' ] = I('post.username');
        $data['password' ] = I('post.password');

        //判断提交来的密码是不是为空，如果为空就把$data数组里的'password'这个键删除掉
        //这样到保存时$data里没有password这个键就不会更新password这个字段
        if($data['password'] == ''){
            unset($data['password']);
        }else{
            $data['password'] = myPassword($data['password']);
        }

        //验证提交的数据
        $model = D('admin');//用D方法能获取自定义的模型类的实例，M方法获取就是TP的核心文件里定义的类的实例
        //获取到自定义的模型类的实例，里面有自定义的验证规则
        //这里获取到的是 C:\web_study\php\mou_shop\Application\Admin\Model\AdminModel.class.php这个类的一个实例

        $map['username'] = $data['username'];
        $map['id'] = array('NEQ',$id);
        if($model->where($map)->getField('id') !== NULL)$this->error('此用户名已被别人使用!');


        //create方法增加了第二个参数：$model::MODEL_UPDATE 表示当前是更新数据的验证
        //详见http://www.kancloud.cn/manual/thinkphp/1759 里的数据操作状态
        if ($model->create($data,$model::MODEL_UPDATE) === false){//create是创建数据的方法，同时会验证 . 这里传一个$data过表示对data数据进行验证
            //如果create 返回 false 就表示没有通过验证
            $this->error($model->getError());//getError获取错误信息的方法，如果验证没有通过的话，获取错误信息就能获取到相应的验证规则里的错误信息
        }
        $ok = $model->where(array('id' => $id))->save($data); //根据条件更新记录
        //save方法的返回值是影响的记录数，如果返回false则表示更新出错，因此一定要用恒等来判断是否更新失败
        if($ok === false)$this->error($model->getError());//如果调用了$this->error 之后不会执行后面的代码
        if($ok === 0){
            $this->success('数据没有被改变，您可能什么也没有改', U('index'));//注意：如果调用了$this->success 之后还会执行后面的代码
        }else{
            $this->success('修改成功', U('index'));
        }
    }
    public function editMy(){//员工修改自己的密码
        $this->display();
    }
    public function editMySubmit(){//接收修改我的密码的处理程序
        $data['username'   ] = I('post.username');
        $data['password'   ] = I('post.password');
        if($data['password'] != I('post.repassword'))$this->error('新密码与确认密码不一致');
        if(I('post.old_password') == '')$this->error('旧密码不能为空');

        $model = D('Admin');

        $map['username'] = $data['username'];
        $map['id'] = array('NEQ',$id);
        if($model->where($map)->getField('id') !== NULL)$this->error('此用户名已被别人使用!');

        $old_password = $model->where(array('id' => session('adminLoginData.id')))->getField('password');
        if($old_password == null)$this->error('数据异常，请重新登录');
        if($old_password != myPassword(I('post.old_password')))$this->error('旧密码错误');

        if ($model->create($data,$model::MODEL_UPDATE) === false){
            $this->error($model->getError());
        }
        $data['password'] = myPassword($data['password']);
        $ok = $model->where(array('id' => session('adminLoginData.id')))->save($data);
        if($ok === false)$this->error($model->getError());
        if($ok === 0){
            $this->success('数据没有被改变，您可能什么也没有改', U('index'));
        }else{
            //如果改了用户名，要同时更新session里的用户名
            if($data['username'] != session('adminLoginData.username'))session('adminLoginData.username',$data['username']);
            $this->success('修改成功', U('index'));
        }
    }
    public function del(){
        $this->_setIsDel(1,'删除','Admin');
    }
    public function stop(){
        $this->_setIsDel(2,'停用','Admin');
    }
    public function recovery(){
        $this->_setIsDel(0,'恢复','Admin');
    }
}
// http://localhost:8015/index.php?m=Admin&c=Admin&a=del&id=7
//    http://localhost:8015/index.php?m=Admin&c=Admin&a=index
//    http://localhost:8015/index.php?m=Admin&c=Admin&a=setIsDel