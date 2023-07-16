<?php


session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class verifyPass
{
    private $verify_sql ="SELECT user_password FROM lo_tblusers WHERE id=:id LIMIT 1";
    private $conn ="";
    public $status='';

    /**
     * @param string $conn
     */
    public function setConn($conn): void
    {
        $this->conn = $conn;
    }

    public function getPassRecord($id){
        try{
            $stmt=$this->conn->prepare($this->verify_sql);
            $stmt->execute(['id'=>$id]);
            $res=$stmt->fetch(PDO::FETCH_ASSOC);
            $ret = $res;
            $this->status=true;
        }catch (PDOException $e){
            $this->status = false;
            $ret = false;
        }
        return $ret;
    }
    public function checkPassword($pass='',$passcheck=''){
        return md5($passcheck)==$pass ? 'true':'false';
    }
}
if($_POST){
    $retData  = [];
    $err      = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid   = new validChecker();
    $dbClass = new db();
    if($_POST['pass']){
        $conn=$dbClass->getConn();
        $verify = new verifyPass();
        $verify->setConn($conn);
        $user = $valid->getUserByEmail($conn,$_SESSION['email']);
        if(is_array($user)){
            $res = $verify->getPassRecord($user['Id']);
            if(is_array($res) && $verify->status){
                $verifyPass = $verify->checkPassword($res['user_password'],$_POST['pass']);
                if($verifyPass=='true'){
                    $retData['result'] = $verifyPass;
                }else{
                    $retData['error']="Password is not Correct";
                    $retData['result'] = '';
                }
            }else{
                $retData['result'] = $res;
                $retData['error']="Some thing wrong on pass";
            }
        }else{
            $retData['error'] = 'Id not Found';
            $retData['result'] = '';

        }
    }
    echo json_encode($retData);
}
