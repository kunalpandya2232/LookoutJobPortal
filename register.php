<?php
session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles                = new settings();
$reqFiles->get_required_files();
if (!isset($_SESSION['user'])):

    $pageName = "Register Page " . SITE_NAME;
    $_SESSION['access'] = isset($_SESSION['access'])? $_SESSION['access'] : 'USER';
    $_SESSION['curPage'] = 'register';
    $reqFiles->get_header($pageName);

    if ($_POST && $_POST['submit_register']) {
        $reqFiles->get_valid_checker();
        $checker = new validChecker();
        $data    = $checker->cleanData($_POST);
        $err     = [];
        if ($data['jobType'] != 'O' && $data['jobType'] != 'J') {
            $err['type'][] = 'Type is not Valid';
        }
        if (!$checker->email($data['email'])) {
            $err['email'][] = 'Email is not Valid';
        }
        if (!$checker->phone($data['contact_no'])) {
            $err['phone'][] = 'Contact number is not Valid';
        }
        $pass_check = $checker->pass_confirm($data['password'], $data['cpassword']);
        if (!$pass_check && is_string($pass_check)) {
            $err['pass'][] = $pass_check;
        }

        if (!$checker->gender($data['gender'])) {
            $err['gender'][] = "Gender is not set";
        }
        $data = $checker->registerRequireFields($data);
        //unset unnecessory $_POST
        unset($_POST, $data['submit_register'], $data['agreTnC'], $data['cpassword']);
        //set to session
        foreach ($data as $name => $value) {
            $_SESSION[$name] = $value;
        }

        /**START FILES UPLOAD**/
        $isImage = [0];
        if ($_FILES && !empty($_FILES['image']['name'])) {
            if (!class_exists('uploadImageFunc')) {
                require _DIR . '/etc/checker/validToUpload.php';
                $uploadImage = new uploadImageFunc();
                $upR         = $uploadImage->validToUploadFunc($_FILES, 'image', 'image');
                if ($upR != "error") {
                    $isImage = ['1', $_FILES['image']];
                } else if ($upR == "error") {
                    if (count($uploadImage->status) > 0) {
                        foreach ($uploadImage->status as $status => $val) {
                            $err['valid'][] = $val;
                        }
                    }
                }
            }
        }

        /**END FILES UPLOAD **/
        if (count($err) < 1) {
            $dbconn = new db();
            if (!class_exists('validToRegister')) {
                $conn = $dbconn->getConn();
                require _DIR . '/etc/checker/validToRegister.php';
                $vtR = $validToRegister->validToRegisterFunc($conn, $data['email']);
            }
            if (isset($validToRegister) && isset($vtR)) {
                if ($vtR == true && $validToRegister->status == true) {
                    $data['dob']=date("y-m-d",strtotime($data['dob']));
                    //Insert Record if new User
                    $userAvail = $validToRegister->userAvailCheck($data, $isImage);
                    if ($userAvail !== true) {
                        $err[][] = $validToRegister->status;
                    } else {
                        //Successfully registered now goto page
                        $_SESSION['user'] = "new";
                        header("location: " . _HOME . "/dashboard/index.php");
                    }
                } elseif (!$vtR && $validToRegister->status == false) {
                    $err['valid'][] = 'Your Email ( <b>' . $data['email'] . '</b> ) is not verified by us. <a class="link-dark text-decoration-underline" data-bs-toggle="modal" href="#popupVerify" role="button">Click Here</a> to verify.';
                } else {
                    $err['valid'][] = $validToRegister->status;
                }
            }
        }
    }
    ?>
    <div class="container">
        <div class="verify-msg hide ">
        </div>
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
        <!--     <div class="title">Registration</di> v-->
        <a href="<?php echo _HOME; ?>"><img src="assets/img/logo.png" class="img-responsive title" alt="" width="250"
                                    height="50"></a>
        <div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                  name="register_form" method="post" enctype="multipart/form-data"
                  class="" id="register_form">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" placeholder="Enter your Firstname" name="fname" id="fname"
                               value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" placeholder="Enter your Lastname" name="lname" id="lname"
                               value="<?php echo isset($_SESSION['lname']) ? $_SESSION['lname'] : ''; ?>" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" placeholder="Enter your email" name="email" id="email"
                               value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                        <label class="email_error"></label>
                    </div>
                    <div class="input-box">
                        <span class="details">Mobile Number</span>
                        <input type="number" placeholder="Enter your number" name="contact_no"
                               id="contact_no"
                               value="<?php echo isset($_SESSION['contact_no']) ? $_SESSION['contact_no'] : ''; ?>">
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Birth</span>
                        <input type="text" placeholder="Date of Birth" name="dob" id="dob"
                               value="<?php echo isset($_SESSION['dob']) ? $_SESSION['dob'] : ''; ?>" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Register As A</span>
                        <select name="jobType" id="jobType">
                            <option class=""
                                    value="J" <?php echo isset($_SESSION['jobType']) && $_SESSION['jobType'] == 'J' ? 'selected' : ''; ?> <?php echo isset($_SESSION['jobType']) ? '' : 'selected'; ?> >
                                Joseeker
                            </option>
                            <option class=""
                                    value="O" <?php echo isset($_SESSION['jobType']) && $_SESSION['jobType'] == 'O' ? 'selected' : ''; ?>>
                                Organization
                            </option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Upload Image</span>
                        <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" placeholder="Enter your password" name="password" class="form-control"
                               id="pass" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" placeholder="Enter your Confirm password" name="cpassword"
                               class="form-control" id="cpass" required>
                    </div>
                    <input type="radio" name="gender" id="dot-1"
                           value="M" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'M' ? 'checked' : ''; ?>>
                    <input type="radio" name="gender" id="dot-2"
                           value="F" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'F' ? 'checked' : ''; ?>>
                    <input type="radio" name="gender" id="dot-3"
                           value="N" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'N' ? 'checked' : ''; ?>>
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                    <div class="button category ">
                        <input type="submit" name="submit_register" value="Register">
                        <input type="reset" value="Reset" id="resetbtn">
                        <input type="button" data-bs-target="#popupVerify" data-bs-toggle="modal" id="verifyButton"
                               value="Verify Your Email">
                        <a href="<?php echo _HOME . '/login.php'; ?>" role="button">Login</a>
                    </div>
                </div>
            </form>
            <p class="hiddenUrl base"><?php echo _HOME; ?></p>
            <p class="hiddenUrl verify">
        </div>

    </div>

    <div class="modal fade" id="popupVerify" aria-labelledby="popupVerifyLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupVerifyLabel">Verify Your Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action=""
                          name="verify_email_form" method="post" class="" id="verify_email_form">
                        <!--                    This is tab for nav-->
                        <div class="d-block ">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item text-center active">

                                    <button type="button" role="tab" class="nav-link active" id="Email-modal"
                                            data-bs-toggle="tab" data-bs-target="#pill_email" aria-selected="true">Enter
                                        Email
                                    </button>
                                </li>

                                <li class="nav-item text-center ">
                                    <button type="button" role="tab" class="nav-link" id="Code-modal"
                                            data-bs-toggle="tab" data-bs-target="#pill_code" aria-selected="false">Enter
                                        Code
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pill_email">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="email" class="form-label font-weight-bold">Email: </label>
                                        <input type="email" name="email" class="form-control" id="verify_email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>""
                                               required>
                                        <label class="email_error"></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" role="button" class="btn btn-primary float-right"
                                                id="verify_email_button">Verify
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pill_code">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="email_code" class="form-label font-weight-bold">Email: </label>
                                        <input type="email" name="email_code" class="form-control" id="email_code"
                                               value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>""
                                               required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="code" class="form-label font-weight-bold">Code: </label>
                                        <input type="text" name="code" class="form-control" id="code" value="" required>
                                        <label class="email_error _code"></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" role="button" class="btn btn-primary float-right"
                                                id="verify_email_submit_button">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <button class="btn btn-primary" data-bs-target="#popupVerify" data-bs-toggle="modal"
                        data-bs-dismiss="modal">Close
                </button>
            </div>
        </div>
    </div>

    <?php
    $reqFiles->get_footer(false);
else:
    header("location: " . _HOME . "/dashboard/index.php");
endif;

