<?php

session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles = new settings();
$reqFiles->get_required_files();
$pageName = "Logout Page " . SITE_NAME;

$reqFiles->get_valid_checker();
$checker = new validChecker();

class logout
{
    private $conn           = "";
    private $email          = "";
    private $updateUser_sql = "";

    /**
     * @param string $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function logoutFunc($email = '')
    {
        $this->email = $email;
        $this->updateUserSql();
    }

    private function updateUserSql()
    {
        $this->updateUser_sql = 'UPDATE lo_tblusers SET is_live = "N" WHERE user_email = :email  LIMIT 1';
        try {
            $stmt = $this->conn->prepare($this->updateUser_sql);
            $stmt->execute(['email' => $this->email]);
        } catch (PDOException $e) {

        }
    }
}


if (isset($_SESSION['email'])) {
    $class  = new logout();
    $dbConn = new db();
    $class->setConn($dbConn->getConn());
    $class->logoutFunc($_SESSION['email']);
}

session_destroy();
session_unset();

header("location:" . _HOME . "/index.php");




