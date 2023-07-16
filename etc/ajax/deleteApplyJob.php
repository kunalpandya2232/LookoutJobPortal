<?php


session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class deleteApplyJob {
    private $sql = "UPDATE lo_tblapplier SET is_delete='Y' WHERE lo_tblapplier.id =:jobid  ";
    private $conn = "";
    public $status ="";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }


    public function deleteFunc($id){
        $ret = false;
        try{

            $stmt = $this->conn->prepare($this->sql);
            $stmt->execute(['jobid'=>intval($id['recordId'])]);
            $this->status = true;
            $ret= true;
        }catch(PDOException $e){
            $this->status = false;
        }
        return $ret;
    }

}

if($_POST){
    $retData  = [];
    $err      = '';
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid   = new validChecker();
    $dbClass = new db();
    $data = $valid->cleanData($_POST);
    $deleteclass = new deleteApplyJob();
    $deleteclass->setConn($dbClass->getConn());
    $ret = $deleteclass->deleteFunc($data);
    if ($ret != true) {
        $err = $ret;
        $ret = 'false';
    }
    $retData = ['result' => $deleteclass->status, 'error' => $err];
    echo json_encode($retData);

}
