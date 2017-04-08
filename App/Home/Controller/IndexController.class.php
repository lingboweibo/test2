<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();//把首页http://localhost:8015/app.php?m=Home&c=Index&a=index 做成一个下单页面，然后下单提交到addSubmit
    }
    public function addSubmit(){//再做好下单接收
        $model = M('Order');
        $rules = array(
            array('consignee'   ,'require','收货人不能为空'                ,$model::MUST_VALIDATE  ,'regex'  ,$model::MODEL_INSERT,),//没有默认值的不能为空的字段新增时必须验证
            array('consignee'   ,'2,60'   ,'收货人的字数必须在2到60之间'   ,$model::EXISTS_VALIDATE,'length' ,$model::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
            array('address'     ,'require','地址不能为空'                  ,$model::MUST_VALIDATE  ,'regex'  ,$model::MODEL_INSERT,),//没有默认值的不能为空的字段新增时必须验证
            array('address'     ,'4,255'  ,'地址的字数必须在4到255之间'    ,$model::EXISTS_VALIDATE,'length' ,$model::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
            array('mobile'      ,'require','手机不能为空'                  ,$model::MUST_VALIDATE  ,'regex'  ,$model::MODEL_INSERT,),//没有默认值的不能为空的字段新增时必须验证
            array('mobile'      ,'11,60'   ,'手机的字数必须在11到60之间'   ,$model::EXISTS_VALIDATE,'length' ,$model::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
            array('for'         ,'0,2000' ,'来源的字数必须在0到2000之间'   ,$model::EXISTS_VALIDATE,'length' ,$model::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
            array('pro_name'    ,'require','请选择您要购买的产品'          ,$model::MUST_VALIDATE  ,'regex'  ,$model::MODEL_INSERT,),//没有默认值的不能为空的字段新增时必须验证
            array('pro_name'    ,'0,125'  ,'商品名称字数必须在0到125之间'  ,$model::EXISTS_VALIDATE,'length' ,$model::MODEL_BOTH  ,),//其它类型的不论新增还是编辑 存在字段就验证长度
        );

        $data['order_sn'    ] = date('YmdHis',time()) . rand_str(6);//订单编号 yyyymmddhhssii 14位时间+6位随机字符串
        $data['consignee'   ] = I('post.consignee');//收货人
        $data['address'     ] = I('post.address');//地址
        $data['mobile'      ] = I('post.mobile');//手机
        $data['total_amount'] = 0;//订单总价
        $data['add_time'    ] = date('Y-m-d H:i:s',time());//下单时间
        $data['for'         ] = I('post.for');
        $data['pro_name'    ] = I('post.pro_name');

        if (!$model->validate($rules)->create($data))$this->error($model->getError());

        //限制同一天同一个手机号不能重复下单 用查询数据库的方式比较想到
        // $map['mobile'] = $data['mobile'];
        // $a = date('Y-m-d H:i:s',time()- 60 * 60 * 24);
        // $b = date('Y-m-d H:i:s',time());
        // $map['add_time'] = array('BETWEEN',array($a,$b));
        // if($model->where($map)->getField('id'))$this->error('您今天已经下过单了，请不要重复下单，如果需要改单请与客服人员联系');

        //限制同一天同一个手机号不能重复下单 还有一个更好的方法，就是用缓存。要添加订单成功之后，把他的手机号存到缓存里有效期设置为一天
        if(S($data['mobile']) == '1')$this->error('您今天已经下过单了，请不要重复下单，如果需要改单请与客服人员联系');

        $pro_arr = C('PRO_ARR');
        foreach ($pro_arr as $key => $value) {
            if($data['pro_name'] == $value)$data['total_amount'] = $key;
        }
        if($data['total_amount'] == 0)$this->error($data['pro_name'] . '已经下架，请选择其它商品');

        $ok = $model->add($data);
        S($data['mobile'],'1',60 * 60 * 24);//以手机号为键，记录进缓存，有效期一天，让限制同一天同一个手机号不能重复下单使用
        if($ok === false)$this->error('下单失败');
        $this->success('下单成功，请注意保持电话畅通，我们的订单处理人员可能会与您电话联系。');
    }
}