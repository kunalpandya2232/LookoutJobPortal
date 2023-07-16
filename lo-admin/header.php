<?php


?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <meta charset="utf-8">

    <title><?php echo $pageName; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo _HOME . '/assets/logos/head.png'; ?>" sizes="70">
    <link rel="stylesheet" type="text/css" href="<?php echo _ADMIN_HOME.'/assets/css/bootstrap.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo _ADMIN_HOME.'/assets/css/font-awesome.min.css';?>">
    <link href="<?php echo _HOME . '/assets/css/jquery-ui.min.css'; ?>" rel="stylesheet">


    <?php if($_SESSION['cur_page']!='add'):?>
        <?php
        if(isset($_SESSION['cur_page']) && $_SESSION['cur_page']!=='index' ):    ?>
            <link rel="stylesheet" type="text/css" href="<?php echo _ADMIN_HOME .'/assets/css/select2.min.css';?>">
            <link rel="stylesheet" type="text/css" href="<?php echo _ADMIN_HOME .'/assets/css/bootstrap-datetimepicker.min.css';?>">
        <?php endif;?>

        <link rel="stylesheet" type="text/css" href="<?php echo _ADMIN_HOME.'/assets/css/style.css';?>">
        <link rel="stylesheet" type="text/css" href="<?php echo  _HOME.'/assets/css/style.css';?>">

    <?php else:?>
        <link rel="stylesheet" type="text/css" href="<?php echo  _HOME.'/assets/css/style.css';?>">
        <link href="<?php echo _HOME . '/assets/css/colors/green-style.css'; ?>" type="text/css" rel="stylesheet" id="jssDefault">

    <?php endif;?>
    <link rel="stylesheet" href="<?php echo _ADMIN_HOME.'/assets/plugins/css/plugins.css';?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="<?php echo _HOME . "/assets/plugins/js/jquery.min.js"; ?> " type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/jquery-ui.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _ADMIN_HOME . '/assets/js/popper.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _ADMIN_HOME . '/assets/js/bootstrap.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/country-states.js'; ?>" type="text/javascript"></script>

</head>
<body>
<div class="main-wrapper">
    <?php
    if(isset($_SESSION['admin_login'])&& $_SESSION['admin_login'] && $_SESSION['cur_page']!='add'){
        include _DIR_ADMIN."/navigation.php";
    }
    ?>
