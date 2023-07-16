<?php

class validToForgotPass extends mail
{


    private $conn                = '';
    private $data                = '';
    private $validToForgotPass_sql = "";
    private $user                = "";
    public  $status;
    private $updateUser_sql      = 'UPDATE lo_tblusers SET is_live = :live WHERE user_email =:email LIMIT 1';

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
    public function check(){
        $ret ='';
        $this->validToForgotPass_sql = 'SELECT is_deleted, user_password, is_live  FROM lo_tblusers WHERE user_email = :email ORDER BY id LIMIT 1';
        $stmt                      = $this->conn->prepare($this->validToForgotPass_sql);
        $stmt->execute(['email' => $this->data]);
        $ret = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ret;
    }
    /**
     * @param        $conn
     * @param string $email
     *
     * @return bool
     */
    public function validToForgotPass($conn, string $email)
    {
        $ret = false;
        $this->setConn($conn);
        $this->setData($email);
        return $ret;
    }
    /**
     * @param array $user
     *
     * @return bool
     */
    public function userAvailCheck()
    {
        $ret ='';
        $chR = $this->check();
        $res = count($chR) == 1 ? true : $chR;
        if ($res == true && is_array($res)) {

        } elseif (count($chR) == 0 || $chR == null) {
            $this->status = "Email not Found. Please Register";
        } else {
            //Here check whether User is deleted or not
            if (is_array($res) && $res['is_deleted'] == 1) {
                $this->status = "<b>You are Banned.</b>";
            } else {
                $this->status = "Something Wrong...";
            }
        }
        return $ret;
    }
    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    private function upDateUser($email)
    {
        $ret = false;
        try {
            $stmt = $this->conn->prepare($this->updateUser_sql);
            $stmt->execute(['live' => 'Y', 'email' => $email]);
            $ret = true;
        } catch (PDOException $e) {
//            $ret = 'DataBase Error: ' . $e->getCode() . $e->getMessage();
            $ret = false;
        }
        return $ret;
    }

}
