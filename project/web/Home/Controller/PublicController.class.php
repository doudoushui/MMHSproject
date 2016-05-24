<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

	public function CreateVcode(){
		$Verify = new \Think\Verify();
		// // $Verify -> length = 3;
		$Verity -> fontsize = 40;
		$Verify->entry();

		

	}


}