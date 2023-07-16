<?php



session_start();
require '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class getCategories
{
    private $cat               = "";
    private $conn              = "";
    private $getCategories_sql = "SELECT category_name as 'name', category_subname as 'sub_name' FROM lo_tblcategory order by category_name ASC";
    public  $status            = "";

    public function getCategoryFunc()
    {
        $this->category();
        if ($this->status == true) {
            $this->sortCat();
        }
        return true;
    }

    /**
     * @param string $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    private function category()
    {
        try {
            $stmt = $this->conn->prepare($this->getCategories_sql);
            $stmt->execute();
            $res          = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->cat    = count($res) > 0 ? $res : [];
            $this->status = true;
        } catch (PDOException $e) {
            $this->status = "Something Wrong in Category...";
        }
    }

    public function sortCat()
    {
        $temp = [];
        $a    = '';
        if (count($this->cat) > 0) {
            $mname   = array_column($this->cat, 'name');
            $subname = array_column($this->cat, 'sub_name');
            foreach ($this->cat as $x => $value) {
                $temp[$mname[$x]][] = $subname[$x];
            }
            $this->cat = $temp;
        }
    }

    public function getCat()
    {
        return $this->cat;
    }
}

if (isset($_POST) && empty($_POST)) {
    $retData  = [];
    $err      = '';
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $dbClass = new db();
    $getCat  = new getCategories();
    $getCat->setConn($dbClass->getConn());
    $res = $getCat->getCategoryFunc();
    if ($res) {
        $retData = ['result' => 'success', 'categories' => $getCat->getCat()];
    } else {
        $retData = ['result' => 'fail', 'error' => $getCat->status];
    }
}
echo json_encode($retData);
