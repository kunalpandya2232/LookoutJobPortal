<?php

session_start();
require 'config/settingsFiles.php';
require 'config/mailFile.php';
require_once 'etc/mail/src/PHPMailer.php';
require_once 'etc/mail/src/SMTP.php';
require_once 'etc/mail/src/Exception.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
use config\mailFile\mailFile as mail;
$reqFiles                = new settings();
$reqFiles->get_required_files();
    $pageName = "Forgot Password " . SITE_NAME;
    $_SESSION['curPage'] = 'forgot-pass';
    $_SESSION['access']  = isset($_SESSION['access']) ? $_SESSION['access'] : 'USER';
    $reqFiles->get_header($pageName);
    if ($_POST && ($_POST['email'])) {

    $reqFiles->get_valid_checker();
    $checker = new validChecker();
    $data    = $checker->cleanData($_POST);
    $err     = [];
    if (!$checker->email($data['email'])) {
        $err['valid'][] = 'Email is not Valid';
    }
    //unset unnecessory $_POST
    unset($_POST);
    //set to session
    foreach ($data as $name => $value) {
        $_SESSION[$name] = $value;
    }

    if (count($err) < 1) {
        $dbconn = new db();
        if (!class_exists('validToForgotPass')) {
            $conn = $dbconn->getConn();
            require _DIR . '/etc/checker/validToForgotPass.php';
            $vtR = $validToLogin->validToForgotPass($conn, $data['email']);
        }
        if (isset($validToLogin) && isset($vtR)) {
            if ($vtR == true && $validToLogin->status == true) {
                //Insert Record if new User
                $userAvail = $validToLogin->userAvailCheck($data);
                if ($userAvail !== true) {
                    $err[][] = $validToLogin->status;
                } else {
                    //Successfully registered now goto page
                    $_SESSION['user'] = "old";
                    header("location: " . _HOME . "/dashboard/index.php");
                }
            } elseif (!$vtR && $validToLogin->status == false) {
                $err['valid'][] = 'Your Email ( <b>' . $data['email'] . '</b> ) is not verified by us. <a class="link-dark text-decoration-underline" data-bs-toggle="modal" href="#popupVerify" role="button">Click Here</a> to verify.';
            } else {
                $err['valid'][] = $validToLogin->status;
            }
        }
    }
}

?>
<div class="wrapper">

    <section class="login-screen-sec">
        <div class="container">
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="forgotPassForm" class=""
      id="forgot_pass_form">
    <div>
        <input name="email" placeholder="Email" type="email" class="form-control" id="email"
               value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        <label class="email_error"></label>
        <button class="btn btn-login" type="submit">Login</button>

    </div>
    <p class="hiddenUrl base"><?php echo _HOME; ?></p>
    <p class="hiddenUrl verify">
</form>
        </div>
    </section>
</div>
<?php
$reqFiles->get_footer(false);

