<?php

class validChecker
{
    public $passLen  = 8;
    public $phoneLen = 10;

    /* clean data
    *	trim , clean tags
    *	remove whitespaces
    */
    public function cleanData($data, $removeData = array())
    {
        $data_valid = false;
        if (is_array($data)) {
            foreach ($data as $name => $datas) {
                $datas = trim($datas);
                if (!in_array($name, array_keys($removeData))) {
                    $datas = str_replace(" ", "", $datas);
                }
                $datas             = strip_tags($datas);
                $datas             = htmlspecialchars($datas);
                $data_valid[$name] = $datas;
            }
        } else {
            $data_valid = trim($data);
            $data_valid = strip_tags($data_valid);
            $data_valid = str_replace(" ", "", $data_valid);
            $data_valid = htmlspecialchars($data_valid);

        }

        return $data_valid;
    }

    public function email($email = '')
    {
        $checker = false;
        if (!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checker = true;
            }
        }
        return $checker;
    }

    public function phone($number = '')
    {
        $checker = false;
        if (!empty($number)) {
            $number  = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
            $checker = strlen($number) == $this->phoneLen ? true : false;
        }
        return $checker; 
    }

    public function pass_confirm($pass = '', $cpass = '')
    {
        $checker = false;
        if (isset($pass) && isset($cpass)) {
            $pass  = filter_var($pass, FILTER_SANITIZE_STRING);
            $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
            if (($pass != '' && $cpass != '') && (!empty($pass) && !empty($cpass))) {
                if ((strlen($pass) > 7 && strlen($pass) < 12) && (strlen($cpass) > 7 && strlen($cpass) < 12)) {
                    if(strcmp($pass, $cpass) != 0) {
                        $checker = 'Password is mismatch';
                    } else {
                        $checker = true;
                    }
                } else {
                    $checker = 'Length is not correct';

                }
            } else {
                $checker = 'Password or Cnfirm-password is empty';
            }
        }
        return $checker;
    }

    public function gender($user)
    {
        $gender = ['F', 'M', 'N'];
        return in_array(strtoupper($user), $gender) ? true : false;
    }

    public function registerRequireFields($userFields)
    {
        //this list is same as insert query needed
        $requireFields = ['fname', 'lname', 'email', 'contact_no', 'dob', 'gender', 'occupation', 'category', 'country', 'state', 'city', 'address', 'photo', 'password', 'jobType', 'delete'];
        $subArray      = array();
        foreach ($requireFields as $fname) {
            if (!in_array($fname, array_keys($userFields))) {
                $subArray[$fname] = null;
                if ($fname == 'photo') {
                    $subArray[$fname] = 'default.jpeg';
                    continue;
                }
                if ($fname == 'delete' || $fname == 'category') {
                    $subArray[$fname] = 0;
                    continue;
                }
            }
        }

        return array_merge($userFields, $subArray);
    }

    public function getUserByEmail($conn = "", $email = "")
    {
        $res = false;
        if ($this->email($email)) {

            try {
                $stmt = $conn->prepare("SELECT user.id as 'Id', pu.profile_userName as 'profileUsername', user.user_fname as 'fname', user.user_lname as 'lname', user.user_email as 'email', user.user_photo as 'u_image', user.user_type as 'type', user.is_deleted as 'delete' FROM lo_tblusers  as user INNER JOIN lo_tblprofileuser as pu ON user.id = pu.user_id WHERE user.user_email = ? AND user.is_live = 'Y' LIMIT 1");
                $stmt->execute([$email]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $res = $e->getMessage();
            }
        }

        return $res;
    }

    public function getUserByEmailAll($conn = "", $email = "")
    {
        $res = false;
        if ($this->email($email)) {

            try {
                $stmt = $conn->prepare("SELECT user.id as 'Id', user.user_fname as 'fname', user.user_lname as 'lname', user.user_email as 'email', user.user_photo as 'u_image', user.user_type as 'type', user.is_deleted as 'delete', user.user_gender as 'gender', user.user_dob as 'dob', pu.profile_userName as 'profileUsername', pu.jobS_occupation as 'occupation', otp.is_verify as 'permit', otp.verify_status as 'verify', user.*, pu.*,otp.* FROM lo_tblusers  as user INNER JOIN lo_tblprofileuser as pu ON user.id = pu.user_id LEFT JOIN lo_tblotp as otp ON otp.user_email= user.user_email WHERE user.user_email = ? AND user.is_live = 'Y' AND otp.is_verify = '1' AND otp.verify_status = '1' LIMIT 1 ");
                $stmt->execute([$email]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $res = $e->getMessage();
            }
        }

        return $res;
    }

    public function getPostJobFileds($postFields, $cat = '')
    {
        $requireFields = ['jobtitle' => 'Job Title', 'jobdescription' => 'Job Description', 'jobamt' => 'Salary', 'jobhours' => 'Job Type', 'minexp' => 'Minimum Experience', 'jobvcc' => 'Job Vaccancy',];
        if (!is_array($postFields)) {
            return $requireFields;
        } else {
            $requireFields = array_merge($requireFields, ['jobLocation'=>$postFields['jobLocation'],'jobresponsiblity'=>$postFields['jobresponsiblity'],'skillRequire'=>$postFields['skillRequire'],'report' => '', 'cat' => '', 'creat' => '', 'lastedit' => '']);
            $subArray      = array();
            foreach (array_keys($requireFields) as $field) {
                if (!in_array($field, array_keys($postFields))) {
                    $subArray[$field] = null;
                    if ($field == 'report') {
                        $subArray[$field] = "N";
                        continue;
                    }
                    if ($field == 'cat') {
                        $subArray[$field] = $cat;
                        continue;
                    }
                    if ($field == 'creat' || $field == 'lastedit') {
                        $subArray[$field] = $_SESSION['type'];
                        continue;
                    }
                }
            }
        }

        return array_merge($postFields, $subArray);
    }

    public function comment($data)
    {
        $checker = false;
        if(strlen($data)<=200 && !empty($data)){
            $checker = true;
        }
        return $checker;
    }

    public function fileterUrl($data)
    {
        if(is_array($data)){
            foreach($data as $val){
                if(!empty($val)&&$val!=NULL){

                $filt[] = filter_var($val, FILTER_VALIDATE_URL);
                }else{
                    $filt[] = "";
                }
            }
        }
        return $filt;
    }

}
