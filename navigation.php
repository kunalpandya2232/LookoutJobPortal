<?php


defined("OWNER") or die("You are not allowed to access");
?>
<?php
if (isset($_SESSION['access']) && $_SESSION['access'] == 'USER'): ?>
    <!-- Navbar  -->
        <nav class="navbar navbar-default navbar-fixed <?php echo ($_SESSION['curPage'] == "index" || $_SESSION['curPage'] == "postnewIn"  )? 'navbar-transparent':'navbar-light';?> white bootsnav">
            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i
                            class="fa fa-bars"></i></button>
                
            <div class="navbar-header"><a class="navbar-brand" href="<?php echo isset($_SESSION['type']) && $_SESSION['type'] == 'A'? _ADMIN_HOME . '/dashboard.php':_HOME . '/index.php'; ?>">
                    <?php if($_SESSION['curPage'] == "index" || $_SESSION['curPage'] == "postnewIn"):?>
                    <img src="<?php echo _HOME . '/assets/img/logo-white.png'; ?> " class="logo logo-display" alt="">
                    <img src="<?php echo _HOME . '/assets/img/logo-white.png'; ?>" class="logo logo-scrolled"
                         alt="">
                    <?php else:?>
                        <img src="<?php echo _HOME . '/assets/img/logo.png'; ?>" class="logo logo-scrolled"
                    <?php endif;?>
                </a></div>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <?php if ($_SESSION['curPage'] == "index"): ?>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <!--                    START Dashobord-->
                        <?php
                        if (isset($_SESSION['user']) && ($_SESSION['user'] == 'new' || $_SESSION['user'] == "old")) {
                            echo '<li><a href="' . _HOME . "/dashboard/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>DASHBOARD</a></li>';
                        } else {
                            echo '<li><a href="' . _HOME . "/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>HOME</a></li>';
                        }
                        ?>


                        <li><a href="<?php echo _HOME . '/aboutUs.php'; ?>"><i class="fa fa-info"
                                                                               aria-hidden="true"></i>ABOUT US</a></li>
                        <li><a href="<?php echo _HOME . '/contactUs.php'; ?>"><i class="fa fa-phone" aria-hidden="true"></i>CONTACT US</a></li>

                        <?php if (isset($_SESSION['user'])):
                            if ($_SESSION['type'] == 'O'):
                                ?>
                                <li><a href="<?php echo _HOME . '/job/browseJob.php'; ?>"><i class="fa fa-info"
                                                                                             aria-hidden="true"></i>BROWSE JOB</a></li>
                                <li><a href="<?php echo _HOME . '/job/postjob.php'; ?>"><i class="fa fa-pencil"
                                                                                           aria-hidden="true"></i>POST
                                        JOB </a></li>

                            <?php elseif ($_SESSION['type'] == 'J'): ?>

                                <li><a href="<?php echo _HOME . '/job/browseJob.php'; ?>"><i class="fa fa-info"
                                                                                             aria-hidden="true"></i>BROWSE JOB</a></li>

                            <?php endif; ?>
                            <li><a href="<?php echo _HOME . '/logout.php' ?>"><i class="fa fa-sign-out"
                                                                                 aria-hidden="true"></i>LOGOUT</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo _HOME . '/job/browseJob.php'; ?>"><i class="fa fa-info"
                                                                                         aria-hidden="true"></i>BROWSE JOB</a></li>
                            <!--                            END Dashobord-->
                            <li><a href="<?php echo _HOME . '/login.php'; ?>"><i class="fa fa-sign-in"
                                                                                 aria-hidden="true"></i>LOGIN</a></li>
                            <li><a href="<?php echo _HOME . '/register.php'; ?>"><i class="fa fa-sign-in"
                                                                                    aria-hidden="true"></i>REGISTER</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php elseif ($_SESSION['curPage'] == 'login' || $_SESSION['curPage'] == 'register'): ?>
                    <!--            LOGIN /REGITER-->
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <li><a href="<?php echo _HOME . '/index.php'; ?>"><i class="fa fa-home" aria-hidden="true"></i>INDEX</a>
                        </li>
                        <?php if ($_SESSION['curPage'] == 'login'): ?>
                            <li><a href="<?php echo _HOME . '/register.php'; ?>"><i class="fa fa-sign-in"
                                                                                    aria-hidden="true"></i>REGISTER</a>
                            </li>
                        <?php elseif ($_SESSION['curPage'] == 'register'): ?>
                            <li><a href="<?php echo _HOME . '/login.php'; ?>"><i class="fa fa-edge "
                                                                                 aria-hidden="true"></i>LOGIN</a></li>
                        <?php endif; ?>
                    </ul>
                <?php elseif ($_SESSION['curPage'] == 'dashboard' && ($_SESSION['type'] == 'O' || $_SESSION['type'] == 'J')): ?>
                    <!--            DASHBOARD / INDEX-->
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">

                        <li><a href="<?php echo _HOME . '/dashboard/index.php'; ?>"><i class="fa fa-envelope"
                                                                                       aria-hidden="true"></i>DASHBOARD</a>
                        </li>
                        <?php if (isset($_SESSION['user'])) {
                            if (isset($_SESSION['type']) && $_SESSION['type'] == "J") {
                                echo ' <li  > <a  href = "' . _HOME . '/job/searchjob.php" >FIND JOB</a ></li >';
                            } elseif (isset($_SESSION['type']) && $_SESSION['type'] == "O") {
                                echo '<li><a href="' . _HOME . '/job/postjob.php' . '">POST JOB</a></li>';
                            }
                        } ?>
                        <li><a href="<?php echo _HOME . '/contactUs.php'; ?>">CONTACT US</a></li>
                        <li><a href="<?php echo _HOME . '/logout.php' ?>">LOGOUT</a></li>
                    </ul>

                <?php elseif ($_SESSION['curPage'] == 'browse'):?>

                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                            <?php
                            if (isset($_SESSION['user']) && ($_SESSION['user'] == 'new' || $_SESSION['user'] == "old")) {
                                echo '<li><a href="' . _HOME . "/dashboard/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>DASHBOARD</a></li>';
                            } else {
                                echo '<li><a href="' . _HOME . "/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>HOME</a></li>';
                            }
                            ?>

                            <li><a href="<?php echo _HOME . '/aboutUs.php'; ?>"><i class="fa fa-info"
                                                                                   aria-hidden="true"></i>ABOUT US</a></li>
                            <li><a href="<?php echo _HOME . '/contactUs.php'; ?>"><i class="fa fa-phone" aria-hidden="true"></i>CONTACT US</a></li>

                            <?php if (isset($_SESSION['user'])):
                                if ($_SESSION['type'] == 'O'):
                                    ?>
                                    <li><a href="<?php echo _HOME . '/job/searchjob.php'; ?>"><i class="fa fa-info"
                                                                                                 aria-hidden="true"></i>BROWSE JOB</a></li>
                                    <li><a href="<?php echo _HOME . '/job/postjob.php'; ?>"><i class="fa fa-pencil"
                                                                                               aria-hidden="true"></i>POST
                                            JOB </a></li>

                                <?php elseif ($_SESSION['type'] == 'J'): ?>
                                    <li><a href="<?php echo _HOME . '/job/searchjob.php'; ?>"><i class="fa fa-info"
                                                                                                 aria-hidden="true"></i>BROWSE JOB</a></li>
                                <li><a href="<?php echo _HOME . '/logout.php' ?>"><i class="fa fa-sign-out"
                                                                                     aria-hidden="true"></i>LOGOUT</a></li>
                                <?php endif;?>
                            <?php else: ?>
                                <li><a href="<?php echo _HOME . '/job/browseJob.php'; ?>"><i class="fa fa-info"
                                                                                             aria-hidden="true"></i>BROWSE JOB</a></li>
                                <!--                            END Dashobord-->
                                <li><a href="<?php echo _HOME . '/login.php'; ?>"><i class="fa fa-sign-in"
                                                                                     aria-hidden="true"></i>LOGIN</a></li>
                                <li><a href="<?php echo _HOME . '/register.php'; ?>"><i class="fa fa-sign-in"
                                                                                        aria-hidden="true"></i>REGISTER</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                <?php elseif ($_SESSION['curPage'] == 'forgot-pass'): ?>
                    <!--            LOGIN / FORGOT PASSWORD-->
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <!--                    START Dashobord-->
                        <?php
                        if (isset($_SESSION['user']) && ($_SESSION['user'] == 'new' || $_SESSION['user'] == "old")) {
                            echo '<li><a href="' . _HOME . "/dashboard/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>DASHBOARD</a></li>';
                        } else {
                            echo '<li><a href="' . _HOME . "/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>HOME</a></li>';
                        }
                        ?>
                        <li><a href="<?php echo _HOME . '/aboutUs.php'; ?>"><i class="fa fa-info"
                                                                               aria-hidden="true"></i>ABOUT US</a></li>
                        <li><a href="<?php echo _HOME . '/contactUs.php'; ?>"><i class="fa fa-phone" aria-hidden="true"></i>CONTACT US</a></li>

                        <?php if (isset($_SESSION['user'])):
                            if ($_SESSION['type'] == 'O'):
                                ?>
                                <li><a href="<?php echo _HOME . '/job/postjob.php'; ?>"><i class="fa fa-pencil"
                                                                                           aria-hidden="true"></i>POST
                                        JOB </a></li>

                            <?php elseif ($_SESSION['type'] == 'J'): ?>
                                <li> <a href = "<?php echo _HOME . '/job/searchjob.php'; ?>" >FIND JOB</a ></li >

                            <?php endif; ?>
                            <li><a href="<?php echo _HOME . '/logout.php' ?>"><i class="fa fa-sign-out"
                                                                                 aria-hidden="true"></i>LOGOUT</a></li>
                        <?php else: ?>
                            <!--                            END Dashobord-->
                            <li><a href="<?php echo _HOME . '/login.php'; ?>"><i class="fa fa-sign-in"
                                                                                 aria-hidden="true"></i>LOGIN</a></li>
                            <li><a href="<?php echo _HOME . '/register.php'; ?>"><i class="fa fa-sign-in"
                                                                                    aria-hidden="true"></i>REGISTER</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php elseif ($_SESSION['curPage'] == 'postnew' && ($_SESSION['type'] == 'O' || $_SESSION['type'] == 'A')): ?>
                    <!--            DASHBOARD / POST JOB-->
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <li><a href="<?php echo $_SESSION['type'] == 'O' ? _HOME . '/dashboard/index.php': _ADMIN_HOME.'/dashboard.php'; ?> ">DASHBOARD</a></li>
                        <li><a href="<?php echo _HOME . '/logout.php' ?>">LOGOUT</a></li>
                    </ul>

                <?php elseif (isset($_SESSION['user']) && ( $_SESSION['curPage'] == 'jobview')): ?>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">

                        <li  > <a  href = "<?php echo _HOME . '/dashboard/index.php';?>" >DASHBOARD</a ></li >';
                        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == "J") {
                        echo ' <li  > <a  href = "' . _HOME . '/job/searchjob.php" >FIND JOB</a ></li >';
                        } elseif (isset($_SESSION['type']) && $_SESSION['type'] == "O") {
                        echo '<li><a href="' . _HOME . '/job/postjob.php' . '">POST JOB</a></li>';
                        }?>

                        <li><a href="<?php echo _HOME . '/logout.php' ?>">LOGOUT</a></li>
                    </ul>
                <?php elseif (! isset($_SESSION['user']) && ( $_SESSION['curPage'] == 'jobview') ): ?>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <?php if(isset($_SESSION['type']) && $_SESSION['type']=="A"):?>
                            <li><a href="<?php echo _HOME . '/index.php'; ?>"><i class="fa fa-home" aria-hidden="true"></i>DASHBOARD</a></li>
                            <li><a href="<?php echo _HOME . '/logout.php' ?>">LOGOUT</a></li>

                        <?php else:?>
                        <li><a href="<?php echo _HOME . '/index.php'; ?>"><i class="fa fa-home" aria-hidden="true"></i>HOME</a></li>

                        <li><a href="<?php echo _HOME . '/aboutUs.php'; ?>"><i class="fa fa-info"
                                                                               aria-hidden="true"></i>ABOUT US</a></li>
                        <li><a href="<?php echo _HOME . '/contactUs.php'; ?>"><i class="fa fa-phone" aria-hidden="true"></i>CONTACT US</a></li>
                        <li><a href="<?php echo _HOME . '/job/browseJob.php'; ?>"><i class="fa fa-info"
                                                                                     aria-hidden="true"></i>BROWSE JOB</a></li>
                        <li><a href="<?php echo _HOME . '/login.php'; ?>"><i class="fa fa-edge "
                                                                             aria-hidden="true"></i>LOGIN</a></li>
                        <li><a href="<?php echo _HOME . '/register.php'; ?>"><i class="fa fa-sign-in"
                                                                                aria-hidden="true"></i>REGISTER</a>
                        </li>
                        <?php endif;?>
                    </ul>

                <?php endif;
                if ($_SESSION['curPage'] == 'contactus' || $_SESSION['curPage'] == 'aboutus'): ?>
<!--                    CONTACT US AND ABOUT US-->
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user'] == 'new' || $_SESSION['user'] == "old")) {
                        echo '<li><a href="' . _HOME . "/dashboard/index.php" . '"><i class="fa fa-home" aria-hidden="true"></i>DASHBOARD</a></li>';
                        }
                        ?>
                        <li><a href="<?php echo _HOME . '/index.php'; ?>">HOME</a></li>
                        <?php if ($_SESSION['curPage'] == 'contactus'): ?>
                            <li><a href="<?php echo _HOME . '/aboutUs.php'; ?>">ABOUT US</a></li>
                        <?php elseif ($_SESSION['curPage'] == 'aboutus'): ?>

                            <li><a href="<?php echo _HOME . '/contactUs.php'; ?>">CONTACTUS</a></li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user'])):
                            if ($_SESSION['type'] == 'O'):
                                ?>
                                <li><a href="<?php echo _HOME . '/job/postjob.php'; ?>">POST JOB</a></li>
                            <?php elseif ($_SESSION['type'] == 'J'): ?>
                                <li> <a href = "<?php echo _HOME . '/job/searchjob.php'; ?>" >FIND JOB</a ></li >
                            <?php endif; ?>
                            <li><a class="nav-link text-white" href="<?php echo _HOME . '/logout.php' ?>">LOGOUT</a>
                            </li>
                        <?php else: ?>
                            <li><a href="<?php echo _HOME . '/register.php'; ?>">REGISTER</a></li>
                            <li><a href="<?php echo _HOME . '/login.php'; ?>">LOGIN</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->
<?php endif; ?>
