<?php


session_start();
require "config/generalFiles.php";
//require "config/dbFiles.php";
$_SESSION['access']  = isset($_SESSION['access']) ? $_SESSION['access'] : 'USER';

$_SESSION['curPage'] = "index";
require "header.php";
$data=true;
require "footer.php";
