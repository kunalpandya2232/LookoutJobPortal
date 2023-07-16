<?php
session_start();

require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles                = new settings();
$reqFiles->get_required_files();
if (!isset($_SESSION['user'])):
    $pageName = "Login Page " . SITE_NAME;
    $_SESSION['curPage'] = 'login';
    $_SESSION['access']  = isset($_SESSION['access']) ? $_SESSION['access'] : 'USER';
    $reqFiles->get_header($pageName);
    if ($_POST && ($_POST['email'] && $_POST['password'])) {

        $reqFiles->get_valid_checker();
        $checker = new validChecker();
        $data    = $checker->cleanData($_POST);
        $err     = [];
        if (!$checker->email($data['email'])) {
            $err['valid'][] = 'Email is not Valid';
        }

        if (!empty($data['password'])) {
            if (strlen($data['password']) < 7 || strlen($data['password']) > 12) {
                $err['valid'][] = 'Length of Password is not correct.';
            }
        }

        //unset unnecessory $_POST
        unset($_POST);
        //set to session
        foreach ($data as $name => $value) {
            $_SESSION[$name] = $value;
        }

        if (count($err) < 1) {
            $dbconn = new db();
            if (!class_exists('validToLogin')) {
                $conn = $dbconn->getConn();
                require _DIR . '/etc/checker/validToLogin.php';
                $vtR = $validToLogin->validToLoginFunc($conn, $data['email']);
            }
            if (isset($validToLogin) && isset($vtR)) {
                if ($vtR == true && $validToLogin->status == true) {
                    //CHECK User
                    $userAvail = $validToLogin->userAvailCheck($data);
                    if ($userAvail !== true) {
                        $err[][] = $validToLogin->status;
                    } else {
                        //Successfully login now goto page
                        if(is_array($validToLogin->status) && ($validToLogin->status['user_type']=='O'||$validToLogin->status['user_type']=='J')){
                            $_SESSION['user'] = "old";
                            $url =_HOME . "/dashboard/index.php";
                        }elseif(is_array($validToLogin->status) && $validToLogin->status['user_type']=='A'){
                            $_SESSION['admin_login'] = true;
                            $url = _ADMIN_HOME."/dashboard.php";
                        }
                        header("location: " . $url);
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

            <div class="login-screen">
                <?php
                if (isset($err) && count($err) > 0) {
                    $html = '<div class="ml-2 mr-2">';
                    foreach ($err as $errors => $val) {
                        $valid = $errors == 'valid' ? true : false;
                        foreach ($val as $name => $value) {
                            if ($valid) {
                                $html .= '<div class="alert alert-danger">' . $value . ' <button class="btn btn-sm btn-outline-danger float-right close_err">X</button> </div>';
                            } else {
                                $html .= '<div class="alert alert-warning">' . $value . ' <button class="btn btn-sm btn-outline-warning float-right close_err">X</button> </div>';
                            }
                        }
                    }
                    $html .= '</div>';
                    echo $html;
                }
                ?>
                <a href="<?php echo _HOME . '/index.php'; ?>"><img src="assets/img/logo.png" class="img-responsive"
                                                                   alt=""></a>

                <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="loginForm" class=""
                      id="login_form">
                    <input name="email" placeholder="Email" type="email" class="form-control" id="email"
                           value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                    <label class="email_error"></label>
                    <input name="password" placeholder="Password" type="password" class="form-control" id="pass"
                           required>
                    <button class="btn btn-login" type="submit">Login</button>
                    <span>You Have No Account? <a
                                href="<?php echo _HOME . '/register.php'; ?>"> Create An Account</a></span>
                    <span><a href="<?php echo _HOME . '/forgotPassword.php'; ?>"> Forget Password</a></span>
                </form>
            </div>
        </div>

        <p class="hiddenUrl base"><?php echo _HOME; ?></p>
        <p class="hiddenUrl verify">
    </section>


    <?php
    $reqFiles->get_footer(false);
else:
    header("location: " . _HOME . "/dashboard/index.php");
endif;
