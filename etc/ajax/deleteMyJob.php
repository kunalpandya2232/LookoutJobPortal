<?php


session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
class deleteMyJob{
    private $sqlJob = "UPDATE lo_tbljobs SET is_deleted ='Y' WHERE id =:jobid";
    private $sqlAppl = "UPDATE lo_tblapplier SET is_delete ='Y' WHERE job =:jobid AND lastly_editedBy=:type";
    private $conn = "";
    public $status ="";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function deleteFunc($id){
        $ret = false;
        try{
            $stmt = $this->conn->prepare($this->sqlJob);
            $stmt->execute(['jobid'=>$id['recordId']]);
            $stmt = $this->conn->prepare($this->sqlAppl);
            $stmt->execute(['jobid'=>$id['recordId'],'type'=>$id['type']]);
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
    $deleteclass = new deleteMyJob();
    $deleteclass->setConn($dbClass->getConn());
    $ret = $deleteclass->deleteFunc($data);
    if ($ret != true) {
        $err = $ret;
        $ret = 'false';
    }
    $retData = ['result' => $deleteclass->status, 'error' => $err];
    echo json_encode($retData);

}
