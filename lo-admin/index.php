<?php


session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
$configFiles = new settings();
$configFiles->get_required_files();
header("location: ". _ADMIN_HOME.'/dashboard.php');
