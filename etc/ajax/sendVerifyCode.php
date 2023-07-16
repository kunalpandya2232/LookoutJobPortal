<?php



session_start();
require '../../config/settingsFiles.php';
require '../../config/mailFile.php';
require_once '../mail/src/PHPMailer.php';
require_once '../mail/src/SMTP.php';
require_once '../mail/src/Exception.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
use config\mailFile\mailFile as mail;


    class sendVerifyCode extends mail
    {
        private $userEmail            = '';
        private $conn                 = '';
        private $code                 = '';
        private $codeLen              = 6;
        private $insertVerifyCode_sql = '';
        public  $status;

        /**
         * @param string $code
         */
        public function setCode(string $code): void
        {
            $this->code = $code;
        }

        /**
         * @return string
         */
        public function getCode(): string
        {
            return $this->code;
        }

        /**
         * @param string $userEmail
         */
        public function setUserEmail(string $userEmail): void
        {
            $this->userEmail = $userEmail;
        }

        /**
         * @param string $conn
         */
        public function setConn($conn): void
        {
            $this->conn = $conn;
        }

        /**
         * @return string
         */
        public function getConn()
        {
            return $this->conn;
        }

        /**
         * get randomizecode
         * @param bool $val
         */
        public function getRandomizeValue($val = false)
        {
            if ($val) {
                $ret = $this->randomizeValueFunc(true, $this->codeLen);
                $this->setCode($ret);
            }
        }

        /**
         * Sent mail
         *
         * @return bool|string
         * @throws \PHPMailer\PHPMailer\Exception
         */
        public function mail()
        {
            $ret = false;
            if (method_exists($this, 'sendMail')) {
//                insert otp in databse
                $retDb = $this->dbInsertVerifyCode();
                if ($this->status) {
                    $subject     = 'LOOKOT EMAIL VERIFICATION CODE';
                    $bodyContent = '<h1>VERIFICATION CODE:</h1>';
                    $bodyContent .= '<p>Your code for email verification is <b>' . $this->getCode() . '</b>.<br> Regards LOOKOUT Team </p>';
                    $ret         = $this->sendMail($this->userEmail, $subject, $bodyContent);
                    if ($ret == true) {
                        $this->status = 'success';
                        $ret          = true;
                    } else {
                        $this->status = 'error';
                    }
                } else {
                    $this->status = 'error';
                    $ret          = 'Something Wrong ... Try again Later <br>'.$retDb;
                }
            } else {
                $this->status = 'error';
                $ret          = 'Something is wrong with email';
            }

            return $ret;
        }

        /**
         * insert otp in databse
         * @return bool|string
         */
        private function dbInsertVerifyCode()
        {
            try {
                $this->insertVerifyCode_sql = 'INSERT INTO lo_tblotp (user_email, type, verify_code, verify_status, is_verify) VALUES(:u_email, :type, :v_code , :v_status, :is_v ) ON DUPLICATE KEY UPDATE verify_code = :u_code';
                $stmt                       = $this->conn->prepare($this->insertVerifyCode_sql);
                $stmt->execute(['u_email' => $this->userEmail, 'type' => 'REG', 'v_code' => $this->getCode(), 'v_status' => 0, 'is_v' => 1, 'u_code' => $this->getCode()]);
                $ret = $this->status = true;
            } catch (PDOException $e) {
                $this->status = false;
                $ret          = "ERROR : " . $e->getMessage();
            }
            return $ret;
        }
    }

if ($_POST && !empty($_POST['email'])) {
    $retData  = [];
    $err      = '';
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid   = new validChecker();
    $dbClass = new db();
    //email clean and check again
    $data = $valid->cleanData($_POST['email']);
    if ($valid->email($data)) {
        $emailClass = new sendVerifyCode();
        $emailClass->setUserEmail($data);
        //now all are setted for sending mail and storing otp generated code to db
        $emailClass->setConn($dbClass->getConn());
        $emailClass->getRandomizeValue(true);
        $ret = $emailClass->mail();
        if ($ret != true) {
            $err = $ret;
            $ret = 'false';
        }
    }
    $retData = ['result' => $emailClass->status, 'error' => $err, 'email' => $data, 'mail' => $ret];
    echo json_encode($retData);

}
