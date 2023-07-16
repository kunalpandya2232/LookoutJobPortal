<?php
/**
 * Created by PhpStorm.
 * User: Shyam PC
 * Date: 3/27/2022
 * Time: 11:17 AM
 */

session_start();
require '../../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

class getUsersList
{
    private $getUser_sql = "SELECT u.id as 'uid', u.user_fname as 'fname',u.*, pu.* FROM lo_tblusers as u  INNER JOIN lo_tblprofileuser as pu ON u.id = pu.user_id INNER JOIN lo_tblotp as otp ON u.user_email = otp.user_email WHERE u.is_deleted='N' AND otp.is_verify='1' AND otp.verify_status='1' ";
    private $conn       = "";
    private $totalRec   ="";
    public  $status     = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }
    public function getUserFunc($sortlist){
        $ret = false;
        $condition = " AND u.user_type='".$sortlist['type_user']."' ";
        if (!empty($sortlist)) {
            if (isset($sortlist['location']) && $sortlist['location'] != '') {
                $condition .= " AND (u.user_city LIKE '%" . $sortlist['location'] . "%' OR u.user_country LIKE '%" . $sortlist['location'] . "%' OR u.user_state LIKE '%" . $sortlist['location'] . "%')";
            }
            if($sortlist['sort']=='date'){
                $orderBy = "u.date_created";
            }elseif ($sortlist['sort']=='name'){
                $orderBy = 'u.user_fname';
            }
            $condition .= " ORDER BY ".$orderBy." ASC";
        }
        $this->totalRec = $this->getTotalRecordsRow($condition);
        if (!empty($sortlist)) {
            if (isset($sortlist['limit'] )&& $sortlist['limit'] != '') {
                $offset = PERPAGE;
                $limit = $sortlist['limit'];
                $limit = ((intval($limit) - 1) * $offset);
                $condition .= ' LIMIT ' . $limit . ', '. $offset;
            }
        }
        $this->getUser_sql = $this->getUser_sql.$condition;
        try {
            $stmt = $this->conn->prepare($this->getUser_sql);
            $stmt->execute();
            $res          = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = $res;
        } catch (PDOException $e) {
            $this->status = "ERROR on getting job";
            $ret          = $e;
        }
        return $ret;
    }
    private function getTotalRecordsRow($condition){
        try {
            $stmt = $this->conn->prepare($this->getUser_sql.$condition);
            $stmt->execute();
            $res          = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = count($res);
        } catch (PDOException $e) {
            $this->status = "ERROR on getting userList";
            $ret          = $e;
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function getGetUserSql(): string
    {
        return $this->getUser_sql;
    }

    /**
     * @return string
     */
    public function getTotalRec(): string
    {
        return $this->totalRec;
    }
}

if($_POST){
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $dbClass = new db();
    $validchecker= new validChecker();
    $data = $validchecker->cleanData($_POST);
    // clean and check again
    $userList   = new getUsersList();
    $userList->setConn($dbClass->getConn());
    $res = $userList->getUserFunc($data);
    $output = '';
    if(is_array($res)) {
        if(count($res)>0) {
            foreach ($res as $user) {
//                for company name else user name
                if ($user['user_type'] == "O") {
                    if ($user['org_name'] == "NULL" || $user['org_name'] == NULL) {
                        $company = $user['user_fname'];
                    } else {
                        $company = $user['org_name'];
                    }
                } else {
                    $company = "LOOKOUT";
                }
//                for location
                if ($user['user_type'] == "O") {
                    if (!empty($user['user_state']) && !empty($user['user_country'])) {
                        $location = $user['user_state'] . ', ' . $user['user_country'];
                    } else if (!empty($user['user_state'])) {
                        $location = $user['user_state'];
                    } else {
                        $location = '';
                    }
                } else {
//                ADMIN ADDRESS
                    $location = 'GUJARAT, INDIA';
                }
                if (!isset($user['profile_userName'])) {
                    $user['profile_userName'] = "USER";
                }
                //for date jobs
                $datepost  = date_create(date("Y-m-d H:i:s", strtotime($user['date_created'])));
                $today     = date_create(date("Y-m-d H:i:s"));
                $date_diff = date_diff($datepost, $today);
                if ($date_diff->y < 1) {
                    if ($date_diff->m < 1) {
                        if ($date_diff->d < 1) {
                            $datepost = "New";
                        } else {
                            $datepost = $date_diff->d . ' days ago';
                        }
                    } else {
                        $datepost = $date_diff->m . ' months ago';
                    }
                } else {
                    $datepost = $date_diff->y . ' years ago';

                }
                if ($_POST['type_user'] == 'O') {
                    $output .= '<div class="col-md-12">
                <article>
                    <div class="mng-company">
                        <div class="col-md-2 col-sm-2">
                            <div class="mng-company-pic">
                                <img src="' . _HOME . "/uploads/images/" . $user["user_photo"] . '" class="img-responsive" alt="organization-image"/>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="mng-company-name">
                                <h4>' . $company . ' </h4>
                                <span class="cmp-time">' . $datepost . '</span>
                            </div>
                        </div>';
                    if ($location != NULL) {
                        $output .= '<div class="col-md-4 col-sm-4">
                            <div class="mng-company-location">
                                <p><i class="fa fa-map-marker"></i> ' . $location . '</p>
                            </div>
                        </div>';
                    } else {
                        $output .= '<div class="col-md-4 col-sm-4">
</div>';
                    }
                    $output .= '<div class="col-md-1 col-sm-1">
                            <div class="mng-company-action">
                                <a href="#" class="edit_user" data-edit-id="'.base64_encode($user["uid"]).'" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="#"  class="banne_user" data-toggle="modal" data-target="#delete_organization" data-del-id="'.base64_encode($user["uid"]).'"  title="Baaned Account"><i
                                            class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

            </div>';
                } else {
                    $output .=' <div class="col-md-4 col-sm-6">
                <div class="jn-employee">
                    <div class="pull-right">
                        <div class="btn-group action-btn">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">

                                <li> <a href="#" class="edit_user" data-edit-id="'.base64_encode($user["uid"]).'" title="Edit">Edit</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#delete_organization" data-del-id="'.base64_encode($user["uid"]).'" class="banne_user" title="Baaned Account">Baaned Account</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="employee-caption">
                        <div class="employee-caption-pic">
                            <img src="' . _HOME . "/uploads/images/" . $user["user_photo"] . '" class="img-responsive" alt=""/>
                        </div>
                        <h5>'.$user['user_fname'].' '.$user["user_lname"].'</h5>
                        <span class="designation">'.$user["jobS_occupation"].'</span>

                    </div>
                </div>
            </div>';
                }

            }

        }else{
            $output .='<article>
                    <div class="mng-company">  
                        <div class="col-md-12 col-sm-12 text-center">NOT DATA FOUND</div></article>';
        }
            $offset = PERPAGE;
            $page   = ceil($userList->getTotalRec() / $offset);
            $button = '';

            for ($i = 1; $i <= $page; $i++) {
                $active = ($data['limit'] ==$i)?'active':'';
                $button .= '<li class="paginate_button page-item '.$active.'"><a class="pagingdat page-link" data-page="' . $i . '">' . $i . '</a></li>';
            }


        $retData = [
            'result' => true,
            'res'    => $output,
            'pagbut' => $button,
        ];
    }else{
        $retData =[
            'result'=>false,
            'res'=>$res
        ];
    }

    echo json_encode($retData);
}
