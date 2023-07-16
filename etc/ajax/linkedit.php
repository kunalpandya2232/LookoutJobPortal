<?php

require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class linkedit{
	private $link_sql ="UPDATE lo_tbllinks SET facebook=:fb ,twitter=:tw ,instagram =:inst ,linkedIn =:li WHERE  user_id =:uid";
	private $links="";
	private $conn ="";
	public $status="";


	public function setConn($conn)
	{
		$this->conn = $conn;
	}

	public function linkFunc($data){
		$this->links = $data;
		$this->user = $data['uid'];
		$ret = $this->insert();
		return $ret;
	}

	private function insert(){
		$ret =false;
		try{
			$stmt= $this->conn->prepare($this->link_sql);
			$stmt->execute(['uid'=>$this->user,'fb'=>$this->links['facebook'],'tw'=>$this->links['twitter'], 'inst'=>$this->links['instagram'], 'li'=>$this->links['linkedIn']]);
			$ret = true;
			$this->status = true;

		}catch(PDOException $e){
			$ret =false;
			$this->status = $e->getMessage();
		}
		return $ret;
	}
}

if ($_POST ) {
    $retData  = [];
    $err      = '';
    if(!empty($_POST['uid'])){
	    $reqFiles = new settings();
	    $reqFiles->get_required_files();
	    $reqFiles->get_valid_checker();
	    $valid   = new validChecker();
	    $data = $valid->cleanData($_POST);
	    // $data = $valid->fileterUrl($data);
	    if($data){	
	    $dbClass = new db();
	    $link = new linkedit();
	    $link->setConn($dbClass->getConn());
	    $res =$link->linkFunc($data);
		    if($res == true && $link->status==true){
			    $retData['result']='success';
			    $retData['error']="";
		    }else{
				$retData['result']='fail';
			    $retData['error']=$link->status;
		    }
	    }

    }else{
    	$retData['result']='fail';
	    $retData['error']="User not found";
    }

    echo json_encode($retData);

}
