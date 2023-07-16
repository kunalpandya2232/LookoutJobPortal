<?php


session_start();
require "../../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
$reqFiles = new settings();
$reqFiles->get_required_files();

$_SESSION['cur_page'] = 'add';
$pageName             = "Edit User" . SITE_NAME;
$reqFiles->get_header_admin($pageName);
if ($_GET && $_GET['user'] == 'organisation') {
    $data['user_type'] = "O";
    $url="?user=organisation";
} elseif ($_GET && $_GET['user'] == 'jobseeker') {
    $data['user_type'] = "J";
    $url="?user=jobseeker";

} else {
    $data['user_type'] = "";
    $url="";
    echo "<h1>Not allowed to access</h1>";
    header("location: "._HOME.'/index.php');
}

if($_POST && $_POST['add_user'] ){

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

    if (!$checker->gender($data['gender'])) {
        $err['gender'][] = "Gender is not set";
    }

    /**START FILES UPLOAD**/
    $isImage = [0];
    if ($_FILES && !empty($_FILES['image']['name'])) {
        if (!class_exists('uploadImageFunc')) {
            require _DIR . '/etc/checker/validToUpload.php';
            $uploadImage = new uploadImageFunc();
            $upR         = $uploadImage->validToUploadFunc($_FILES, 'image', 'image');
            if ($upR == true) {
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
                $data['dob']=date("y-m-d",strtotime($data['dob']));
                //Insert Record if new User
                $userAvail = $validToRegister->adminInsert($dbconn->getConn(),$data);
                if ($userAvail !== true) {
                    $err[][] = $validToRegister->status;
                } else {
                    //Successfully registered now goto page
                    $_SESSION['user_register'] = "new";
                    if(isset($data['user_type']) && $data['user_type'] == "O"){

                        header("location: " . _ADMIN_HOME . "/organization.php");
                    }elseif(isset($data['user_type']) && $data['user_type'] == "J"){
                        header("location: " . _ADMIN_HOME . "/jobseeker.php");

                    }
                }

        } else {
            $err['valid'][] = $validToRegister->status;
        }
    }
}

?>
<div class="wrapper">

    <div class="clearfix"></div>

    <!-- Header Title Start -->
    <section class="inner-header-title blank">
        <div class="container">
            <h1>Create User</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).$url; ?>" name="new_user_form" method="post"
          class="add-feild new_user_form" id="new_user_form">
        <!-- General Detail Start -->
        <div class="detail-desc section">

            <div class="container white-shadow">
                <div class="verify-msg hide ">
                </div>
                <?php
                if (isset($err) && count($err) > 0) {
                    $html = '<div class="ml-2 mr-2">';
                    foreach ($err as $errors => $val) {
                        $valid = $errors == 'valid' ? true : false;
                        foreach ($val as $name => $value) {
                            if ($valid) {
                                $html .= '<div class="alert alert-success">' . $value . ' <button class="btn btn-sm btn-outline-success float-right close_err">X</button> </div>';
                            } else {
                                $html .= '<div class="alert alert-danger">' . $value . ' <button class="btn btn-sm btn-outline-danger float-right close_err">X</button> </div>';
                            }
                        }
                    }
                    $html .= '</div>';
                    echo $html;
                }
                ?>
                <h2 class="detail-title">User Information</h2>

                <div class="row bottom-mrg " style="margin-top: 20px;">

                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="text" name="fname" id="fname" class="form-control"
                                   placeholder="User First Name" value="" required>

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="text" name="lname" id="lname" class="form-control" placeholder="User Last Name"
                                   value="" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <input type="text" name="orgName" class="form-control" id="orgName"
                               placeholder="Organization Name" value="">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="email" placeholder="Enter User email" name="email" class="form-control"
                                   id="email" value="" required>
                            <label class="email_error"></label>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="number" placeholder="Enter your number" name="contact_no" class="form-control"
                                   id="contact_no" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="text" placeholder="Date of Birth" name="dob" class="form-control" id="dob"
                                   value="" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" name="address" id="address" class="form-control"
                                   placeholder='Enter your Address' value="" maxlength="150" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="city" placeholder='Enter your City Name'
                                   value="">
                        </div>
                    </div>
  <div class="col-md-2 col-sm-6">
                        <div class="input-group">
                            <select name="jobType" id="jobType">
                                <option class=""
                                        value="J" <?php echo isset($data['user_type']) && $data['user_type'] == 'J' ? 'selected' : ''; ?> <?php echo isset($_SESSION['jobType']) ? '' : 'selected'; ?> >
                                    Joseeker
                                </option>
                                <option class=""
                                        value="O" <?php echo isset($data['user_type']) && $data['user_type'] == 'O' ? 'selected' : ''; ?>>
                                    Organization
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <span id="state-code">
                                <input type="text" name="state" class="form-control" id="state">
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <select name="country" id="country">
                            <option>select country</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12"
                         style="padding-right:15px;padding-left:15px; margin-top:10px!important; margin-bottom: 25px!important;">
                        <label>Gender</label>
                        <span style="padding-left:50px; ">Male</span>
                        <input type="radio" name="gender" class="gender" id="gender_male"
                               value="M" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "M" ? 'checked' : ''; ?>>
                        <span style="padding-left:50px; ">Female</span>

                        <input type="radio" name="gender" class="gender" id="gender_female"
                               value="F" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "F" ? 'checked' : ''; ?>>
                        <span style="padding-left:50px; ">Others</span>
                        <input type="radio" name="gender" class="gender" id="gender_othermale"
                               value="N" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "N" ? 'checked' : ''; ?>>
                    </div>
                    <div class="col-md-4 col-sm-6">

                        <input type="password" placeholder="Enter your password" name="password" class="form-control"
                               id="pass" required>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <input type="number" name="user_exp" class="form-control" id="user_exp"
                               placeholder="User Experience" value="">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <input type="text" name="user_occ" class="form-control" id="user_occ"
                               placeholder="User Occupation" value="">
                    </div>
                </div>
            </div>
        </div>
        <!-- General Detail End -->

        <div class="col-md-6 col-sm-12">
            <a href="<?php echo _ADMIN_HOME.'/dashboard.php'?>" class="btn btn-success btn-primary small-btn">Go To Dashboard</a>
        </div>
        <div class="col-md-6 col-sm-12">
            <input type="submit" name="add_user" class="btn btn-success btn-primary small-btn" value="SUBMIT USER">
        </div>
    </form>
    <p class="hiddenUrl base"><?php echo _HOME; ?></p>
    <p class="hiddenUrl verify">
<script type="text/javascript">
    // user country code for selected option
    let user_country_code = "IN";
    let user_state_code = "Andaman and Nicobar Islands";

    (function () {
        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

        // creating country name drop-down
        let option = '';
        option += '<option>select country</option>';
        for (let country_code in country_list) {
            // set selected option user country
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="' + country_list[country_code] + '"' + selected + ' data-code="' + country_code + '" >' + country_list[country_code] + '</option>';
        }
        document.getElementById('country').innerHTML = option;

        // creating states name drop-down
        let text_box = '<input type="text" name="state" class="input-text form-control" id="state">';
        let state_code_id = document.getElementById("state-code");

        function create_states_dropdown() {
            // get selected country code
            let country_code = document.getElementById("country");
            var value = country_code.options[country_code.selectedIndex].getAttribute("data-code");
            let states = states_list[value];
            // invalid country code or no states add textbox
            if (!states) {
                state_code_id.innerHTML = text_box;
                return;
            }
            let option = '';
            if (states.length > 0) {
                option = '<select name="state" id="state">\n';
                for (let i = 0; i < states.length; i++) {
                    let selected_code = (states[i].name == user_state_code) ? 'selected' : '';
                    option += '<option value="' + states[i].name + '" ' + selected_code + '>' + states[i].name + '</option>';
                }
                option += '</select>';
            } else {
                // create input textbox if no states
                option = text_box
            }
            state_code_id.innerHTML = option;
        }

        // country select change event
        const country_select = document.getElementById("country");
        country_select.addEventListener('change', create_states_dropdown);

        create_states_dropdown();
    })();

</script>
<?php
$reqFiles->get_footer_admin();
?>
