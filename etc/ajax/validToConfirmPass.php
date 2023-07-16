<?php

session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;


class validToConfirmPass
{
    private $changeaPass_sql    = "SELECT user_password FROM lo_tblusers WHERE id=:uid";
    private $new_changePass_sql = "UPDATE lo_tblusers SET user_password=:newpass WHERE id=:uid";
    private $conn               = "";
    private $old_pass           = "";
    public  $status             = '';

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function changePassFunc($userId = '', $cpass = "")
    {

        if (!empty($this->old_pass) && !empty($userId) && is_numeric($userId)) {
            //verify with old pass
            try {
                $stmt = $this->conn->prepare($this->changeaPass_sql);
                $stmt->execute(['uid'=>$userId]);
                $ret = $stmt->fetch(PDO::FETCH_ASSOC);
                if($ret && is_array($ret)){
                    $pass = $ret['user_password'] == md5($this->old_pass)?'true':'false';
                    if($pass=="true"){
                        $ret = $this->changePass($userId,$cpass);
                    }else{
                        $ret = false;
                    }
                }else{
                    $ret =false;
                }

            } catch (PDOException $e) {
                $ret = false;
            }
            return $ret;
        }

    }

    private function changePass($userId="" , $new_Pass='')
    {
        try{
            $new_Pass = md5($new_Pass);
            $stmt = $this->conn->prepare($this->new_changePass_sql);
            $stmt->execute(['newpass'=>$new_Pass,'uid'=>$userId]);
            $ret = true;
        }catch (PDOException $e){
            $ret = false;
        }
        return $ret;
    }

    /**
     * @param string $old_pass
     */
    public function setOldPass(string $old_pass): void
    {
        $this->old_pass = $old_pass;
    }


}

if ($_POST && !empty($_POST['new_pass']) && !empty($_POST['c_pass'])) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid        = new validChecker();
    $data         = $valid->cleanData($_POST);
    $checker_pass = $valid->pass_confirm($data['new_pass'], $data['c_pass']);
    if ($checker_pass == ' ') {
        $dbClass             = new db();
        $conn                = $dbClass->getConn();
        $data['user_detail'] = $valid->getUserByEmail($conn, $_SESSION['email']);
        $validToConfirmPass  = new validToConfirmPass();
        $validToConfirmPass->setConn($conn);
        $validToConfirmPass->setOldPass($data['pass']);
        $ret = $validToConfirmPass->changePassFunc($data['user_detail']['Id'], $data['new_pass']);
        $retData['result'] = 'success';
        $retData['true']   = $ret;

    } else {
        $retData['result'] = 'fail';
        $retData['error']  = $checker_pass;
    }

    echo json_encode($retData);
}
