<?php



?>
<div class="header">
			<div class="header-left">
				<a href="<?php echo _ADMIN_HOME.'/dashboard.php'; ?>" class="logo">
					<img src="<?php echo _ADMIN_HOME .'/assets/img/logo.png'; ?>" width="35" height="35" alt=""> <span>Lookout</span>
				</a>
			</div>
			<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">

                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src="<?php echo _ADMIN_HOME .'/assets/img/user.jpg'; ?>" width="24" alt="Admin">
							<span class="status online"></span>
						</span>
						<span>Admin</span>
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?php echo _ADMIN_HOME .'/profile.php';?>">My Profile</a>
						<a class="dropdown-item" href="<?php echo _ADMIN_HOME .'/edit-profile.php';?>">Edit Profile</a>
						<a class="dropdown-item" href="<?php echo _HOME .'/logout.php';?>">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?php echo _ADMIN_HOME .'/profile.php';?>">My Profile</a>
                    <a class="dropdown-item" href="<?php echo _ADMIN_HOME .'/edit-profile.php';?>">Edit Profile</a>
                    <a class="dropdown-item" href="<?php echo _HOME .'/logout.php';?>">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='index'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME .'/dashboard.php';?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
						<li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='org'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME .'/organization.php';?>"><i class="fa fa-building"></i> <span>Organization</span></a>
                        </li>
                        <li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='jobseeker'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME .'/jobseeker.php';?>"><i class="fa fa-user"></i> <span>Jobseeker</span></a>
                        </li>
                        <li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='post_job'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME .'/post.php';?>"><i class="fa fa-calendar"></i> <span>Post</span></a>
                        </li>
                        <li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='report'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME .'/report.php';?>"><i class="fa fa-flag"></i> <span>Reports</span></a>
                        </li>
                        <li class="<?php echo isset($_SESSION['cur_page'])&&$_SESSION['cur_page']=='bann'?'active':''; ?>">
                            <a href="<?php echo _ADMIN_HOME.'/baanedAccount.php';?>"><i class="fa fa-ban"></i> <span>Banned Accounts</span></a>
                        </li>
						<li >
                            <a href="<?php echo _HOME.'/logout.php';?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
