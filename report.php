<?php session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles = new settings();
$reqFiles->get_required_files();
$pageName            = "Report Page " . SITE_NAME;
$_SESSION['access']  = isset($_SESSION['access']) ? $_SESSION['access'] : 'USER';
$_SESSION['curPage'] = 'dashboard';
$reqFiles->get_header($pageName);

if ($_GET && isset($_SESSION['report_uid']) && $_GET['id'] && ($_GET['id'] == $_SESSION['report_uid'])) {
    $jid = $_GET['id'];
} elseif (isset($_SESSION['report_uid'])) {
    $jid = $_SESSION['report_uid'];
} else {
    $jid = '';
}
if ($_POST) {
    $reqFiles->get_valid_checker();
    $valid         = new validChecker();
    $noremoveSpace = ['title' => $_POST['title'], 'desc' => $_POST['desc']];
    $_POST         = $valid->cleanData($_POST, $noremoveSpace);
    $db   = new db();
    $conn = $db->getConn();
    $uid           = $valid->getUserByEmail($conn,$_SESSION['email']);

    require _DIR . '/etc/checker/validToReport.php';

    $vtr = new validToReport();
    $vtr->setConn($conn);
    $jid = base64_decode($jid);

    $res = $vtr->reportFunc($_POST, $uid['Id'], $jid);
    if ($res && $vtr->status) {
        header("location: " . _HOME . '/others/jobReported.php');
    }
}

?>
    <section class="inner-header-title blank">
        <div class="container">
            <h1>Report</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <div class="detail-desc section">
        <div class="container white-shadow">

            <br>
            <div class="row bottom-mrg">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?id=' . $jid; ?>" method="post"
                      class="add-feild" id="report_form">
                    <div class="col-md-12 col-sm-6">
                        <div class="input-group">
                            <select class="form-control input-lg" name="title" required>
                                <option>Spam</option>
                                <option>Misleading Information</option>
                                <option>Sexual Content</option>
                                <option>Violance Content</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <textarea id="demo" class="form-control" placeholder="Report Description" name="desc"
                                  required></textarea>
                        <span id="s1" style="color:red;"></span>
                    </div>

                    <div class="col-md-6 col-sm-3">
                        <button type="submit" class="update-btn">Report</button>
                    </div>
                    <div class="col-md-6 col-sm-3">
                        <button type="reset" class="update-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
$reqFiles->get_footer(false);
