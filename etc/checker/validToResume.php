<?php



session_start();
require '../../config/settingsFiles.php';
if (!class_exists("uploadResumeFunc")) {
    require "validToUpload.php";

}

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$err      = [];
$retData  = [];
$reqFiles = new settings();
$reqFiles->get_required_files();

class validToResume extends uploadResumeFunc
{
    private $resume_sql = "UPDATE lo_tblprofileuser pu SET pu.jobS_resume =:path WHERE pu.user_id= :uid";
    private $getResume_sql = "SELECT pu.jobS_resume FROM lo_tblprofileuser pu INNER JOIN lo_tblusers u ON pu.user_id = u.id WHERE pu.user_id= :uid AND u.user_type='J'";
    private $delete_sql = "UPDATE lo_tblprofileuser pu SET pu.jobS_resume =NULL WHERE pu.user_id= :uid";
    private $conn       = "";
    private $resume       = "";
    private $id         = '';

    /**
     * @param string $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function resumeFunc($data, $id)
    {
        $this->id = $id;
        $ret      = false;
        if (!empty($id) && is_array($data['file'])) {
            $up = $this->upload($data);
            if ($up) {
                $ret = $this->update($data);
            }

        }
        return $ret;
    }

    private function upload($file)
    {
        $ret = false;
        if (!empty($file['file']['name'])) {
            $fileP   = $this->fDir . basename($file['file']['name']);
            $fileTmp = $file['file']['tmp_name'];
            if (is_dir($this->fDir)) {
                $ret = move_uploaded_file($fileTmp, $fileP);
            }
        }
        return $ret;
    }

    private function update($file)
    {
        $ret = "";
        try {
            $stmt = $this->conn->prepare($this->resume_sql);
            $stmt->execute(['path' => $file['file']['name'], 'uid' => $this->id]);
            $ret = true;
        } catch (PDOException $e) {
            $ret = $e;
        }
        return $ret;
    }

    public function delete($id)
    {
        $ret = "";
        try {
            $stmt = $this->conn->prepare($this->getResume_sql);
            $stmt->execute(['uid' => $id]);
            $this->resume = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $ret = $e;
        }
        try {
            $stmt = $this->conn->prepare($this->delete_sql);
            $stmt->execute(['uid' => $id]);
            $ret = true;
        } catch (PDOException $e) {
            $ret = $e;
        }
        return $ret;
    }
    public function unlinkResume(){
        if(!empty($this->resume['jobS_resume'])&& $this->resume['jobS_resume']!=NULL){
            unlink(_UPLOAD.'resumes/'.$this->resume['jobS_resume']);
        }
    }

}

if ($_FILES) {
    $reqFiles->get_valid_checker();
    $valid  = new validChecker();
    $dbFile = new db();
    $conn   = $dbFile->getConn();
    $resume = new validToResume();
    $resume->setConn($conn);
    $resume->validToUploadFunc($_FILES, 'resume', 'file');
    $err = $resume->status;
    if (count($err) < 1) {
        $user = $valid->getUserByEmail($conn, $_SESSION['email']);
        $res  = $resume->resumeFunc($_FILES, $user['Id']);
        if ($res) {
            $retData['result'] = true;
        } else {
            $retData['result'] = false;
            $retData['err']    = $res;
        }
    } else {
        $retData['result'] = false;
        $retData['err']    = $err;
    }
    echo json_encode($retData);
}
if ($_POST && !empty($_POST['id'])) {
    $retData=[];
    $reqFiles->get_valid_checker();
    $valid = new validChecker();
    $data  = $valid->cleanData($_POST['id']);
    if ($data) {
        $dbFile = new db();
        $conn   = $dbFile->getConn();
        $resume = new validToResume();
        $resume->setConn($conn);
        $res = $resume->delete($data);
        if ($res==true) {
            $resume->unlinkResume();
            $retData['result'] = true;
        } else {
            $retData['result'] = false;
            $retData['err']    = $res;
        }
    }
    echo json_encode($retData);

}
