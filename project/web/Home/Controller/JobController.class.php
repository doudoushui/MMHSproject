<?php 
namespace Home\Controller;
use Think\Controller;
class JobController extends Controller {
	public function index(){
		//创建对象
		$job = M('job');

		/*echo $job->_sql();
		echo $job->getLastSql();*/

		//获取每页显示的数量
		$num = !empty($_GET['num']) ? $_GET['num'] : 12;

		//获取关键字
		if (!empty($_GET['keyword'])) {
			//有关键字
			$where = "work like '%".$_GET['keyword']."%'";
		}else{
			$where = '';
		}

		// //查询满足要求的总记录数
		$count = $job->where($where)->count();
		// //实例化分页类 传入中记录数和每页显示的记录数
		$Page = new \Think\Page($count,$num);
		// //获取limit参数
		$limit = $Page->firstRow.','.$Page->listRows;

		//查询
		$jobs = $job->where($where)->limit($limit) -> order(p,1) ->select();
		// var_dump($jobs);

		//分页显示输出
		$pages = $Page->show();

		//分配变量
		$this->assign('jobs',$jobs);
		$this->assign('pages',$pages);
		//解析模板
		$this->display();
	}

	public function ajax(){
        //创建表对象
        $job = M('job');
        
        // $res = $job->save($_POST);
        $jobs = $job -> page($_POST['p'],6) -> order('id') ->select();
        //json_encode($jobs);
       
       //向ajax返回数据
        if ($jobs) {
            echo json_encode($jobs);
        }else{
            echo 0;
        }
    } 

    public function intro(){
    	//解析模板
    	$this->display();
    }


 }
?>