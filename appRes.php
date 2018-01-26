<?php
/**
* 
*/
class appRes{
	// 状态0 成功，否则失败
	var $status;
	// 提示信息
	var $msg;
	// 数据
	var $data;

	// 构造方法
	public function __construct(){
		$this->status = 0;
		$this->msg = "成功";
	}

	// 设置状态和信息
	public function setStatusAndMsg($status,$msg){ 
	    $this->status = $status;
		$this->msg= $msg;
	} 

	// 设置数据
	public function setData($data){
		$this->data = $data;
	}
}
?>