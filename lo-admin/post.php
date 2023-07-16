<?php

session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
$configFiles = new settings();
$configFiles->get_required_files();
$_SESSION['cur_page'] = 'post_job';
$pageName             = "Manage Post" . SITE_NAME;
$configFiles->get_header_admin($pageName);
?>
<div class="page-wrapper">
    <p class="hiddenUrl base"><?php echo _HOME; ?></p>

    <div class="content">


        <section class="brows-job-category">
            <div class="container">
                <!-- Company Searrch Filter End -->
                
                <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Post Jobs</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
            <a href="<?php echo _HOME.'/job/postjob.php';?>" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i>
                        Add Post</a>
            </div>
        </div>
                <div class="row extra-mrg">
                    <div class="wrap-search-filter">
                        <form class="paging" id="paging" action="" method="">
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
                <div class="getJobs">
                </div>
                <!-- Company Searrch Filter End -->
                <!--row-->
                <div class="row">
                    <ul class="pagination">

                    </ul>
                </div>
                <!-- /.row-->
            </div>
        </section>


    </div>
    <div id="delete_job" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Job?</h3>
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
