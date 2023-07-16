<?php


session_start();
require "../../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles                = new settings();
$reqFiles->get_required_files();
$pageName = "Detail Job" . SITE_NAME;
$_SESSION['curPage'] = 'jobview';
$reqFiles->get_header($pageName);
if (!class_exists("jobView")) {
    require _DIR . '/etc/jobs/jobView.php';
    $jobView = new jobView();
}
$db    = new db();
$conn  = $db->getConn();

if (isset($_GET['id'])) {
    $data['jobId']=base64_decode($_GET['id']);
    $jobConn = $db->getConn();
    $jobView->setConn($jobConn);
    $result   = $jobView->jobDetailVIewFunc($data);
}
    $reqFiles->get_valid_checker();
    $valid = new validChecker();
if(isset($_SESSION['type'])){
    $user  = $valid->getUserByEmail($conn, $_SESSION['email']);

}
if (isset($_SESSION['user']) ) {

    $data ['userId']=$user['Id'];
    $jobConn = $db->getConn();
    $jobView->setConn($jobConn);
    $jobApply = $jobView->checkJobApplied($data);
    $isReport = $jobView->isReportByUser($data);
    $links = $jobView->getLinks($result['user_id']);
    if ($_POST && isset($_POST['applyJob'])) {
        $err    = [];
        $data   = ['jobId' => base64_decode($_POST['jobId']), 'userId' => $user['Id']];
        $resJob = $jobView->applyJobFunc($conn, $data);
        if ($jobView->status && $resJob) {
            $_SESSION['jobApply'] = true;
            header("location: " . _HOME . "/others/thankyouApplyjob.php");
        } else {
            header("location: " . _HOME . "/job/detailView/jobDetailView.php?id=" . $_POST['jobId']);
        }
    }
}
    ?>
    <div class="wrapper">
    <div class="clearfix"></div>

    <!-- Title Header Start -->
    <section class="inner-header-title"
             style="background-image:url(<?php echo _HOME . '/assets/img/banner-4.jpg'; ?>);">
        <div class="container">
            <h1>Job Detail</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->
    <!-- Job Detail Start -->
    <section class="detail-desc">
        <div class="container white-shadow">
            <?php if ($jobView->status == true && $result): ?>

                <div class="row">
                    <div class="detail-pic">
                        <img src="<?php echo _UPLOAD_URL . 'images/' . $result['user_photo']; ?>" class="img"
                             alt="organization Image"/>
                        <a href="#" class="detail-edit" title="edit"></a>
                    </div>
                </div>

                <div class="row bottom-mrg">
                    <div class="col-md-8 col-sm-8">
                        <div class="detail-desc-caption">
                            <?php
                            if ($result['user_type'] == "O") {
                                if ($result['org_name'] == "" || $result['org_name'] == NULL) {
                                    $company = $result['user_fname'];
                                } else {
                                    $company = $result['org_name'];
                                }
                            } else {
                                $company = "LOOKOUT";
                            }
                            echo "<h4>" . $result['job_title'] . "</h4>";
                            echo "<p><b>By: " . $company . "</b></p>";
                            if ($result['job_hours'] == 1) {
                                $result['job_hours'] = 'Full Time';
                            } elseif ($result['job_hours'] == 2) {
                                $result['job_hours'] = 'Part Time';
                            } elseif ($result['job_hours'] == 0) {
                                $result['job_hours'] = 'Flexible Time';
                            }
                            echo '<ul>
                                <li><i class="fa fa-briefcase"></i><span> Job Vaccancy: ' . $result["job_vacancy"] . '</span></li>
                                <li><i class="fa fa-flask"></i><span> Minimum Experience: ' . $result["job_miniexp"] . ' years </span></li>
                            </ul>';
                            echo '<ul><li><i class="fa fa-flask"></i> <span> Job Category: ' . ucfirst($result["category_subname"]) . ' </span> </li></ul>'; ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="get-touch">
                            <h4>Get in Touch</h4>
                            <?php
                            if ($result['user_type'] == "O") {
                                if ($result['job_location'] != "0" && $result['job_location'] != "NULL" && $result['job_location'] != "") {
                                    $location = $result['job_location'];
                                } elseif (!empty($result['user_state']) && !empty($result['user_country'])) {
                                    $location = $result['user_state'] . ', ' . $result['user_country'];
                                } else {
                                    $location = '';
                                }
                            } else {
                                $location = 'GUJARAT, INDIA';
                            }
                            ?>
                            <ul>
                                <li><i class="fa fa-map-marker"></i><span><?php echo $location ?></span></li>
                                <li><i class="fa fa-envelope"></i><span><?php echo $result['user_email']; ?></span></li>
                                <li><i class="fa fa-briefcase"></i><span> <?php echo $result["job_hours"]; ?></span>
                                </li>
                                <li><i class="fa fa-money"></i><span><?php echo  $result['job_amt']; ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row no-padd">
                    <div class="detail pannel-footer">
                        <div class="col-md-5 col-sm-5">
                            <?php if(isset($links) && $links && count($links)>0):?>
                                <ul class="detail-footer-social">
                                    <?php if($links && isset($links['facebook']) &&$links['facebook']!=NULL && $links['facebook']!=''){
                                        echo '<li><a href="'.$links['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
                                    }
                                    if($links && isset($links['twitter']) &&$links['twitter']!=NULL && $links['twitter']!=''){
                                        echo '<li><a href="'.$links['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
                                    }
                                    if($links && isset($links['instagram']) &&$links['instagram']!=NULL && $links['instagram']!=''){
                                        echo '<li><a href="'.$links['instagram'].'"><i class="fa fa-linkedin"></i></a></li>';
                                    }
                                    if($links && isset($links['linkedIn']) &&$links['linkedIn']!=NULL && $links['linkedIn']!=''){
                                        echo '<li><a href="'.$links['linkedIn'].'"><i class="fa instagram"></i></a></li>';
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                            <div class="col-md-7 col-sm-7">
                                <div class="detail-pannel-footer-btn pull-right">
                                    <?php if (isset($user)  && $user['type'] == 'J'): ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                          name="applyJob_form" method="post" class="" id="applyJob_form">
                                        <?php
                                        if (isset($jobApply) && $jobApply != NULL) {
                                            if ($jobApply['apply'] == 1) {
                                                echo '<a href="#" class="footer-btn grn-btn" title="Job Approved">Job Approved</a>';
                                            } else {
                                                echo '<a href="#" class="footer-btn grn-btn" title="Job Applied">Job Applied</a>';
                                            }
                                        } else {
                                            ?>
                                            <input type="hidden" name="jobId" value="<?php echo $_GET['id']; ?>">
                                            <input type="submit" name="applyJob" class="footer-btn grn-btn"
                                                   title="Apply Job" value="Apply Job">
                                        <?php } ?>


                                        <?php
                                        if($isReport==false):
                                            $_SESSION['report_uid']=$_GET['id'];
                                            ?>
                                            <a href="<?php echo _HOME.'/report.php'.'?id='.$_GET['id']; ?>" class="footer-btn blu-btn" title="Report Job">Report Job</a>

                                        <?php elseif($isReport == true):?>
                                            <a href="javascrip::void(0)" class="footer-btn grn-btn" title="Login">Job Reported</a>

                                        <?php endif;?>
                                        <a href="<?php echo _HOME.'/job/searchjob.php'; ?>" class="footer-btn blu-btn" title="Login">GO BACK</a>
                                    </form>
                                    <?php elseif(isset($user)  && $user['type'] == 'O' ): ?>
                                        <a href="<?php echo _HOME.'/index.php'; ?>" class="footer-btn blu-btn" title="Back">GO BACK</a>
                                        <a href="<?php echo _HOME.'/dashboard/index.php'; ?>" class="footer-btn blu-btn" title="Login">GO TO DASHBOARD</a>
                                    <?php elseif( isset($_SESSION['type']) && $_SESSION['type'] == 'A' ): ?>
                                        <a href="<?php echo _ADMIN_HOME.'/post.php'; ?>" class="footer-btn blu-btn" title="Back">GO BACK</a>
                                    <?php else:?>
                                    <?php if(!isset($_SESSION['user'])):?>

                                        <a href="<?php echo _HOME.'/login.php'; ?>" class="footer-btn grn-btn" title="Login">Need to Login</a>
                                        <a href="<?php echo _HOME.'/index.php'; ?>" class="footer-btn blu-btn" title="Back">GO BACK</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Job Detail End -->

    <!-- Job full detail Start -->
    <section class="full-detail-description full-detail">
        <div class="container">
            <?php if ($jobView->status == true && $result): ?>
                <div class="row row-bottom">
                    <h2 class="detail-title">Description</h2>
                    <p><?php echo $result['job_desc']; ?></p>
                </div>

                <?php if ($result['job_responsibility'] != NULL && $result['job_responsibility'] != "NULL"): ?>
                    <div class="row row-bottom">
                        <h2 class="detail-title">Job Responsibility</h2>
                        <p><?php echo $result['job_responsibility']; ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($result['job_skillRequire'] != NULL && $result['job_skillRequire'] != "NULL"): ?>
                    <div class="row row-bottom">
                        <h2 class="detail-title">Skill Requirement</h2>
                        <p><?php echo $result['job_skillRequire']; ?></p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row row-buttom">
                    <h2 class="detail-title">No Such Job Availabel</h2>
                </div>
            <?php endif; ?>

        </div>
    </section>
    <?php if (isset($user) && $user || isset($_SESSION['type']) && $_SESSION['type']=='A'):?>

        <section class="full-detail-description full-detail comment">
        <div class="container">
            <div class="row row-bottom">
                <h2 class="detail-title">Coments</h2>
                <div class="col-lg-12">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$_GET['id']; ?>"
                          name="comment_form" method="post" class="" id="comment_form">
                        <div class="col-12">
                            <textarea class="form-control" placeholder="Add Comment" id="commentField" maxlength="200" rows="5"></textarea>
                            <span class="countComment pull-right">0/200</span>

                            <input type="hidden" name="jobId" id="commentJid" value="<?php echo base64_decode($_GET['id']); ?>">
                            <input type="hidden" name="userType" class="userType" value="<?php echo $user['type']; ?>">

                        </div>
                    </form>

                    <button class="footer-btn grn-btn addComment" id="addComment" title="Add">Add</button>
                    <br>
                    <br>
                    <p style="display:none" class="uid"><?php echo $user['Id']; ?></p>
                </div>
                <div class="commentList">
                    <div class="widget blog-comments clearfix">

                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php endif;?>

    <p class="hiddenUrl base"><?php echo _HOME; ?></p>
    <p class="hiddenUrl verify"></p>
    <?php
    $reqFiles->get_footer();

