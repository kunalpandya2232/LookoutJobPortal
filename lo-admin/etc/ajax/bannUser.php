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

class bannUser
{
    private $bann_sql_u   = "UPDATE lo_tblusers SET is_deleted =:bann WHERE id=:uid";
    private $bann_sql_otp = "UPDATE lo_tblotp SET is_verify=:verify WHERE user_email=:email";
    private $u_email      = "SELECT user_email FROM lo_tblusers WHERE id = :uid";
    private $conn         = "";
    public  $status       = '';

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function bann($data)
    {

        $ret = false;
        if ($data['mode'] == "Y") {
            $verify = "0";
        } else {
            $verify = "1";
        }
        $data['id'] = base64_decode($data['id']);
        try {
            $stmt = $this->conn->prepare($this->u_email);
            $stmt->execute(['uid' => $data['id']]);
            $email        = $stmt->fetch(PDO::FETCH_ASSOC);
            $ret          = true;
            $this->status = true;
        } catch (PDOException $e) {

            $ret          = false;
            $this->status = "errorinID".$e->getMessage();
        }

        try {
            $stmt = $this->conn->prepare($this->bann_sql_u);
            $stmt->execute(['bann' => $data['mode'], 'uid' => $data['id']]);
            $ret          = true;
            $this->status = true;
        } catch (PDOException $e) {
            $ret          = false;
            $this->status = "errorinUpdateUser";
        }

        if ($email['user_email']) {


            try {
                $stmt = $this->conn->prepare($this->bann_sql_otp);
                $stmt->execute(['verify' => $verify, 'email' => $email['user_email']]);
                $ret          = true;
                $this->status = true;
            } catch (PDOException $e) {
                $ret          = false;
                $this->status = "errorinID".$e->getMessage();
            }
        } else {
            $ret          = false;
            $this->status = "EmailNotFound";
        }
        return $ret;
    }
}

if ($_POST) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $dbClass      = new db();
    $validchecker = new validChecker();
    $data         = $validchecker->cleanData($_POST);
    // clean and check again
    $bann = new bannUser();
    $bann->setConn($dbClass->getConn());
    $res = $bann->bann($data);
    if ($res == true && $bann->status == true) {
        $retData['success'] = true;
    } else {
        $retData['success'] = false;
        $retData['error']   = $bann->status;

    }
    echo json_encode($retData);
}
