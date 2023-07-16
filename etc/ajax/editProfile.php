<?php

require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class editProfile
{
    private $update_sql      = "UPDATE lo_tblusers SET ";
    private $update_prof_sql = "UPDATE lo_tblprofileuser SET ";
    private $conn            = "";
    private $data            = "";
    public  $status          = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function setUpdateFields($data)
    {
        $this->data = $data;
        $this->modifyDataForUpdate();
        if (!empty($this->data['uid'])) {
            $ret = $this->update();
            if ($ret) {
                return $ret;
            } else {
                return false;
            }
        }
    }

    private function update()
    {
        $ret = '';
        if ($this->update_sql !== '' && $this->update_prof_sql !== '') {

            try {
                $stmt = $this->conn->prepare($this->update_sql);
                $stmt->execute(['uid' => $this->data['uid']]);
                $ret          = true;
                $this->status = true;
            } catch (PDOException $e) {
                $ret          = false;
                $this->status = false;
            }
            try {
                $stmt = $this->conn->prepare($this->update_prof_sql);
                $stmt->execute(['uid' => $this->data['uid']]);
                $ret          = true;
                $this->status = true;
            } catch (PDOException $e) {
                $ret          = false;
                $this->status = false;
            }
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function getUpdateSql(): string
    {
        return $this->update_sql;
    }

    /**
     * @return string
     */
    public function getUpdateProfSql(): string
    {
        return $this->update_prof_sql;
    }

    private function modifyDataForUpdate()
    {
        $update  = "";
        $pupdate = "";
        if (isset($this->data['fname']) && !empty($this->data['fname'])) {
            $update .= " user_fname='" . $this->data['fname'] . "', ";
        }
        if (isset($this->data['lname']) && !empty($this->data['lname'])) {
            $update .= " user_lname='" . $this->data['lname'] . "', ";

        }
        if (isset($this->data['contact_no']) && !empty($this->data['contact_no'])) {
            $update .= "user_contactNumber=" . $this->data['contact_no'] . ", ";

        }
        if (isset($this->data['dob']) && !empty($this->data['dob'])) {
            $update .= "user_dob='" . date('Y-m-d', strtotime($this->data['dob'])) . "', ";

        }
        if (isset($this->data['country-id']) && !empty($this->data['country-id'])) {
            $update .= "user_country='" . $this->data['country-id'] . "', ";

        }
        if (isset($this->data['state']) && !empty($this->data['state'])) {
            $update .= "user_state='" . $this->data['state'] . "', ";

        }
        if (isset($this->data['city']) && !empty($this->data['city'])) {
            $update .= "user_city='" . $this->data['city'] . "', ";

        }
        if (isset($this->data['address']) && !empty($this->data['address'])) {
            $update .= "user_address='" . $this->data['address'] . "', ";

        }
        if (isset($this->data['new_pass']) && !empty($this->data['new_pass'])) {
            $update .= "user_password=" . md5($this->data['new_pass']) . ", ";

        }
        if (isset($this->data['gender']) && !empty($this->data['gender'])) {
            $update .= "user_gender='" . $this->data['gender'] . "'";
        }
        if (isset($this->data['user_exp']) && !empty($this->data['user_exp'])) {
            $pupdate .= "jobS_exp='" . $this->data['user_exp'] . "', ";

        }
        if (isset($this->data['orgName']) && !empty($this->data['orgName'])) {
            $pupdate .= "org_name='" . $this->data['orgName'] . "', ";
        }
        if (isset($this->data['user_occ'])) {
            $pupdate .= "jobS_occupation='" . $this->data['user_occ'] . "'";
        }
        if ($update != '') {
            $this->update_sql = $this->update_sql . $update . ' WHERE id=:uid';
        } else {
            $this->update_sql = '';
        }
        if ($pupdate != '') {
            $this->update_prof_sql = $this->update_prof_sql . $pupdate . ' WHERE user_id=:uid';
        } else {
            $this->update_prof_sql = '';
        }
    }

}

if ($_POST && !empty($_POST['uid'])) {
    $retData  = [];
    $err      = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid    = new validChecker();
    $dbClass  = new db();
    $noRemove = ['country-id' => $_POST['country-id'], 'state' => $_POST['state']];
    $data     = $valid->cleanData($_POST, $noRemove);
    $data     = $valid->registerRequireFields($data);
    if (!$valid->phone($_POST['contact_no'])) {
        $err[] = "Contact number is not valid";
    }
    if (!$valid->gender($_POST['gender'])) {
        $err[] = "Gender is not valid";
    }
    if (count($err) < 1) {
        $conn   = $dbClass->getConn();
        $update = new editProfile();
        $update->setConn($conn);
        $ret = $update->setUpdateFields($data);
        if ($ret && $update->status) {
            $retData['result'] = 'success';
            $retData['err']    = '';

        } elseif ($ret == '') {
            $retData['result'] = 'success';
            $retData['err']    = '';

        } else {
            $retData['result'] = 'fail';
            $retData['err']    = 'Somthing wrong to update';
        }
    } else {
        $retData['result'] = 'fail';
        $retData['error']  = $err;
    }
    echo json_encode($retData);
}
