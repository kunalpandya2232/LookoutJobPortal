<?php



if (!isset($_SESSION)) {
    session_start();
    require '../../config/settingsFiles.php';
    require '../../config/mailFile.php';
    require_once '../mail/src/PHPMailer.php';
    require_once '../mail/src/SMTP.php';
    require_once '../mail/src/Exception.php';
}

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
use config\mailFile\mailFile as mail;

    class acceptUser extends mail
    {
        private $applier_sql = "UPDATE lo_tblapplier SET apply=:app where id=:id;";
        private $conn        = '';
        private $useremail_sql   = "SELECT u.user_email as 'email' FROM lo_tblapplier as appl INNER JOIN lo_tblusers as u ON appl.user_id = u.id WHERE appl.id = :id";
        private $jobDetail_sql   = "SELECT pu.org_name as 'comp_name', u.user_fname as 'fname', job.job_title FROM lo_tblapplier as appl INNER JOIN lo_tbljobs as job ON job.id = appl.job INNER JOIN lo_tblusers as u ON job.user_id = u.id INNER JOIN lo_tblprofileuser as pu ON pu.user_id = u.id  WHERE appl.id = :id";
        private $useremail   = "";
        private $jobDetail   = "";
        public  $status      = '';

        public function setConn($conn)
        {
            $this->conn = $conn;
        }

        public function acceptUserFunc($mode, $id)
        {
            $ret = false;
            try {
                $stmt = $this->conn->prepare($this->applier_sql);
                $stmt->execute(['app' => $mode, 'id' => $id]);
                $ret          = true;
                $this->status = true;

            } catch (PDOException $e) {
                $this->status = false;
            }
            return $ret;
        }

        public function sendMailFunc($mode,$id){
            $ret = false;
            $this->getUserEmail($id);
            $this->getJobDetail($id);
            if(!empty($this->useremail) && $this->useremail !=NULL ){
                if($this->jobDetail['comp_name'] ==NULL || $this->jobDetail['comp_name']== ''){
                    $company = $this->jobDetail['fname'];
                }else{
                    $company = $this->jobDetail['comp_name'];
                }
                if($mode=='1'){
                    $subject = "Job Accepted";
                    $content = "Here we Glad to say, Your request of Job application <b>" . $this->jobDetail['job_title'] . "</b> is acccepted. <br> Employee of ". $company ." will contact you soon.<hr> Have a Happy Journey further <br> Thanks LOOKOUT";
                }
                if($mode == '2'){
                    $subject = "Job Denied";
                    $content = "Your request of Job application <b>" . $this->jobDetail['job_title'] . "</b> is denied. <br> By ". $company." <hr> Thanks LOOKOUT";

                }
                $res = $this->sendMail($this->useremail,$subject,$content);
                if ($res == true) {
                    $this->status = 'success';
                    $ret          = true;
                } else {
                    $this->status = 'error' . $res;
                }
            }
            return $ret;
        }

        public function getUserEmail($id){
            try{
                $stmt = $this->conn->prepare($this->useremail_sql);
                $stmt->execute(['id'=>$id]);
                $res= $stmt->fetch(PDO::FETCH_ASSOC);
                if($res && $res['email']){
                    $this->useremail = $res['email'];
                    $this->status = true;
                }else{
                    $this->useremail = "";
                }

            }catch (PDOException $e){
                $this->status = false;
            }
        }

        private function getJobDetail($id){
            try{
                $stmt =$this->conn->prepare($this->jobDetail_sql);
                $stmt->execute(['id'=>$id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($res){
                    $this->jobDetail=$res;
                }
            }catch (PDOException $e){

            }
        }
    }

if ($_POST) {
    $retData  = [];
    $res=false;
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $dbClass = new db();
    $accept  = new acceptUser();
    $accept->setConn($dbClass->getConn());

    if ($_POST['mode'] == 'accept') {
        $mode = '1';
        $res  = $accept->acceptUserFunc($mode, $_POST['uid']);
        if($res){
            $mail_res = $accept->sendMailFunc($mode,$_POST['uid']);
            if($mail_res){
                $retData['mail'] = 'Sucess';
            }else{
                $retData['mail'] = $accept->status;
            }
        }
    } elseif ($_POST['mode'] == 'deny') {
        $mode = '2';
        $res  = $accept->acceptUserFunc($mode, $_POST['uid']);
        if($res){
            $mail_res = $accept->sendMailFunc($mode,$_POST['uid']);
            if($mail_res){
                $retData['mail'] = 'Sucess';
            }else{
                $retData['mail'] = $accept->status;
            }
        }
    }
    if ($accept->status || $res) {
        $retData = [
            'result' => 'success',
        ];
    } else {
        $retData = [
            'result' => 'fail',
            'err'=>$accept->status
        ];
    }

echo json_encode($retData);

}
