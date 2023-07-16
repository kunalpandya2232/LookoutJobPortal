<?php


$pageName = isset($pageName) ? $pageName : "Welcome Page" . SITE_NAME;

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <title><?php echo $pageName; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo _HOME . '/assets/logos/head.png'; ?>" sizes="70">
    <?php if ($_SESSION['curPage'] != "register" ): ?>
        <link href="<?php echo _HOME . '/assets/plugins/css/plugins.css'; ?> " rel="stylesheet">
        <link href="<?php echo _HOME . '/assets/css/style.css'; ?> " rel="stylesheet">

        <link href="<?php echo _HOME . '/assets/css/colors/green-style.css'; ?>" type="text/css" rel="stylesheet" id="jssDefault">
    <?php else: ?>
        <link href="<?php echo _HOME . '/assets/bootstrap/b_css/bootstrap.css'; ?>" rel="stylesheet">
        <link href="<?php echo _HOME . '/assets/css/register.css'; ?>" rel="stylesheet">
    <?php endif; ?>
    <?php if(isset($_SESSION['user']) && $_SESSION['curPage']=='jobview'):?>
        <link href="<?php echo _ADMIN_HOME . '/assets/css/style.css'; ?> " rel="stylesheet">
    <?php endif;?>
    <link href="<?php echo _HOME . '/assets/css/jquery-ui.min.css'; ?>" rel="stylesheet">
    <!--        All script-->
    <script src="<?php echo _HOME . "/assets/plugins/js/jquery.min.js"; ?> " type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/jquery-ui.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/jquery.validate.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo _HOME . '/assets/js/additional-methods.js'; ?>" type="text/javascript"></script>
    <?php if ($_SESSION['curPage'] == "register"): ?>
        <script src="<?php echo _HOME . '/assets/bootstrap/b_js/bootstrap.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo _HOME . '/assets/bootstrap/b_js/bootstrap.bundle.min.js'; ?>"
                type="text/javascript"></script>
    <?php elseif (isset($_SESSION['access']) && $_SESSION['access'] == 'USER' && ($_SESSION['curPage'] == "dashboard")) : ?>
        <script src="<?php echo _HOME . '/assets/js/country-states.js'; ?>" type="text/javascript"></script>

    <?php endif; ?>
    <?php $bodyImageArray = [
        'login'    => 'class="simple-bg-screen" style="background-image:url(assets/img/banner-10.jpg);"',
        'register' => 'class="simple-bg-screen" style="background-image:url(assets/img/banner-10.jpg);"',
    ];
    $isBodyIamge          = '';
    if (in_array($_SESSION['curPage'], array_keys($bodyImageArray))) {
        $isBodyIamge = $bodyImageArray[$_SESSION['curPage']];
    }
    ?>
</head>
<body <?php echo $isBodyIamge; ?> >

<div class="Loader"></div>

<?php
if (($_SESSION['curPage'] != "register" && $_SESSION['curPage'] != "login")&&$nav="black") {
    include "navigation.php";
}
?>
<?php if (isset($_SESSION['access']) && (isset($_SESSION['curPage']) && $_SESSION['curPage'] == "index")): ?>
<div class="wrapper">
    <?php include "welcome.php";
    endif; ?>
