<?php

session_start();

require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles = new settings();
$reqFiles->get_required_files();
if (isset($_SESSION['user'])):
$pageName            = "Find Job " . SITE_NAME;
$_SESSION['curPage'] = 'dashboard';
$reqFiles->get_header($pageName);
?>
<div class="wrapper">

    <div class="clearfix"></div>

    <!-- Title Header Start -->
    <section class="inner-header-title" style="background-image:url(<?php echo _HOME.'/assets/img/banner-10.jpg'; ?>);">
        <div class="container">
            <h1>Find Jobs</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <p class="hiddenUrl base"><?php echo _HOME; ?></p>
    <section class="brows-job-category">
        <div class="container">
            <!-- Company Searrch Filter End -->
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
            <div class="row getJobs">
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
    <?php
    $reqFiles->get_footer();
    endif;
    ?>
