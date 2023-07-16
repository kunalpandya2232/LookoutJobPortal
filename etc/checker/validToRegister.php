<?php


defined("OWNER") or die("You are not allowed to access");

class validToRegister
{
    private $conn                  = '';
    private $data                  = '';
    private $validToRegister_sql   = "";
    private $user                  = "";
    private $fDir                  = _UPLOAD . 'images/';
    private $isImage               = "";
    public  $status;
    private $insertUser_sql        = 'INSERT INTO lo_tblusers (user_fname,user_lname,user_email,user_contactNumber,user_dob,user_country,user_state,user_city,user_address,user_photo,user_password,user_gender,user_type,is_live,is_deleted)VALUES(:u_fname,:u_lname,:u_email,:u_cn,:u_dob,:u_con,:u_st,:u_ct,:u_ad,:u_ph,:u_pass,:u_gen,:u_type,:live,:deleted)';
    private $insertUserProfile_sql = 'INSERT INTO lo_tblprofileuser (user_id,profile_userName,jobS_resume,jobS_occupation,jobS_exp,category_id,org_name)VALUES(:u_id,:u_p_userName,:jobS_resume,:jobS_occupation,:jobS_exp,:category_id,:org_name)';
    private $insertLink_sql        = 'INSERT INTO lo_tbllinks( user_id, facebook, twitter, instagram, linkedIn) VALUES (:uid,NULL,NULL,NULL,NULL)';

    /**
     * @param string $conn
     */
    private function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param string $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param array  $selCol
     * @param string $table
     *
     * @return mixed
     */
    private function check(array $selCol, string $table)
    {
        $col                       = implode(", ", $selCol);
        $this->validToRegister_sql = 'SELECT ' . $col . ' FROM lo_' . $table . ' WHERE user_email = :email ORDER BY id LIMIT 1';
        $stmt                      = $this->conn->prepare($this->validToRegister_sql);
        $stmt->execute(['email' => $this->data]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * @param        $conn
     * @param string $email
     *
     * @return bool
     */
    public function validToRegisterFunc($conn, string $email)
    {
        $ret = false;
        $col = ['verify_status', 'is_verify'];
        $this->setConn($conn);
        $this->setData($email);
        $chR = $this->check($col, 'tblotp');
        $res = $chR == null ? true : $chR;
        if ((!is_array($res) && $res) || ($res['is_verify'] == 1 && $res['verify_status'] == 0)) {
            $this->status = false;
        } else {
            if ($res['is_verify'] == 0) {
                $this->status = "<b>You are Banned.</b>";
            } elseif ($res['is_verify'] == 1 && $res['verify_status'] == 1) {
                $ret          = true;
                $this->status = true;
            } else {
                $this->status = "Something Wrong...";
            }
        }
        return $ret;
    }

    public function userAvailCheck(array $user, array $isImage)
    {
        $this->setUser($user);
        $this->haveImage($isImage);
        $ret = false;
        $col = ['user_fname', 'is_deleted'];
        $chR = $this->check($col, 'tblusers');
        $res = $chR == null ? true : $chR;
        if ($res == true && !is_array($res)) {
            $ret = $this->insertUser();
        } elseif (is_array($res) && $chR['is_deleted'] == 'N') {
            $this->status = "You are already Registered";
        } else {
            //Here check whether User is deleted or not
            if (is_array($res) && $res['is_deleted'] == 'Y') {
                $this->status = "<b>You are Banned.</b>";
            } else {
                $this->status = "Something Wrong...";
            }
        }
        return $ret;
    }

    private function insertUser()
    {
        $ret = false;
        //first upload Image
        if ($this->isImage[0] == 1) {
            $upImage = $this->upLoadImage();

            $this->user['photo'] = $upImage == true ? $this->isImage[1]['name'] : $this->user['photo'];
        }
        try {
            $setUpIn   = [
                'u_fname' => $this->user['fname'], 'u_lname' => $this->user['lname'],
                'u_email' => $this->user['email'], 'u_cn' => $this->user['contact_no'], 'u_dob' => $this->user['dob'],
                'u_con'   => $this->user['country'], 'u_st' => $this->user['state'], 'u_ct' => $this->user['city'],
                'u_ad'    => $this->user['address'], 'u_ph' => $this->user['photo'], 'u_pass' => md5($this->user['password']),
                'u_gen'   => $this->user['gender'], 'u_type' => $this->user['jobType'], 'live' => 'Y', 'deleted' => 'N'];
            $upsetUpIn = [
                'u_id'            => '',
                'u_p_userName'    => $this->generateName(),
                'jobS_resume'     => 'NULL', 'jobS_exp' => 0, 'category_id' => NULL,
                'jobS_occupation' => $this->user['occupation'],
                'org_name'        => 'NULL',
            ];
            $stmt      = $this->conn->prepare($this->insertUser_sql);
            $stmt->execute($setUpIn);
        } catch (PDOException $e) {
            $this->status = "You are alreday registerd";
        }
        $upsetUpIn['u_id'] = $this->conn->lastInsertId();
        if (!empty($upsetUpIn['u_id']) && $upsetUpIn['u_id'] != NULL) {
            //insert in profile user
            try {
                $stmt_ = $this->conn->prepare($this->insertUserProfile_sql);
                $stmt_->execute($upsetUpIn);
                $ret = true;
            } catch (PDOException $e) {
                $ret = "Something.. Wrong. Pu";
            }
            //insert in link
            try {
                $stmt_l = $this->conn->prepare($this->insertLink_sql);
                $stmt_l->execute(['uid'=>$upsetUpIn['u_id']]);
                $ret = true;
            } catch (PDOException $e) {
                $ret = "Something.. Wrong. link";

            }
        }
        return $ret;
    }

    public function adminInsert($conn, array $user)
    {
        $this->setUser($user);
        $this->setConn($conn);
        $ret = false;
        $col = ['user_fname', 'is_deleted'];
        $chR = $this->check($col, 'tblusers');
        $res = $chR == null ? true : $chR;
        if ($res == true && !is_array($res)) {
            $ret = $this->adminInsertFunc();
        } elseif (is_array($res) && $chR['is_deleted'] == 'N') {
            $this->status = "You are already Registered";
        } else {
            //Here check whether User is deleted or not
            if (is_array($res) && $res['is_deleted'] == 'Y') {
                $this->status = "<b>You are Banned.</b>";
            } else {
                $this->status = "Something Wrong...";
            }
        }
        return $ret;
    }

    private function adminInsertFunc()
    {
        $ret = false;
        if (!isset($this->user['orgName'])) {
            $this->user['orgName'] = "";

        }
        try {
            $setUpIn   = [
                'u_fname' => $this->user['fname'], 'u_lname' => $this->user['lname'],
                'u_email' => $this->user['email'], 'u_cn' => $this->user['contact_no'], 'u_dob' => $this->user['dob'],
                'u_con'   => $this->user['country'], 'u_st' => $this->user['state'], 'u_ct' => $this->user['city'],
                'u_ad'    => $this->user['address'], 'u_ph' => 'default.png', 'u_pass' => md5($this->user['password']),
                'u_gen'   => $this->user['gender'], 'u_type' => $this->user['jobType'], 'live' => '', 'deleted' => 'N'];
            $upsetUpIn = [
                'u_id'            => '',
                'u_p_userName'    => $this->generateName(),
                'jobS_resume'     => 'NULL', 'jobS_exp' => $this->user['user_exp'], 'category_id' => NULL,
                'jobS_occupation' => $this->user['user_occ'],
                'org_name'        => $this->user['orgName'],
            ];
            $stmt      = $this->conn->prepare($this->insertUser_sql);
            $stmt->execute($setUpIn);
            $this->status = true;
        } catch (PDOException $e) {
            $this->status = "You are alreday registerd" . $e->getMessage();
        }

        if ($this->status == true) {
            try {
                $upsetUpIn['u_id'] = $this->conn->lastInsertId();
                $stmt_             = $this->conn->prepare($this->insertUserProfile_sql);
                $stmt_->execute($upsetUpIn);
                $ret          = true;
                $this->status = true;
            } catch (PDOException $e) {
                $this->status = "Something.. Wrong in Pu " . $e->getMessage();
            }
            if ($this->status == true) {
                try {
                    $otp_ins = "INSERT INTO lo_tblotp (user_email ,type ,verify_code ,verify_status, is_verify) VALUES(:email,:type, :code,:status,:verify)";
                    $stmtotp = $this->conn->prepare($otp_ins);
                    $stmtotp->execute(['email' => $this->user['email'], 'type' => 'REG', 'code' => 'admin1', 'status' => '1', 'verify' => '1']);
                    $ret = true;
                } catch (PDOException $e) {
                    $this->status = 'DataBase Error: Register ';

                }
            }
            if ($this->status == true) {
                try {
                    $stmt_l = $this->conn->prepare($this->insertLink_sql);
                    $stmt_l->execute(['uid' => $upsetUpIn['u_id']]);
                    $ret = true;
                } catch (PDOException $e) {
                    $this->status = "Something.. Wrong. in link";
                }
            }
        }
        return $ret;
    }

    public function generateName()
    {
        $ret   = '';
        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        for ($i = 1; $i <= 10; $i++) {
            $choice = rand(1, 2);
            switch ($choice) {
                case 1:
                    $ret .= strtolower($alpha[array_rand($alpha)]);
                    break;

                case 2:
                    $ret .=
                        ($alpha[array_rand($alpha)]);
                    break;
            }
        }
        return $ret;
    }

    /**
     * @param array $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param string $user
     */
    public function haveImage($image)
    {
        $this->isImage = $image;
    }

    private function upLoadImage()
    {
        $ret = false;
        if (!empty($this->user['photo']) && count($this->isImage) == 2) {
            $file    = $this->fDir . basename($this->isImage[1]['name']);
            $fileTmp = $this->isImage[1]['tmp_name'];
            if (is_dir($this->fDir)) {
                $ret = move_uploaded_file($fileTmp, $file);
            }
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

}

$validToRegister = new validToRegister();
