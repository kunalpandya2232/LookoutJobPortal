<?php


session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class verifyCode
{

    private $conn                = '';
    private $checkValidEmail_sql = 'SELECT verify_status, is_verify FROM lo_tblotp WHERE user_email=:email';
    private $updateOtp_sql       = 'UPDATE lo_tblotp SET verify_status = "1" WHERE user_email = :email LIMIT 1';
    public  $status;

    /**
     * @param string $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Verification
     *
     * @param $email
     * @param $code
     *
     * @return bool|string
     */
    public function verifyEmail($email, $code)
    {
        $res = false;
        if (!isset($this->status) && $this->status != 'error') {
            try {
                $stmt = $this->conn->prepare($this->checkValidEmail_sql . ' ORDER BY id LIMIT 1');
                $stmt->execute(['email' => $email]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($res == false) {
                    $this->status = 'error';
                    $res          = "Email not found";
                } elseif ($res['is_verify'] === '0') {
                    $this->status = 'error';
                    $res          = "Bann";
                } elseif ($res['is_verify'] === '1' && $res['verify_status'] === '1') {
                    $this->status = 'succesaas';
                    $res          = "verified";
                } elseif ($res['is_verify'] === '1' && $res['verify_status'] === '0') {
                    $this->checkValidEmail_sql .= ' AND verify_code = :v_c';
                    $stmt                      = $this->conn->prepare($this->checkValidEmail_sql . ' ORDER BY id LIMIT 1');
                    $stmt->execute(['email' => $email, 'v_c' => $code]);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($res == false) {
                        $this->status = 'error';
                        $res          = "Code is Invalid";
                    } else {
                        $res = $this->updateOtp($email);
                    }
                } else {
                    $this->status = 'error';
                    $res          = "Something Wrong...";
                }
            } catch (PDOException $e) {
                $res          = '<strong>' . $e->getCode() . '</strong> ' . $e->getMessage();
                $this->status = 'error';

            }
        }
        return $res;
    }

    /**
     * Update Otp Users to verified
     *
     * @param $email
     *
     * @return bool|string
     */
    private function updateOtp($email)
    {
        $res  = false;
        $stmt = $this->conn->prepare($this->updateOtp_sql);
        if ($stmt->execute(['email' => $email])) {
            $res          = "verified";
            $this->status = "success";
        }
        return $res;
    }

}

if ($_POST && !empty($_POST['email']) && !empty($_POST['code'])) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid   = new validChecker();
    $dbClass = new db();
    //email clean and check again
    $data = $valid->cleanData($_POST);

    if ($valid->email($data['email'])) {
        if (strlen($data['code']) === 6) {
            $verifyCodeClass = new verifyCode();
            $verifyCodeClass->setConn($dbClass->getConn());
            $ret    = $verifyCodeClass->verifyEmail($data['email'], $data['code']);
            $result = $verifyCodeClass->status;
        } else {
            $result = "error";
            $ret    = "Verification code is of 16 mix characters";
        }
    } else {
        $result = "error";
        $ret    = "Email is not valid";
    }

    $retData = ['result' => $result, 'error' => ''];
    if ($ret !== true && $ret != "verified") {
        $retData['error'] = $ret;
    }
    if ($ret === "verified") {
        $retData['result'] = "Verified";
    }

    echo json_encode($retData);

}
