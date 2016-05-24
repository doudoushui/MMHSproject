<?php


namespace Home\Controller;
use Think\Controller;
class FeedbackController extends Controller {
    
    
    	//显示商品列表
    public function index(){
        // var_dump($_SESSION);
        // echo '<pre>';
        //   print_r($_SESSION[username]);
        // echo '</pre>';

        //    // print_r($_SESSION);
        //    die();


        if(empty($_SESSION)){
            $users=0;
        }
      
    //     //创建对象
        $sug =M('suggestion');
        
        //获取每页显示的数量
      $num = !empty($_GET['num']) ? $_GET['num'] : 2;
       if(!empty($_GET['keyword'])){
            //有关键字
            $where = "username like '%".$_GET['keyword']."%'";
        }else{
            $where ='';
        }

        $count = $sug->where($where)->count();

        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new \Think\Page($count,$num);
        //获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;


       $sql = "SELECT u.id,u.username,s.id,s.user_id,s.stime,s.smsg FROM hs_user u, hs_suggestion s limit $limit";
       $sugs =$sug->query($sql);

       $pages = $Page->show();
       
        
    //     //分配变量
        $this->assign('sugs',$sugs);
        $this->assign('users',$users);
        $this->assign('pages',$pages);
    // 	//解析模板
    	$this->display();
    }


    // 添加信息
    public function insert(){
        if(empty($_SESSION)){
            $this->error('您没登陆',U('Home/Login/index'),'5');
        }

    	// var_dump($_POST);die;
    	$sug = M('suggestion');

        $_POST['stime'] = date("Y-m-d H:i:s");
        $_POST['user_id'] = $_SESSION['userid'];
        // var_dump($_POST);die;

        // $sug->create();
        $res = $sug->add($_POST);
        if ($res) {
            $this->success('添加成功', U('Home/Feedback/index'),300);
        }else{
            $this->error('添加失败', U('Home/Feedback/add'),300);
        }
    }

    //执行修改
    // public function update(){
    //     // var_dump($_POST);
    //      //创建数据表对象
    //     $orders = M('order');
    //     // var_dump($orders);
    //     // var_dump($_GET);
    //     // $orders->ostate = $_GET['ostate'];
    //     $ostate = $_GET['ostate'];
    //     $id = $_GET['id'];
    //     $data['id'] = $id;
    //     $data['ostate'] = $ostate;
    //    $res = $orders->save($data);
    //    echo '<pre>';
    //        print_r($res);
    //    echo '</pre>';
    //    if ($res) {
    //         $this->success('修改成功', U('Admin/Order/index'),0);
    //     }else{
    //         $this->error('修改失败', U('Admin/Order/index'),0);
    //     }
        
    // }
}