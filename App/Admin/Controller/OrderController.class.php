<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends PubController {
    // public function batAddOrder(){
    //     $model = M('Order');
    //     $startTime = strtotime('-50 day');//先获取50天前的时间戮

    //     for($i=0;$i<500;$i++){
    //         $startTime += mt_rand(2,8640);//在循环里让时间戮 随机增加
    //         $data['add_time'       ] = date('Y-m-d h:i:s',$startTime);//给下单时间赋值为时间戮转成的时间字符串
    //         $data['order_sn'       ] = date('Ymdhis',$startTime) . rand_str(6);//订单编号 yyyymmddhhssii 14位时间+6位随机字符串
    //         $data['consignee'      ] = '收货人' . $i;
    //         $data['address'        ] = '地址' . $i;//地址
    //         $data['mobile'         ] = '158158' . $i;//手机
    //         $data['total_amount'   ] = $i * 2;//订单总价
    //         $data['for'            ] = '来源' . $i;//来源
    //         $data['pro_name'       ] = $this->proArr[mt_rand(0,count($this->proArr) - 1)];//随机产品名称
    //         echo $model->add($data) , ' ';
    //     }
    // }
    public function toExcel(){
        import('Org.Util.PHPExcel');//引入PHPExcel类库文件
        
        $excel = new \PHPExcel();//创建PHPExcel对象的实例
        $excel->setActiveSheetIndex(0)
            ->setCellValue('A1','hello')
            ->setCellValue('B2','b2 1234')
            ->setCellValue('C1','c1 agasfd')
            ->setCellValue('D2','d2 gg44');

        for ($i=0; $i < 15; $i++) { 
            $excel->getActiveSheet()->setCellValue('E' . ($i + 1),$i);
        }
        $excel->getActiveSheet()->setCellValue('A8','a8' . "\r\n" . 'abc中文');
        $excel->getActiveSheet()->setCellValue('A8','修改了');
        //$excel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
        $excel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);//设置A8可以换行

        import('Org.Util.PHPExcel.IOFactory');//引入PHPExcel类库IOFactory文件
        $obj = \PHPExcel_IOFactory::createWriter($excel,'Excel2007');//实例化
        $obj->save('test.xlsx');//调用保存excel文件
    }
    public function toExcel2(){
        //练习：在excel单元格里从1到50显示数字，每个单元格显示一个数字，每行只有前6个单元格显示数字
        import('Org.Util.PHPExcel');//引入PHPExcel类库文件
        
        $excel = new \PHPExcel();//创建PHPExcel对象的实例
        $excel->setActiveSheetIndex(0);

        //a  b  c  d  e  f
        //1  2  3  4  5  6
        //7  8  9  10 11 12
        //13
        //i 除以 6 的余数是1时，对应字母是a
        //i 除以 6 的余数是2时，对应字母是b
        //i 除以 6 的余数是3时，对应字母是c
        $j = 1;
        for ($i=1; $i < 51; $i++) {
            $j = ceil($i / 6);
            $m = $i % 6;
            if($m == 0)$m = 6;
            $excel->getActiveSheet()->setCellValue(chr(($m) + 64) . $j,$i);
        }

        import('Org.Util.PHPExcel.IOFactory');//引入PHPExcel类库IOFactory文件
        $obj = \PHPExcel_IOFactory::createWriter($excel,'Excel2007');//实例化
        $obj->save('test.xlsx');//调用保存excel文件
    }
    protected function _toExcel($model,$map){
        //echo '导出excel';
        $data = $model->where($map)->order('id')->select();
        import('Org.Util.PHPExcel');//引入PHPExcel类库文件
        $excel = new \PHPExcel();//创建PHPExcel对象的实例
        $excel->setActiveSheetIndex(0);//让第一个表是当前活动表

        //$filed数组定义Excel的列名和data里的字段名和关系，以及列宽
        $filed = array(
            'a' => array('id' , 'ID',8),
            'b' => array('order_sn' , '订单号',24),//array('order_sn' 是data里的字段名, '订单号'  是中文字字段名 ,24 是列宽度),
            'c' => array('pro_name' , '商品名称',24),
            'd' => array('consignee' , '收货人',8),
            'e' => array('address' , '地址',30),
            'f' => array('mobile' , '手机',14),
            'g' => array('total_amount' , '价格',8),
            'h' => array('add_time' , '时间',20),
            'i' => array('for' , '来源',40),
        );

        //循环写入表头和设置列宽度
        foreach ($filed as $k => $v) {
            $excel->getActiveSheet()->setCellValue($k . 1,$v[1]);//把中文字段名写入表头
            $excel->getActiveSheet()->getColumnDimension($k)->setWidth($v[2]);//设置列宽
        }

        //循环把$data里面的数据写入excel里面
        foreach ($data as $key => $value) {
            foreach ($filed as $k => $v) {
                $excel->getActiveSheet()->setCellValue($k . ($key + 2),$value[$v[0]]);
            }
        }

        import('Org.Util.PHPExcel.IOFactory');//引入PHPExcel类库IOFactory文件
        $obj = \PHPExcel_IOFactory::createWriter($excel,'Excel2007');//实例化

        $file_name = 'OutExcel/excel_' . date('Ymdhis') . rand_str(6) . '.xlsx';//随机生成一个文件名
        //文件名前面的 OutExcel 表示保存导出excel文件的目录，需要在项目根目录下建好OutExcel这个文件夹
        $obj->save($file_name);//调用保存excel文件

        //跳转到生成的excel文件的URL就会下载这个文件
        redirect($file_name, 0);
    }
    public function index(){
        $time_star = I('get.time_star');
        $time_end  = I('get.time_end');
        $is_out    = I('get.is_out','',FILTER_SANITIZE_NUMBER_INT);
        $pro_name  = I('get.pro_name');

        $time_star = str_replace('T',' ',$time_star);//HTML5 本地日期时间输入框的vvalue会自动在日期和时间之间加一个T，这里把T替换为空格
        $time_end  = str_replace('T',' ',$time_end);//HTML5 本地日期时间输入框的vvalue会自动在日期和时间之间加一个T，这里把T替换为空格
        $time_star = str_replace('t',' ',$time_star);//有可能有的浏览器会加小写的t这里也替换一次
        $time_end  = str_replace('t',' ',$time_end);//有可能有的浏览器会加小写的t这里也替换一次

        $map = array();
        if($pro_name != ''){//判断如果提交来的产品下标不为空，那就增加下面一个模糊搜索条件
            $name = '搜索结果';
            $map['pro_name'] = array('LIKE','%' . $pro_name . '%');
        }

        if($time_star !== '' || $time_end !== ''){
            if($time_star !== '' && $time_end !== ''){
                $map['add_time']  = array('between', $time_star . ',' . $time_end);
            }else{
                if($time_star)$map['add_time'] = array('EGT',$time_star);
                if($time_end) $map['add_time'] = array('ELT',$time_end);
            }
        }
        if($is_out === '0'   )$map['is_out'   ] = 0;
        elseif($is_out == 1  )$map['is_out'   ] = 1;

        $orderField = 'id desc';
        $model = M('order');
        if(I('get.to_excel') == '1'){//如果get传来的to_excel是等于1就执行导出
            //实现导出功能的代码写在这里
            $this->_toExcel($model,$map);//调用_toExcel方法实现导出excel,传$map条件过去 让index里面获取条件的代码列表页和导出功能共同，不用再写一遍
        }else{//如果get传来的to_excel 不是等于1就执行下面的显示普通的列表页面
            $count = $model->where($map)->count('id');
            $page  = new \Think\Page($count,12);
            $pageHtml = $page->show();
            $data = $model->where($map)->limit($page->firstRow.','. $page->listRows)->order($orderField)->select();

            $this->assign('data',$data);
            $this->assign('pageHtml',$pageHtml);
            $this->assign('count',$count);
            $this->assign('time_star',I('get.time_star'));
            $this->assign('time_end',I('get.time_end'));
            $this->assign('is_out',$is_out);
            $this->assign('pro_name',$pro_name);
            $this->display();
        }
    }
}