<?php


?>
</div>
<?php if (isset($data) && $data) { ?>
    <footer class="footer">
    <div class="clearfix"></div>
    
        <div class="row lg-menu">
            <div class="container">
                <div class="col-md-4 col-sm-4"><img src="assets/img/footer-logo.png" class="img-responsive" alt=""/>
                </div>
                <div class="col-md-8 co-sm-8 pull-right">
                    <ul>
                        <li><a href="index-2.html" title="">Home</a></li>
                        <li><a href="blog.html" title="">About us</a></li>
                        <li><a href="404.html" title="">Contact us</a></li>
                        <li><a href="faq.html" title="">Brows Job</a></li>
                        <li><a href="contact.html" title="">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row no-padding">
            <div class="container">
                <div class="col-md-3 col-sm-12">
                    <div class="footer-widget">
                        <h3 class="widgettitle widget-title">About Job Stock</h3>

                        <div class="textwidget">
                            <p>Lookout is a jobportal, to getiting & Giving job</p>

                            <p>C.U.Shah Ashram Road, Income tax office - 382480</p>

                            <p><strong>Email:</strong> lookoputjobportal@gmail.com</p>
 
                            <p><strong>Call:</strong> <a href="tel:+15555555555">555-555-1234</a></p>
                            <ul class="footer-social">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <h3 class="widgettitle widget-title">All Navigation</h3>

                        <div class="textwidget">
                            <div class="textwidget">
                                <ul class="footer-navigation">
                                    <li><a href="#" title="">Front-end Design</a></li>
                                    <li><a href="#" title="">Android Developer</a></li>
                                    <li><a href="#" title="">CMS Development</a></li>
                                    <li><a href="#" title="">PHP Development</a></li>
                                    <li><a href="#" title="">IOS Developer</a></li>
                                    <li><a href="#" title="">Iphone Developer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <h3 class="widgettitle widget-title">All Categories</h3>

                        <div class="textwidget">
                            <ul class="footer-navigation">
                                <li><a href="#" title="">Front-end Design</a></li>
                                <li><a href="#" title="">Android Developer</a></li>
                                <li><a href="#" title="">CMS Development</a></li>
                                <li><a href="#" title="">PHP Development</a></li>
                                <li><a href="#" title="">IOS Developer</a></li>
                                <li><a href="#" title="">Iphone Developer</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <h3 class="widgettitle widget-title">Connect Us</h3>

                        <div class="textwidget">
                            <form class="footer-form"><input type="text" class="form-control" placeholder="Your Name">
                                <input type="text" class="form-control" placeholder="Email"><textarea
                                        class="form-control" placeholder="Message"></textarea>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </footer>
    <div class="clearfix"></div>

<?php } ?>


<!-- Scripts==================================================-->
<script src="<?php echo _HOME . '/assets/js/style.js'; ?>" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/viewportchecker.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/bootsnav.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/select2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/wysihtml5-0.3.0.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/bootstrap-wysihtml5.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/datedropper.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/dropzone.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/loader.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/owl.carousel.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/slick.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/gmap3.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo _HOME . "/assets/plugins/js/jquery.easy-autocomplete.min.js"; ?>"></script>
<script src="<?php echo _HOME . '/assets/js/validChecker.js'; ?>" type="text/javascript"></script>

<?php if ((isset($_SESSION['access']) && $_SESSION['access'] == 'USER') && $_SESSION['curPage'] == "jobview" ): ?>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/comment.js'; ?>" type="text/javascript"></script>

<?php elseif ((isset($_SESSION['access']) && $_SESSION['access'] == 'USER') && ($_SESSION['curPage'] == "register" || $_SESSION['curPage'] == "login"||$_SESSION['curPage'] == "forgot-pass")): ?>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/email_checker.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/verifyEmail.js'; ?>" type="text/javascript"></script>

<?php elseif (isset($_SESSION['access']) && $_SESSION['access'] == 'USER' && ($_SESSION['curPage'] == "postnew")) : ?>
    <script src="<?php echo _HOME . '/assets/js/postjob.js'; ?>" type="text/javascript"></script>

<?php elseif (isset($_SESSION['access']) && $_SESSION['access'] == 'USER' && ($_SESSION['curPage'] == "dashboard")) : ?>
    <script src="<?php echo _HOME . '/assets/js/postjob.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/editProfile.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/ajax_js/verifyPass.js'; ?>" type="text/javascript"></script>

<?php endif; ?>
<script src="<?php echo _HOME . '/assets/js/ajax_js/jobs.js'; ?>" type="text/javascript"></script>
<script src="<?php echo _HOME . '/assets/js/jQuery.style.switcher.js'; ?>" type="text/javascript"></script>

<script type="text/javascript">$(document).ready(function () {
        $('#styleOptions').styleSwitcher();
    });</script>
<script>function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }</script>
<link href="<?php echo _HOME . '/assets/css/custom_style.css'; ?>" rel="stylesheet">

</body>
</html>
