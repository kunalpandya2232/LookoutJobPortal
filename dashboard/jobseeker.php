<?php


$applyJob->setConn($conn);
$resume = $applyJob->getResume($userDetail['Id']);
$jobList = $applyJob->getappliedJob($userDetail['Id']);
$apply = $applyJob->getAppliedJobs($userDetail['Id']);
?>
<div class="wrapper">
    <div class="clearfix"></div>
    <section class="inner-header-title"
             style="background-image:url(<?php echo _HOME . '/assets/img/banner-3.jpg'; ?>);">
        <div class="container">
            <?php
            $user_detail_name = (isset($_SESSION['user']) && $_SESSION['user'] == 'new') ?
                'Welcome ' . $userDetail["fname"] : 'My profile';

            echo "<h1>" . $user_detail_name . "</h1>"; ?>
        </div>
    </section>
    <div class="clearfix"></div>
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
                        <h4><?php echo ucfirst($userDetail['fname']) . ' ' . ucfirst($userDetail['lname']); ?></h2>
                        <ul>
                            <li>
                                <strong class="j-view">
                                    <?php if (isset($jobList) && $jobList && isset($apply) && $apply) {
                                        $total = count($jobList) + count($apply);
                                        echo $total;
                                    } else if (isset($apply) && $apply) {
                                        echo 0 + count($apply);
                                    } elseif (isset($jobList) && $jobList) {
                                        echo count($jobList);
                                    } else {
                                        echo "0";
                                    }; ?></strong> Job applied
                            </li>
                            <li><strong class="j-shared"></strong></li>
                            <li><strong class="j-applied">
                                    <?php if (isset($jobList) && $apply) {
                                        echo count($apply);
                                    } else {
                                        echo "0";
                                    }; ?></strong>Job Approved
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
</div>
</section>
<section class="full-detail-description full-detail gray-bg">
    <div class="container">
        <div class="col-md-12 col-sm-12">
            <div class="full-card">
                <div class="deatil-tab-employ tool-tab">
                    <ul class="nav simple nav-tabs" id="simple-design-tab">
                        <li class="active"><a href="#my-info">My Info</a></li>
                        <li><a href="#post-job" id="job_apply">Job Applied</a></li>
                        <li><a href="#settings">Edit Profile</a></li>
                        <li><a href="#change-password">Change Password</a></li>
                        <li><a href="#social-media-resume">Social Media & Resume</a></li>
                    </ul>
                    <!-- Start All Sec -->
                    <div class="tab-content">
                        <!-- Start About Sec -->
                        <div id="my-info" class="tab-pane fade in active">
                            <h3 class="my-profile-h3">About <?php echo ucwords($userDetail['fname']); ?></h3>
                            <h2 class="detail-title"> My Information</h2>
                            <ul class="job-detail-des">
                                <li><span>First Name:</span><?php echo $userDetail['fname']; ?></li>
                                <li><span>Last Name:</span><?php echo $userDetail['lname']; ?></li>

                                <li>
                                    <span>Email:</span><?php echo ($userDetail['user_email'] == NULL) ? '  ---  ' : $userDetail['user_email'] ?>
                                </li>
                                <li><span>Mobile No. :</span><?php echo $userDetail['user_contactNumber']; ?></li>
                                <li><span>Gender:</span>
                                    <?php if ($userDetail['user_gender'] == 'M') {
                                        echo "Male";
                                    } elseif ($userDetail['user_gender'] == 'F') {
                                        echo "Female";
                                    } else {
                                        echo "Rather Not say";
                                    }; ?></li>
                                <li><span>DOB:</span><?php echo date("d/m/y", strtotime($userDetail['dob'])); ?></li>
                            </ul>
                            <br>
                            <h2 class="detail-title">> Address Info</h2>

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
                        <div id="post-job" class="tab-pane fade ">
                            <div class="row get-my-apply-job" data-id="<?php echo $userDetail['Id']; ?>">
                                <h3 class="my-profile-h3">You Have <?php if (isset($jobList) && $jobList) {
                                        echo count($jobList);
                                    } else {
                                        echo "0";
                                    }; ?> Job Applied</h3>

                                <?php

                                ?>
                            </div>
                            <div class="row paging">
                                <ul class="pagination">

                                </ul>
                            </div>
                        </div>
                        <!-- End Job List -->

                        <!-- Start Settings -->
                        <div id="settings" class="tab-pane fade ">
                            <div class="row no-mrg">

                                <h3 class="my-profile-h3">Edit Profile</h3>
                                <div class="verify-msg prof"></div>

                                <div class="edit-pro">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                          name="jobseeker_edit_form" method="post"
                                          class="" id="jobseeker_edit_form">
                                        <h2 class="detail-title">> Personal Info</h2>
                                        <div class="col-md-4 col-sm-6">
                                            <label>First Name</label>
                                            <input type="text" name="fname" id="fname" class="form-control"
                                                   value="<?php echo $userDetail['fname']; ?>" required>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <label>Last Name</label>
                                            <input type="text" name="lname" id="lname" class="form-control"
                                                   value="<?php echo $userDetail['lname']; ?>" required>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <label>Mobile Number</label>
                                            <input type="number" name="contact_no" id="contact_no" class="form-control"
                                                   value="<?php echo $userDetail['user_contactNumber']; ?>">
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" id="dob" class="form-control"
                                                   value="<?php echo date("Y-m-d", strtotime($userDetail['dob'])); ?>"
                                                   required>
                                        </div>

                                        <div class="col-md-8 col-sm-6">
                                            <label>Address</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                   placeholder="<?php echo $userDetail['user_address'] == NULL ? 'Enter your Address' : ''; ?>"
                                                   value="<?php echo $userDetail['user_address'] != NULL ? $userDetail['user_address'] : ''; ?>"
                                                   maxlength="150" required>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <label>City</label>
                                            <input type="text" class="form-control" id="city"
                                                   value="<?php echo $userDetail['user_city']; ?>">
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <input type="hidden" id="state-id"
                                                   value="<?php echo $userDetail['user_state']; ?>">
                                            <label>State</label>
                                            <span id="state-code">
                                                <input type="text" name="state" class="d-block" id="state">
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <input type="hidden" id="country-id"
                                                   value="<?php echo $userDetail['user_country']; ?>">
                                            <label>Country</label>
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


                                        <h2 class="detail-title">> User Profile Info</h2>

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
                                            <button type="submit" name="submit" id="submi-edit-profile"
                                                    class="update-btn">Update Now
                                            </button>
                                        </div>
                                        <input type="hidden" id="uid" value="<?php echo $userDetail['Id']; ?>"
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Settings -->

                        <!-- Start Change Pass -->
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
                                                <input type="password" class="form-control" id="oldpass"
                                                       placeholder="Old Password">
                                                <span class="pass_error error"></span>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" id="newpass"
                                                       placeholder="New Password">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="cpass"
                                                       placeholder="Confirm Password">
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" class="update-btn confirm_pass_button">Update
                                                    Now
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Change Pass-->

                        <!-- Start Media -->
                        <div id="social-media-resume" class="tab-pane fade ">
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
                                                <input type="url" name="facebook" id="facebook" class="form-control"
                                                       placeholder="Facebook"
                                                       value="<?php echo $link_ret == true ? $links->link['facebook'] : ''; ?>">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Twitter</label>
                                                <input type="url" name="twitter" id="twitter" class="form-control"
                                                       placeholder="Twitter"
                                                       value="<?php echo $link_ret == true ? $links->link['twitter'] : ''; ?>">
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <label>Instagram</label>
                                                <input type="url" name="instagram" id="instagram" class="form-control"
                                                       placeholder="Instagram"
                                                       value="<?php echo $link_ret == true ? $links->link['instagram'] : ''; ?>">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Linked In</label>
                                                <input type="url" name="linkin" id="linkin" class="form-control"
                                                       placeholder="Linked In"
                                                       value="<?php echo $link_ret == true ? $links->link['linkedIn'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" class="update-btn link_button">Update Now</button>
                                            </div>

                                            <h3 class="my-profile-h3">Resume</h3>
                                            <div class="col-md-4 col-sm-6">
                                                <label>Upload Resume</label>
                                                <div class="row">
                                                    <div class="detail-pic js">

                                                        <input type="file" name="upload-pic" id="upload-pic"
                                                               class="inputfile resume" accept="application/pdf">
                                                        <label for="upload-pic"><i class="fa fa-upload"
                                                                                   aria-hidden="true"></i><span></span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <?php if ($resume && is_array($resume) && $resume['jobS_resume'] != NULL): ?>

                                                    <div class="col-md-4 col-sm-6">
                                                        <a href="<?php echo _UPLOAD_URL . 'resumes/' . $resume['jobS_resume']; ?>"
                                                           class="footer-btn grn-btn" title="View"><i
                                                                    class="fa fa-eye"></i> View Resume</a><br>
                                                        <a href="javascrip::void(0)"
                                                           class="footer-btn grn-btn removeResume" title="Delete"><i
                                                                    class="fa fa-trash"></i> Delete Resume</a>
                                                    </div>
                                                <?php endif; ?>
                                                <button type="button" class="update-btn upload_resumeBtn">Update Now
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="uid_link" value="<?php echo $userDetail['Id']; ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Media -->
                    </div>
                </div>
                <!-- Start All Sec -->
            </div>
        </div>
    </div>

    </div>
</section>
<script type="text/javascript">

</script>
