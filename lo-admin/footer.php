<?php

 
defined("OWNER") or die("You are not allowed to access");
?>
<p class="hidden admin-url" style="display:block;"><?php echo _ADMIN_HOME; ?></p>
<p class="hidden base" style="display:block;"><?php echo _HOME; ?></p>
</div>
<div>

</div>


<div class="sidebar-overlay" data-reff=""></div>
<link href="<?php echo _HOME . '/assets/css/custom_style.css'; ?>" rel="stylesheet">
<script src="<?php echo _HOME. '/assets/js/style.js'; ?>" type="text/javascript"></script>
<script src="<?php echo _ADMIN_HOME . '/assets/js/jquery.slimscroll.js'; ?>" type="text/javascript"></script>
<?php if(isset($_SESSION['cur_page']) && $_SESSION['cur_page']=='index'):?>

<script src="<?php echo _ADMIN_HOME . '/assets/js/Chart.bundle.js'; ?>" type="text/javascript"></script>
<script src="<?php echo _ADMIN_HOME . '/assets/js/chart.js'; ?>" type="text/javascript"></script>
<?php endif; ?>
<?php if(isset($_SESSION['cur_page']) && ($_SESSION['cur_page']!=='index' && $_SESSION['cur_page']!=='add' && $_SESSION['cur_page']!='post_job')):?>
    <script src="<?php echo _ADMIN_HOME.'/assets/js/select2.min.js';?>"></script>
    <script src="<?php echo _ADMIN_HOME.'/assets/js/moment.min.js';?>"></script>
    <script src="<?php echo _ADMIN_HOME.'/assets/js/bootstrap-datetimepicker.min.js';?>"></script>
<?php endif;?>
<?php if(isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='post_job'):?>
    <script type="text/javascript" src="<?php echo _HOME . '/assets/js/ajax_js/jobs.js'; ?>"></script>

<?php endif;?>
<script src="<?php echo _ADMIN_HOME . '/assets/js/app.js'; ?>" type="text/javascript"></script>

<script src="<?php echo _HOME . '/assets/js/postjob.js'; ?>" type="text/javascript"></script>
<script src="<?php echo _ADMIN_HOME . '/assets/js/ajax/admin_ajax.js'; ?>" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/jquery.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/viewportchecker.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/bootstrap.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/bootsnav.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/select2.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/wysihtml5-0.3.0.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/bootstrap-wysihtml5.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/datedropper.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/dropzone.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/loader.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/owl.carousel.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/slick.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo _ADMIN_HOME . '/assets/plugins/js/gmap3.min.js'; ?>"></script>
<script type="text/javascript"
        src="<?php echo _ADMIN_HOME . '/assets/plugins/js/jquery.easy-autocomplete.min.js'; ?>"></script>
<?php if($_SESSION['cur_page']=='org' || $_SESSION['cur_page']=='jobseeker' || $_SESSION['cur_page']=='report' || $_SESSION['cur_page']=='bann' ):?>
<script src="<?php echo _ADMIN_HOME . '/assets/js/ajax/editProfile.js'; ?>" type="text/javascript"></script>
<?php endif;?>
<?php if($_SESSION['cur_page']=='add'):?>
    <script src="<?php echo _HOME . '/assets/js/validChecker.js'; ?>" type="text/javascript"></script>

    <script src="<?php echo _HOME . '/assets/js/ajax_js/email_checker.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/verifyEmail.js'; ?>" type="text/javascript"></script>
<?php endif;?>
</body>
</html>
