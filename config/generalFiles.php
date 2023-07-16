<?php



namespace config\generalFiles;

if ($_SERVER['SCRIPT_NAME'] == '/config/generalFiles.php' || $_SERVER['REQUEST_URI'] == '/config/generalFiles.php')
    die('Direct access is not allowed');

if (!defined("OWNER")) {
    define("OWNER", "k&s");
}
if (!defined("SITE_NAME")) {
    define("SITE_NAME", "| LOOKOUT");
}
if (!defined("_HOME")) {
    // $isHTTPS = $_SERVER['HTTPS'] != NULL  ? 'https://': 'http://' ;
    define("_HOME", 'http://' . $_SERVER['HTTP_HOST']);
}
if (!defined("_ADMIN_HOME")) {
    // $isHTTPS = $_SERVER['HTTPS'] != NULL  ? 'https://': 'http://' ;
    define("_ADMIN_HOME", 'http://' . $_SERVER['HTTP_HOST'].'/lo-admin');
}
if (!defined("ADMIN_LOGIN_EMAIL")) {
    // $isHTTPS = $_SERVER['HTTPS'] != NULL  ? 'https://': 'http://' ;
    define("ADMIN_LOGIN_EMAIL", 'admin@admin.com');
}
if (!defined("_DIR")) {
    define("_DIR", $_SERVER['DOCUMENT_ROOT']);
}
if (!defined("_DIR_ADMIN")) {
    define("_DIR_ADMIN", $_SERVER['DOCUMENT_ROOT'].'/lo-admin');
}
if (!defined("_UPLOAD")) {
    define("_UPLOAD",_DIR.'/uploads/');
}
if (!defined("_UPLOAD_URL")) {
    define("_UPLOAD_URL",_HOME.'/uploads/');
}
if (!defined("PERPAGE")) {
    define("PERPAGE",10);
}
