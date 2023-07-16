<?php

session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

if (isset($_SESSION['status']) && $_SESSION['status'] == 1):
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $pageName = "Contact Us " . SITE_NAME;
    $_SESSION['curPage'] = 'contactus';
    $reqFiles->get_header($pageName);
?>
    <div class="wrapper">
        <div class="clearfix"></div>
        <!-- Title Header Start -->
        <section class="inner-header-title" style="background-image:url(assets/img/banner-10.jpg);">
            <div class="container">
                <h1>Contact Page</h1>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- Title Header End -->

        <!-- Contact Page Section Start -->
        <section class="contact-page">
            <div class="container">
                <h2>Contact Information</h2>

                <div class="col-md-4 col-sm-4">
                    <div class="contact-box">
                        <i class="fa fa-map-marker"></i>
                        <p>#Street 2122, Near New Market<br>London Uk (122546)</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="contact-box">
                        <i class="fa fa-envelope"></i>
                        <p>careerdesk12@gmail.com<br>support@careerdesk.com</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="contact-box">
                        <i class="fa fa-phone"></i>
                        <p>UK: 01 123 456 7895<br>Ind: +91 123 546 8758</p>
                    </div>
                </div>

            </div>
        </section>
        <!-- contact section End -->
        <hr>
        <!-- contact form -->
        <section class="contact-form">
            <div class="container">
                <h2>Drop A Mail</h2>

                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" placeholder="Your Name">
                </div>

                <div class="col-md-6 col-sm-6">
                    <input type="email" class="form-control" placeholder="Your Email">
                </div>

                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" placeholder="Phone Number">
                </div>

                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" placeholder="Subject">
                </div>

                <div class="col-md-12 col-sm-12">
                    <textarea class="form-control" placeholder="Message"></textarea>
                </div>

                <div class="col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </section>

</div>

<?php
    $reqFiles->get_footer();
 else:
    echo 'Cannot call directly';
endif;
