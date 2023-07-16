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

class validToUpdatImage extends uploadImageFunc
{
    private $image_sql = "UPDATE lo_tblusers u SET u.user_photo =:path WHERE u.id= :uid";
    private $getImage_sql = "SELECT u.user_photo as 'image' FROM lo_tblusers u WHERE u.id= :uid";
    private $conn       = "";
    private $image       = "";
    private $id         = '';

    /**
     * @param string $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function imageFunc($data, $id)
    {
        $this->id = $id;
        $ret      = false;
        $img = false;
        if (!empty($id) && is_array($data['file'])) {
            $up = $this->upload($data);
            if ($up) {
                $img = $this->getLstImage($this->id);
                if($img){
                    $ret = $this->update($data);
                }else{
                    //default
                    $file['file']['name'] = 'default.png';
                    $ret = $this->update($file);
                }
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
            $stmt = $this->conn->prepare($this->image_sql);
            $stmt->execute(['path' => $file['file']['name'], 'uid' => $this->id]);
            $ret = true;
        } catch (PDOException $e) {
            $ret = $e;
        }
        return $ret;
    }

    public function getLstImage($id)
    {
        $ret = "";
        try {
            $stmt = $this->conn->prepare($this->getImage_sql);
            $stmt->execute(['uid' => $id]);
            $this->image = $stmt->fetch(PDO::FETCH_ASSOC);
            if($this->image['image']!='default.png'){
                $this->unlinkImage();
            }
            $ret =true;
        } catch (PDOException $e) {
            $ret = $e;
        }
        return $ret;
    }
    public function unlinkImage(){
        if(!empty($this->image['image'])&& $this->image['image']!=NULL){
            unlink(_UPLOAD.'images/'.$this->image['image']);
        }
    }

}

if ($_FILES) {
    $reqFiles->get_valid_checker();
    $valid  = new validChecker();
    $dbFile = new db();
    $conn   = $dbFile->getConn();
    $imageUpdate = new validToUpdatImage();
    $imageUpdate->setConn($conn);
    $imageUpdate->validToUploadFunc($_FILES, 'image', 'file');
    $err = $imageUpdate->status;
    if (count($err) < 1) {
        $user = $valid->getUserByEmail($conn, $_SESSION['email']);
        $res  = $imageUpdate->imageFunc($_FILES, $user['Id']);
        if ($res) {
            $retData['result'] = true;
            $retData['imgSrc'] = _UPLOAD_URL . '/images/'.$_FILES['file']['name'];
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
