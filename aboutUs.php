<?php


session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

if (isset($_SESSION['status']) && $_SESSION['status'] == 1):
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $pageName = "About Us " . SITE_NAME;
    $_SESSION['curPage'] = 'aboutus';
    $reqFiles->get_header($pageName);
    ?>
    
    <div class="Loader"></div>
<div class="wrapper">
 

    <div class="clearfix"></div>
    <section class="slide-banner scroll-con-sec hero-section" data-scrollax-parent="true" id="sec1">
        <div class="slideshow-container">
            <div class="slideshow-item">
                <div class="bg" data-bg="assets/img/banner-3.jpg"></div>
            </div>
            <div class="slideshow-item">
                <div class="bg" data-bg="assets/img/banner-6.jpg"></div>
            </div>
            <div class="slideshow-item">
                <div class="bg" data-bg="assets/img/banner-5.jpg"></div>
            </div>
            <div class="slideshow-item">
                <div class="bg" data-bg="assets/img/banner-2.jpg"></div>
            </div>
        </div>
        <div class="overlay"></div>
        <div class="hero-section-wrap fl-wrap">
            <div class="container">
                <div class="intro-item fl-wrap">
                    <div class="caption text-center cl-white">
                        <h2>About Us</h2>

               
                    </div>

                
                </div>
            </div>
        </div>
    </section>

 <section class="gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="main-heading">
                        

                        <h2>Developers of <span> Lookout</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="paid-candidate-container">
                        <div class="paid-candidate-box">
                           
                            <div class="paid-candidate-inner--box">
                                <div class="paid-candidate-box-thumb"><img src="assets/img/client-1.jpg"
                                                                           class="img-responsive img-circle" alt=""/>
                                </div>
                                <div class="paid-candidate-box-detail">
                                    <h4>Kunal Pandya</h4>
                                    <span class="desination">Web Developer</span>
                                </div>
                            </div>
                            <div class="paid-candidate-box-extra">
                                <ul>
                                    <li>Cyber Security Expert</li>
                                    
                                </ul>
                                <p>Kunal Pandya is Good Designer, he is Also a Brave Team Leader who can Work under the pressure</p>
                            </div>
                        </div>
                  
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="paid-candidate-container">
                        <div class="paid-candidate-box">
                            
                            <div class="paid-candidate-inner--box">
                                <div class="paid-candidate-box-thumb"><img src="assets/img/client-4.jpg"
                                                                           class="img-responsive img-circle" alt=""/>
                                </div>
                                <div class="paid-candidate-box-detail">
                                    <h4>Shyam Adesara</h4>
                                    <span class="desination">Web Developer</span>
                                </div>
                            </div>
                            <div class="paid-candidate-box-extra">
                                <ul>
                                    <li>Php Developer</li>
                                    
                                </ul>
                                <p>Shyam Adesara is Good Developer & he is Experienced person who can handle any kind of Problems.</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
               
               
            </div>
        </div>
    </section>


    <div class="clearfix"></div>
    <section class="first-feature">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="main-heading">
                        

                        <h2>Our <span> Categories</span></h2>
                    </div>
                </div>
            </div>
            <div class="all-features">
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-desktop"></i></div>
                        <div class="feature-caption">
                            <h5>Web Developer</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-mobile"></i></div>
                        <div class="feature-caption">
                            <h5>Mobile Developer</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-lightbulb-o"></i></div>
                        <div class="feature-caption">
                            <h5>Creative Designer</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-file-text"></i></div>
                        <div class="feature-caption">
                            <h5>Content Writer</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-hdd-o"></i></div>
                        <div class="feature-caption">
                            <h5>Manager</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-bullhorn"></i></div>
                        <div class="feature-caption">
                            <h5>Sales & Marketing</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-credit-card"></i></div>
                        <div class="feature-caption">
                            <h5>Accountant</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 small-padding">
                    <div class="job-feature">
                        <div class="feature-icon"><i class="fa fa-user"></i></div>
                        <div class="feature-caption">
                            <h5>Management / HR</h5>

                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <section class="wp-process home-three">
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <p>How We Work</p>

                    <h2>Our Work <span>Process</span></h2>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-search"></span></div>
                    <div class="work-process-caption">
                        <h4>Search Job</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-mobile"></span></div>
                    <div class="work-process-caption">
                        <h4>Find Job</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-profile-male"></span></div>
                    <div class="work-process-caption">
                        <h4>Hire Employee</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-sm"><img src="assets/img/wp-iphone.png" class="img-responsive" alt=""/></div>
            <div class="col-md-4 col-sm-6">
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-layers"></span></div>
                    <div class="work-process-caption">
                        <h4>Start Work</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-wallet"></span></div>
                    <div class="work-process-caption">
                        <h4>Pay Money</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
                <div class="work-process">
                    <div class="work-process-icon"><span class="icon-happy"></span></div>
                    <div class="work-process-caption">
                        <h4>Happy</h4>

                        <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                            posuere lacus</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    <script type="text/javascript" src="assets/plugins/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/viewportchecker.js"></script>
    <script type="text/javascript" src="assets/plugins/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/bootsnav.js"></script>
    <script type="text/javascript" src="assets/plugins/js/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="assets/plugins/js/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="assets/plugins/js/datedropper.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/dropzone.js"></script>
    <script type="text/javascript" src="assets/plugins/js/loader.js"></script>
    <script type="text/javascript" src="assets/plugins/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/slick.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/gmap3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/jquery.easy-autocomplete.min.js"></script>
    <script src="assets/js/custom.js"></script>



    <?php
    $reqFiles->get_footer();
else:
    echo 'Cannot call directly';
endif;


