<?php


session_start();
require_once '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;


class appliedJoblist
{
    private $getProvided_sql = "SELECT app.id as 'appl_id', app.job as 'appl_job_id', app.*, jobs.*, user.*,pu.* FROM lo_tblapplier as app INNER JOIN lo_tbljobs as jobs ON jobs.id = app.job INNER JOIN lo_tblusers as user ON user.id = jobs.user_id INNER JOIN lo_tblprofileuser as pu ON pu.user_id = user.id WHERE app.user_id =? AND jobs.is_deleted ='N' AND user.is_deleted ='N' ";
    private $conn            = "";
    private $totalRec        = "";
    public  $status          = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getappliedJob($id,$limit)
    {
        $ret = false;

        if (!empty($id) && $id != '') {
            $sql =" AND app.apply='0' AND app.is_delete =\"N\" GROUP BY app.job ORDER BY jobs.job_title";

            if (!empty($limit)) {
                $this->totalRec = $this->getTotalRecordsRow($sql,$id);
                if ($limit != '') {
                    $offset    = PERPAGE;
                    $limit     = ((intval($limit) - 1) * $offset);
                    $sql .= ' LIMIT ' . $limit . ', ' . $offset;
                }
            }
            try {
                $stmt = $this->conn->prepare($this->getProvided_sql.$sql);
                $stmt->execute([$id]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->status = true;
                if(count($res)>0){
                    $ret = $res;
                }else{
                    $ret = false;
                }

            } catch (PDOException $e) {
                $this->status = false;
            }
        }
        return $ret;
    }

    private function getTotalRecordsRow($condition, $id)
    {
        try {
            $stmt = $this->conn->prepare($this->getProvided_sql . $condition);
            $stmt->execute([$id]);
            $res          = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = count($res);
        } catch (PDOException $e) {
            $this->status = "ERROR on getting job";
            $ret          = $e->getCode();
        }
        return $ret;
    }

    public function getTotalRec()
    {
        return $this->totalRec;
    }

}


if ($_POST ) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $dbconn  = new db();
    $conn    = $dbconn->getConn();
    $checker = new validChecker();
    $id = $checker->cleanData($_POST['id']);
    if (!empty($id)) {

        $job = new appliedJoblist();
        $job->setConn($conn);
        $jobList = $job->getappliedJob($id,$_POST['limit']);
        $output ='';
        if ($jobList && $job->status) {
            foreach ($jobList as $jobs) {
                //for job type
                if ($jobs['job_hours'] == 1) {
                    $jobs['job_hours'] = 'Full Time';
                } elseif ($jobs['job_hours'] == 2) {
                    $jobs['job_hours'] = 'Part Time';
                } elseif ($jobs['job_hours'] == 0) {
                    $jobs['job_hours'] = 'Flexible Time';
                }
                if ($jobs['user_type'] == "O") {
                    if ($jobs['org_name'] == "NULL" || $jobs['org_name'] == NULL) {
                        $company = $jobs['user_fname'];
                    } else {
                        $company = $jobs['org_name'];
                    }
                } else {
                    $company = "LOOKOUT";
                }
                if ($jobs['user_type'] == "O") {
                    if ($jobs['job_location'] != "0" && $jobs['job_location'] != "NULL" && $jobs['job_location'] != "") {
                        $location = $jobs['job_location'];
                    } elseif (!empty($jobs['user_state']) && !empty($jobs['user_country'])) {

                        $location = $jobs['user_state'] . ', ' . $jobs['user_country'];
                    } else {
                        $location = '';
                    }
                } else {
                    $location = 'GUJARAT, INDIA';
                }
                if (!isset($jobs['profile_userName'])) {
                    $jobs['profile_userName'] = "USER";
                }
                $datepost  = date_create(date("Y-m-d H:i:s", strtotime($jobs['date_created'])));
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
                $output .='
                <article class="jobListarticle">
                    <div class="mng-company">
                        <div class="col-md-2 col-sm-2">
                            <div class="mng-company-pic"><img
                                    src="'. _UPLOAD_URL . "images/" . $jobs["user_photo"].'"
                                    class="img-responsive"
                                    alt="User Iamge">
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5">
                            <div class="mng-company-name">
                                <h4>'.$jobs['job_title'].'<span
                                        class="cmp-tagline"></span>
                                </h4>
                                <span class="cmp-time">By: '. $company .'</span><br>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="mng-company-location">';
                            if ($location) {
                                  $output .=' <p><i class="fa fa-map-marker"></i>' . $location . '</p> ';
                            }
                            $output .='<span class="cmp-time">Category: '. $jobs["job_hours"].'</span><br>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1 ">
                            <div class="mng-company-action">';
                                if ($jobs['apply'] == "0") {
                                    $output .='<span data-jid="' . $jobs['appl_id'] . '" class="delete-job" >
                                                             <i class="fa fa-trash-o"></i></span>';
                                }
                                $output .='<a href="' . _HOME . '/job/detailview/jobDetailView.php?id=' . base64_encode($jobs['appl_job_id']) . '" class="view-job"><i class="fa fa-eye"></i></a>';

                            $output .='</div>
                        </div>
                    </div>
                    <span class="tg-themetag tg-featuretag">'.$datepost.'</span>
                </article>';
            }
            $page   = ceil($job->getTotalRec() / PERPAGE);
            $button = '';

            for ($i = 1; $i <= $page; $i++) {
                $active= $i == $_POST['limit'] ? "active": '';
                $button .= '<li><a class="pagingdat '.$active.'" data-page="' . $i . '">' . $i . '</a></li>';
            }
            $retData['button'] = $button;
        } else {
            $output .=" <article>
                                    <div class='mng-company'>
                                    NO JOBS FOUND
                                    </div></article>";
        }
        $retData['data']   = $output;
        $retData['result'] = true;
    } else {
        $retData['error']  = "Error On getting Jobs";
        $retData['result'] = false;
    }
    echo json_encode($retData);

}
