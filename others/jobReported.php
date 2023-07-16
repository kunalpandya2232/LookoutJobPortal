<?php

/**
 * Author: Shyam PC
 * Project: Clg_project
 * Date: 4/3/2022
 */
session_start();
require "../config/settingsFiles.php";
use config\settingsFiles\settingsFiles as settings;
$reqFiles = new settings();
$reqFiles->get_required_files();

$pageName = "THANKYOU PAGE" . SITE_NAME;
$_SESSION['curPage'] = 'postnewIn';
$reqFiles->get_header($pageName);

?>

<div class="wrapper">

    <div class="clearfix"></div>

    <!-- Header Title Start -->
    <section class="inner-header-title blank">
        <div class="container">
            <h1>THANK YOU</h1>
            <h3>Job is Reported </h3>
        </div>
    </section>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12">
        <a href="<?php echo _HOME.'/dashboard/index.php'?>" class="btn btn-success btn-primary small-btn">Go To Dashboard</a>
    </div>

</div>
</body>
</html>
