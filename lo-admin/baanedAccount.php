<?php

session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;
$configFiles = new settings();
$configFiles->get_required_files();
$_SESSION['cur_page'] = 'bann';
$pageName             = "Manage Bann Account" . SITE_NAME;
$configFiles->get_header_admin($pageName);
$db = new db();
require _DIR_ADMIN."/etc/validToAdminDash.php";

$baan = new validToAdminDash();
$baan->setConn($db->getConn());
$res = $baan->getBannedAccount();
$res_rep = $baan->getBannedAccountWithReport();

?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Banned - Account</h4>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                $uid =[];
                if($res_rep && is_array($res_rep)):
                foreach ($res_rep as $name =>$vall):
                    if($vall['org_name']!=NULL && !empty($vall['org_name'])){
                        $company = $vall['org_name'];
                    }else{
                        $company = $vall['f_name'];
                    }
                    $uid [] = $vall['uid'];
                    ?>
                <article class="ubBann-section" id="<?php echo base64_encode($vall['uid']); ?>">
                    <div class="mng-company">
                        <div class="col-md-2 col-sm-2">
                            <div class="mng-company-pic">
                                <img src="<?php echo _UPLOAD_URL.'/images/'.$vall['img']; ?>" class="img-responsive" alt=""/>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="mng-company-name">
                                <h4><?php echo $company; ?></h4>
                                <span class="cmp-time"><?php echo $vall['report_title']?></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="mng-company-location">
                                <p> <?php echo $vall['report_desc'];?></p>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1">
                            <div class="mng-company-action">
                                <a href="#" class="unBann" data-toggle="modal" data-target="#unBann" data-id="<?php echo base64_encode($vall['uid']); ?>" title="Delete"><i
                                            class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach;
                endif;
                if($res && is_array($res)):
                foreach ($res as $name =>$vall):
                    if(!in_array($vall['uid'],$uid)):
                    ?>
                    <?php
                    if($vall['org_name']!=NULL && !empty($vall['org_name'])){
                        $company = $vall['org_name'];
                    }else{
                        $company = $vall['f_name'];
                    }
                    ?>
                    <article class="ubBann-section" id="<?php echo base64_encode($vall['uid']); ?>">
                        <div class="mng-company">
                            <div class="col-md-2 col-sm-2">
                                <div class="mng-company-pic">
                                    <img src="<?php echo _UPLOAD_URL.'images/'.$vall['img']; ?>" class="img-responsive" alt=""/>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="mng-company-name">
                                    <h4><?php echo $company; ?></h4>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="mng-company-location">
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <div class="mng-company-action">
                                    <a href="#" class="unBann" data-toggle="modal" data-target="#unBann" data-id="<?php echo base64_encode($vall['uid']); ?>" title="Delete"><i
                                                class="fa fa-trash-o"></i></a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endif; endforeach; else:?>
                No Acoounts Found
                <?php endif; ?>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-7">

            </div>
        </div>

    </div>
</div>


<div id="unBann" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="assets/img/sent.png" alt="" width="50" height="46">
                <h3>Are you sure want to UnBann this Account?</h3>
                <div class="m-t-20"><a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-danger unBannBut">UnBann</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$configFiles->get_footer_admin();
?>
