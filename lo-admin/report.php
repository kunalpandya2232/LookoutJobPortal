<?php

session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as  db;
$configFiles = new settings();
$configFiles->get_required_files();
$_SESSION['cur_page'] = 'report';
$pageName             = "Manage Reports" . SITE_NAME;
$configFiles->get_header_admin($pageName);
require _DIR_ADMIN."/etc/validToAdminDash.php";
$db =new db();

$rep = new validToAdminDash();
$rep->setConn($db->getConn());
$res = $rep->getReports();

?>
<div class="page-wrapper">
    <div class="content">

        <?php
            if($res && count($res)>0):
                foreach ($res as $vall):
        ?>
        <div class="item-click">
            <article>
                <div class="brows-job-list">
                    <div class="col-md-1 col-sm-2 small-padding">
                        <div class="brows-job-company-img">
                            <a href="javascript::void(0);"><img src="<?php echo _UPLOAD_URL.'/images/'.$vall['img']; ?>" class="img-responsive" alt=""/></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-5">
                        <div class="brows-job-position">
                            <a href="javascript::void(0);"><h3><?php echo $vall['report_title']; ?></h3></a>
                            <p>
                              <?php echo $vall['report_desc']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="brows-job-location">
                            <?php
                            if($vall['org_name']!=NULL && !empty($vall['org_name'])){
                                $company = $vall['org_name'];
                            }else{
                                $company = $vall['f_name'];
                            }
                            ?>
                            <a href="#"><h3><?php echo $company; ?></h3></a>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <div class="brows-job-link">
                            <?php if($vall['user_delete']=='N'){
                               echo '<a href="#"  class="btn btn-default banne_user" data-toggle="modal"
                               data-target="#delete_organization" data-del-id="'. base64_encode($vall["uid"]).'" title="Bann">Bann</a>';
                            }else{
                                echo '<a href="#"  class="btn btn-default " data-del-id="'. base64_encode($vall["uid"]).'" title="Account is Banned">Account Banned</a>';
                            }?>
                        </div>
                    </div>
                </div>

            </article>
        </div>
        <?php endforeach;
        else:
                echo '<div class="item-click">
            <article>
                <div class="brows-job-list"> NO REPORTS FOUND </div></article></div>';

        endif; ?>

    </div>
    <div id="delete_organization" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to Banned this Organization?</h3>
                    <div class="m-t-20"><a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$configFiles->get_footer_admin();
?>
