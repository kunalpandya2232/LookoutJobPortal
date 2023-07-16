<?php



session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles                = new settings();
$reqFiles->get_required_files();
if (isset($_SESSION['user']) && $_SESSION['type'] == 'O' || $_SESSION['type'] == 'A' ):
    $pageName = "New Job" . SITE_NAME;
    $_SESSION['curPage'] = 'postnew';
    $reqFiles->get_header($pageName);
    if ($_POST && $_POST['post_job']) {
        $err = [];
        $reqFiles->get_valid_checker();
        $valid   = new validChecker();
        $uid = $valid->getUserByEmail($_SESSION['email']);
        $catgory = $_POST['category'];
        unset($_POST['category'], $_POST['post_job']);
        $noremovespaces = ['jobtitle'=>$_POST['jobtitle'], 'jobLocation'=> $_POST['jobLocation'], 'jobdescription'=> $_POST['jobdescription'],'jobresponsiblity'=>$_POST['jobresponsiblity']];
        $data    = $valid->cleanData($_POST,$noremovespaces);
        $catgory = $valid->cleanData($catgory,$catgory);
        if ($catgory[0] == "0") {
            $err['cat'][] = "Please Select Category";
        }
        $fields = $valid->getPostJobFileds(true);

        foreach (array_keys($data) as $jobName) {
            if (in_array($jobName, array_keys($fields))){
                if($data[$jobName]==""){
                    $err['fields'][] = "Some field is missing";
                }
            }
        }
        if (count($err) < 1) {
            $data = $valid->getPostJobFileds($data, $catgory[0]);

            $dbconn = new db();
            if (!class_exists('validToJobPost')) {
                $conn = $dbconn->getConn();
                require _DIR . '/etc/checker/validToJobPost.php';
                $uid = $valid->getUserByEmail($dbconn->getConn(),$_SESSION['email']);
                $data['uid']=$uid['Id'];
                $vtJp = $validToJobPost->validToJobPostFunc($conn, $data);
            }
            if ($vtJp) {
                $err['valid'][]         = $validToJobPost->status;
                $_SESSION['jobSuccess'] = true;
                header("location: " . _HOME . "/others/thankyouPostjob.php");
            } else {
                $err[][] = $validToJobPost->status;
            }
        }
    }
    unset($data, $vtJp, $_POST, $catgory);
    ?>
    <div class="wrapper">

    <div class="clearfix"></div>

    <!-- Header Title Start -->
    <section class="inner-header-title blank">
        <div class="container">
            <h1>Create Job</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="post_job_form" method="post"
          class="add-feild" id="post_job_form">
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
                <h2 class="detail-title">Job Information</h2>

                <div class="row bottom-mrg " style="margin-top: 20px;">

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" name="jobtitle" class="form-control " placeholder="Job Title"
                                   id="jobtitle" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" name ="jobLocation" class="form-control" id="jobLocation" value=""  placeholder="Location,e.g. London Quel Mark" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control" placeholder="Job Description" name="jobdescription"
                                  id="jobdescription" required></textarea>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <select class="form-control input-lg" name="jobhours" id="jobhours" required>
                                <option value="1" selected>Full Time</option>
                                <option value="2">Part Time</option>
                                <option value="0">Flexible Time</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <select class="form-control input-lg" name="category[]" id="category" required>
                                <option class="" value="0">SELECT CATEGORY</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <input type="number" name="jobvcc" class="form-control" id="jobvcc" min="0" placeholder="Job Vaccancy"
                               value="" required>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control" name="jobresponsiblity" id="jobresponsiblity" placeholder="Job Responsibilities" required></textarea>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control" name="skillRequire" id="skillRequire" placeholder="Skill Requirement" required></textarea>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <input type="number" name="minexp" class="form-control" id="minexp" value=""
                               placeholder="Minimum Experience" min="0" required>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <input type="number" name="jobamt" class="form-control" id="jobamt" value=""
                               placeholder="Salary" min="0" required>
                    </div>
                </div>
            </div>
        </div>
        <!-- General Detail End -->
        <div class="col-md-12 col-sm-12">
            <input type="submit" name="post_job" class="btn btn-success btn-primary small-btn" value="SUBMIT JOB">
        </div>
    </form>
    <p class="hiddenUrl base"><?php echo _HOME; ?></p>
    <p class="hiddenUrl verify">
    <?php
    $reqFiles->get_footer();
else:
    echo 'Cannot call directly';
endif;

