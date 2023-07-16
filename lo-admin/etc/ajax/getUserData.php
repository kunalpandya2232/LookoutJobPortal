<?php

/**
 * Author: Shyam PC
 * Project: Clg_project
 * Date: 4/3/2022
 */

session_start();
require '../../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class getUserData{
    private $getUser_sql ="SELECT u.id as 'uid', pu.id as 'puid',u.*,pu.* FROM lo_tblusers as u INNER JOIN lo_tblprofileuser as pu ON pu.user_id = u.id WHERE u.id=:uid";
    private $conn ='';
    public $status ="";

    /**
     * @param string $conn
     */
    public function setConn( $conn): void
    {
        $this->conn = $conn;
    }

    public function getUserDataFunc($id){
        $ret =false;
        $id = base64_decode($id);
        try{
            $stmt = $this->conn->prepare($this->getUser_sql);
            $stmt->execute(['uid'=>$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            $ret = $res;
            $this->status=true;
        }catch (PDOException $e){
            $ret = $e->getMessage();
            $this->status=false;
        }
        return $ret;
    }
}

if($_POST) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $dbClass = new db();
    $getdata = new getUserData();
    $getdata->setConn($dbClass->getConn());
    $res = $getdata->getUserDataFunc($_POST['id']);

    if($res == false){
        $retData['success']=false;
    }elseif(is_array($res)){
        $retData['success']=true;
        $res['user_dob']=date("Y-m-d",strtotime($res['user_dob']));
        $retData['data']=$res;
    }else{
        $retData['success']=false;
        $retData['error']=true;
    }
    echo json_encode($retData);
}
