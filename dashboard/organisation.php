<?php



require _DIR . "/etc/jobs/providedJob.php";
$provideJob = new providedJob();
$provideJob->setConn($conn);
$applyJob->setConn($conn);
$jobList = $provideJob->getProvidedJobs($userDetail['Id']);
$pending = $provideJob->getRequestJobs($userDetail['Id'], 'pending');
$accept  = $provideJob->getRequestJobs($userDetail['Id'], 'apply');

?>
<div class="wrapper">
    <div class="clearfix"></div>

    <!-- Title Header Start -->
    <section class="inner-header-title"
             style="background-image:url(<?php echo _HOME . '/assets/img/banner-3.jpg'; ?>);">
        <div class="container">
            <h1>Organization Profile </h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->
    <!-- Candidate Profile Start -->
    <section class="detail-desc advance-detail-pr gray-bg">
        <div class="container white-shadow">
            <div class="row">

                <div class="detail-pic"><img src="<?php echo _UPLOAD_URL . '/images/' . $userDetail['u_image']; ?>"
                                             class="img update_img" alt=""/><a href="#" class="detail-edit" title="edit"><i
                                class="fa fa-pencil update_image_button"></i></a></div>
                <input type="file" name="image" class="update_image_button_file" pattern="image/*"
                       style="display:none">
            </div>

            <div class="row bottom-mrg">
                <div class="col-md-12 col-sm-12">
                    <div class="advance-detail detail-desc-caption">
                        
                        <h2><?php echo $userDetail['fname']; ?></h2>
                        <ul>
                            <li>
                                <strong class="j-view"><?php echo (isset($jobList) && is_array($jobList) && count($jobList) > 0) ? count($jobList) : 0 ?></strong>Job
                                Post
                            </li>
                            <li><strong class="j-shared"></strong></li>
                            <li>
                                <strong class="j-applied"><?php echo (isset($accept)) ? count($accept):0; ?></strong>Job
                                Approved
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row no-padd">
                <div class="detail pannel-footer">
                    <?php if($link_ret):?>
                    <div class="col-md-5 col-sm-5">
                        <ul class="detail-footer-social">
                            <?php
                            if(!empty($links->link['facebook'])&&$links->link!=NULL){
                                echo '<li><a href="'.$links->link['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
                            }
                            if(!empty($links->link['twitter'])&&$links->link!=NULL){
                                echo '<li><a href="'.$links->link['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
                            }
                            if(!empty($links->link['instagram'])&&$links->link!=NULL){
                                echo '<li><a href="'.$links->link['instagram'].'"><i class="fa fa-instagram "></i></a></li>';
                            }
                            if(!empty($links->link['linkedIn'])&&$links->link!=NULL){
                                echo '<li><a href="'.$links->link['linkedIn'].'"><i class="fa fa-linkedin"></i></a></li>';
                            }

                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <section class="full-detail-description full-detail gray-bg">
        <div class="container">
            <div class="col-md-12 col-sm-12">
                <div class="full-card">
                    <div class="deatil-tab-employ tool-tab">
                        <ul class="nav simple nav-tabs" id="simple-design-tab">
                            <li class="active"><a href="#my-info">My Info</a></li>
                            <li><a href="#post-job" id="posted_job"">Job Posted</a></li>
                            <li><a href="#jobrequest">Job Request</a></li>
                            <li><a href="#settings">Edit Profile</a></li>
                            <li><a href="#change-password">Change Password</a></li>
                            <li><a href="#social-media">Social Media</a></li>
                        </ul>
                        <!-- Start All Sec -->
                        <div class="tab-content">
                            <!-- Start About Sec -->
                            <div id="my-info" class="tab-pane fade fade in active">
                                <h3 class="my-profile-h3">About Company</h3>
                                <h2 class="detail-title">> My Information</h2>

                                <ul class="job-detail-des">
                                    <li>
                                        <span>Organization Name:</span><?php echo ($userDetail['org_name'] == "NULL" || $userDetail['org_name'] == NULL) ? ' --- ' : $userDetail['org_name']; ?>
                                    </li>

                                    <li>
                                        <span>Email:</span><?php echo ($userDetail['user_email'] == NULL) ? '  ---  ' : $userDetail['user_email'] ?>
                                    </li>
                                    <li><span>Mobile No. :</span><?php echo $userDetail['user_contactNumber']; ?></li>

                                </ul>
                                <h2 class="detail-title">Address Info</h2>
                                <ul class="job-detail-des">
                                    <li>
                                        <span>Address:</span><?php echo ($userDetail['user_address'] == NULL) ? '  ---  ' : $userDetail['user_address'] ?>
                                    </li>
                                    <li>
                                        <span>City:</span><?php echo ($userDetail['user_city'] == NULL) ? '  ---  ' : $userDetail['user_city'] ?>
                                    </li>
                                    <li>
                                        <span>State:</span><?php echo ($userDetail['user_state'] == NULL) ? '  ---  ' : $userDetail['user_state'] ?>
                                    </li>
                                    <li>
                                        <span>Country:</span><?php echo ($userDetail['user_country'] == NULL) ? '  ---  ' : $userDetail['user_country'] ?>
                                    </li>
                                </ul>
                            </div>
                            <!-- End About Sec -->
                            <!-- Start Job List -->
                            <div id="post-job" class="tab-pane fade">
                                <div class="row extra-mrg">
                                    <div class="wrap-search-filter">
                                        <form class="paging-job" id="paging-job" action="" method="">
                                            <div class="col-md-4 col-sm-6">
                                                <input type="text" class="form-control location" placeholder="Location: City, State, Zip">
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <select class=" form-control "  id="category" title="All Categories">
                                                    <option value="all" selected>
                                                        ALL
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="job-types">
                                                    <select class=" form-control "  id="type" title="All Categories">
                                                        <option value="" selected>
                                                            SELECT TYPE
                                                        </option>
                                                        <option value="1">
                                                            Full Time
                                                        </option>
                                                        <option value="2">
                                                            Part Time
                                                        </option>
                                                        <option value="0">
                                                            Flexible Time
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row getMyJob">
                                </div>
                                <div class="row getMyJobPaging">
                                    <ul class="pagination">

                                    </ul>
                                </div>
                            </div>
                            <!-- End Job List -->
                            <!-- Start Friend List -->
                            <div id="jobrequest" class="tab-pane fade in ">
                                <ul class="nav simple nav-tabs" id="simple-design-tab">
                                    <li class="active"><a href="#jobPending">Pending</a></li>
                                    <li><a href="#jobApproved">Approved</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="jobPending" class="tab-pane fade in active" >
                                <div class="row">
                                    <?php
                                    if (count($pending) >0):
                                        foreach ($pending as $val): ?>
                                            <div class="col-md-4 col-sm-4 card-point">
                                                <div class="manage-cndt">

                                                    <div class="cndt-caption">
                                                        <div class="cndt-pic"><img
                                                                    src="<?php echo _UPLOAD_URL . 'images/' . $val['image_user']; ?>"
                                                                    class="img-responsive" alt=""></div>
                                                        <h4><?php echo $val['fname'] . ' ' . $val['lname']; ?></h2>
                                                        <?php echo (isset($val['category_subname'])) ? '<span>' . $val['category_subname'] . '</span>' : ''; ?>
                                                        <p><?php echo ($val['job_detail'] != NULL && $val['job_detail'] != '') ? $val['job_detail'] : ''; ?></p>
                                                    </div>

                                                    <a title="" class="cndt-profile-btn accept-user"
                                                       data-au-id="<?php echo $val['appl_id']; ?>">Accept</a>
                                                    <a title="" class="cndt-profile-btn deny-user"
                                                       data-du-id="<?php echo $val['appl_id']; ?>">Deny</a>
                                                    <?php $resume = $applyJob->getResume($val['id_puser']);
                                                        if($resume && is_array($resume) && $resume['jobS_resume']){
                                                            echo '<a title="" class="cndt-profile-btn gotouserprofile"
                                                       href="'. _UPLOAD_URL."resumes/".$resume["jobS_resume"].'" target ="_blank">View User Resume</a>';
                                                        }
                                                    $jid =base64_encode($val['job_id']);
                                                    $link = _HOME.'/job/detailview/jobDetailView.php?id='.$jid;
                                                    ?>
                                                    <a href="<?php echo $link; ?>" title="" class="cndt-profile-btn gotojob">View Job</a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    else:
                                        echo "<div class='col-lg-12 mt-4 text-center'><h4>NO PENDING REQUEST</h2>  </div>";
                                    endif;
                                    ?>
                                </div>
                                    </div>

                                    <div id="jobApproved" class="tab-pane" >
                                <div class="row">
                                    <?php
                                    if (count($accept) >0):
                                        foreach ($accept as $val): ?>
                                            <div class="col-md-4 col-sm-4 card-point">
                                                <div class="manage-cndt">

                                                    <div class="cndt-caption">
                                                        <div class="cndt-pic"><img
                                                                    src="<?php echo _UPLOAD_URL . '/images/' . $val['image_user']; ?>"
                                                                    class="img-responsive" alt=""></div>
                                                        <h4><?php echo $val['fname'] . ' ' . $val['lname']; ?></h2>
                                                        <?php echo (isset($val['category_subname'])) ? '<span>' . $val['category_subname'] . '</span>' : ''; ?>
                                                        <p><?php echo ($val['job_detail'] != NULL && $val['job_detail'] != '') ? $val['job_detail'] : ''; ?></p>
                                                    </div>

                                                    <a title="" class="cndt-profile-btn gotouserprofile"
                                                       data-up-id="<?php echo $val['id_puser']; ?>">View User
                                                        Profile</a>
                                                    <?php
                                                    $jid =base64_encode($val['job_id']);
                                                    $link = _HOME.'/job/detailview/jobDetailView.php?id='.$jid;
                                                    ?>
                                                    <a href="<?php echo $link; ?>" title="" class="cndt-profile-btn gotojob">View Job</a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    else:
                                        echo "<div class='col-lg-12 mt-4 text-center'><h4>NO Approved REQUEST</h2>  </div>";
                                    endif;
                                    ?>
                                </div>
                                    </div>
                                </div>

                            </div>
                            <!-- End Friend List -->
                            <!-- Start Settings -->
                            <div id="settings" class="tab-pane fade">
                                <div class="row no-mrg">
                                    <div class="verify-msg prof"></div>

                                    <h3 class="my-profile-h3">Edit Profile</h3>
                                    <div class="edit-pro">
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                              name="jobseeker_edit_form" method="post"
                                              class="" id="jobseeker_edit_form">
                                            <h2 class="detail-title">> Personal Info</h2>
                                            <div class="col-md-4 col-sm-6">
                                                <label>First Name</label>
                                                <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $userDetail['fname']; ?>"  required>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <label>Last Name</label>
                                                <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $userDetail['lname']; ?>" required>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <label>Mobile Number</label>
                                                <input type="number"  name="contact_no" id="contact_no" class="form-control" value="<?php echo $userDetail['user_contactNumber']; ?>">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob" id="dob" class="form-control" value="<?php echo date("Y-m-d",strtotime($userDetail['dob'])); ?>" required>
                                            </div>
                                            <div class="col-md-8 col-sm-6">
                                                <label>Address</label>
                                                <input type="text"  name="address" id="address" class="form-control" placeholder="<?php echo $userDetail['user_address'] == NULL?'Enter your Address' : ''; ?>" value="<?php echo $userDetail['user_address'] != NULL?$userDetail['user_address'] :''; ?>" maxlength="150" required>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <label>City</label>
                                                <input type="text" class="form-control" id="city"
                                                       value="<?php echo $userDetail['user_city']; ?>">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <input type="hidden" id="state-id" value="<?php echo $userDetail['user_state']; ?>">
                                                <label>State</label>
                                                <span  id="state-code">
                                                <input type="text" name="state" class="d-block" id="state">
                                            </span>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <input type="hidden" id="country-id" value="<?php echo $userDetail['user_country']; ?>">
                                                <label>Country</label>
                                                <select name = "country" id="country">
                                                    <option>select country</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 col-sm-12" style="padding-right:15px;padding-left:15px; margin-top:10px!important; margin-bottom: 25px!important;">
                                                <label>Gender</label>
                                                <span style="padding-left:50px; ">Male</span>
                                                <input type="radio" name="gender" class="gender" id="gender_male" value="M" <?php echo isset($userDetail['gender']) && $userDetail['gender'] =="M" ? 'checked':'';?>>
                                                <span style="padding-left:50px; ">Female</span>

                                                <input type="radio" name="gender" class="gender"  id="gender_female" value="F" <?php echo isset($userDetail['gender']) && $userDetail['gender'] =="F" ? 'checked':'';?>>
                                                <span style="padding-left:50px; ">Others</span>
                                                <input type="radio" name="gender" class="gender"  id="gender_othermale" value="N" <?php echo isset($userDetail['gender']) && $userDetail['gender'] =="N" ? 'checked':'';?>>
                                            </div>


                                            <h2 class="detail-title">> User Profile Info</h2>

                                            <div class="col-md-4 col-sm-6">
                                                <label>Organization Name</label>
                                                <input type="text" name="orgName" class="form-control" id="orgName"
                                                       value="<?php echo $userDetail['org_name']; ?>">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label>User Experience</label>
                                                <input type="number" name="user_exp" class="form-control" id="user_exp"
                                                       value="<?php echo $userDetail['jobS_exp']; ?>">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label>User Occupation</label>
                                                <input type="text" name="user_occ" class="form-control" id="user_occ"
                                                       value="<?php echo $userDetail['jobS_occupation']; ?>">
                                            </div>

                                            <div class="col-sm-12">
                                               <button type="submit" name="submit" id="submi-edit-profile" class="update-btn">Update Now</button>
                                            </div>
                                            <input type="hidden" id="uid" value="<?php echo $userDetail['Id']; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Settings -->
                            <div id="change-password" class="tab-pane fade ">
                                <div class="inbox-body inbox-widget">
                                    <div class="row no-mrg">
                                        <div class="verify-msg pass"></div>

                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                              name="jobseeker_pass_form" method="post"
                                              class="" id="jobseeker_pass_form">
                                            <h3 class="my-profile-h3">Change Password</h3>
                                            <div class="edit-pro">
                                                <div class="col-md-4 col-sm-6">
                                                    <label>Old Password</label>
                                                    <input type="password" class="form-control" id="oldpass" placeholder="Old Password">
                                                    <span class="pass_error error"></span>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" id="newpass" placeholder="New Password">
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" id="cpass" placeholder="Confirm Password">
                                                </div>
                                                <div class="col-sm-12">
                                                    <button type="button" class="update-btn confirm_pass_button">Update Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Media -->
                            <div id="social-media" class="tab-pane fade">
                                <div class="inbox-body inbox-widget">
                                    <div class="row no-mrg">
                                        <div class="verify-msg links"></div>

                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                              name="jobseeker_link_form" method="post"
                                              class="" id="jobseeker_link_form">
                                        <h3 class="my-profile-h3">Edit Social Media Link</h3>
                                        <div class="edit-pro">
                                            <div class="col-md-6 col-sm-6">
                                                <label>Facebook</label>
                                                <input type="url" name="facebook" id="facebook" class="form-control" placeholder="Facebook" value="<?php echo $link_ret == true ? $links->link['facebook']:'';  ?>">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Twitter</label>
                                                <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Twitter" value="<?php echo $link_ret == true ? $links->link['twitter']:'';  ?>">
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <label>Instagram</label>
                                                <input type="url" name="instagram" id="instagram" class="form-control" placeholder="Instagram" value="<?php echo $link_ret == true ? $links->link['instagram']:'';  ?>">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Linked In</label>
                                                <input type="url" name="linkin" id="linkin" class="form-control" placeholder="Linked In" value="<?php echo $link_ret == true ? $links->link['linkedIn']:'';  ?>">
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" class="update-btn link_button">Update Now</button>
                                            </div>
                                            <input type="hidden" id="uid_link" value="<?php echo $userDetail['Id']; ?>">
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Media -->
                        </div>
                        <!-- Start All Sec -->
                    </div>
                </div>
            </div>
        </div>
    </section>
