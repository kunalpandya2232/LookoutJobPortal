<?php


session_start();
require_once '../../config/settingsFiles.php';

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;


class providedJobList
{
    private $getProvided_sql = "SELECT job.id as 'jobId', job.date_created as 'job_create', job.*, user.*,pu.* FROM lo_tbljobs as job INNER JOIN lo_tblusers as user ON job.user_id = user.id INNER JOIN lo_tblprofileuser as pu ON pu.user_id = user.id INNER JOIN lo_tblcategory as cat ON cat.id = job.category_id WHERE job.user_id=:uid ";
    private $conn            = "";
    private $totalRec        = "";
    public  $status          = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getJobFunc($sortlist, $id)
    {
        $ret       = false;
        $condition = " AND job.is_deleted = 'N' AND job.is_reported ='N' ";
        if (!empty($sortlist)) {
            if (isset($sortlist['locate']) && $sortlist['locate'] != '') {
                $condition .= " AND job.job_location LIKE '%" . $sortlist['locate'] . "%' ";
            }
            if (isset($sortlist['type']) && $sortlist['type'] != '') {
                $condition .= " AND job.job_hours='" . $sortlist['type'] . "' ";
            }
            if (isset($sortlist['category']) && $sortlist['category'] != '') {
                if ($sortlist['category'] != 'all') {
                    $condition .= " AND cat.category_subname='" . $sortlist['category'] . "' ";
                }
            }
            $condition .= " ORDER BY job.date_created ASC";

        }
        $this->totalRec = $this->getTotalRecordsRow($condition, $id);
        if (!empty($sortlist)) {
            if (isset($sortlist['limit']) && $sortlist['limit'] != '') {
                $offset    = PERPAGE;
                $limit     = $sortlist['limit'];
                $limit     = ((intval($limit) - 1) * $offset);
                $condition .= ' LIMIT ' . $limit . ', ' . $offset;
            }
        }
        $this->getProvided_sql = $this->getProvided_sql . $condition;


        try {
            $stmt = $this->conn->prepare($this->getProvided_sql);
            $stmt->execute(['uid' => $id]);
            $res          = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = $res;
        } catch (PDOException $e) {
            $this->status = "ERROR on getting job";
            $ret          = $e;
        }
        return $ret;
    }

    private function getTotalRecordsRow($condition, $id)
    {
        try {
            $stmt = $this->conn->prepare($this->getProvided_sql . $condition);
            $stmt->execute(['uid' => $id]);
            $res          = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = count($res);
        } catch (PDOException $e) {
            $this->status = "ERROR on getting job";
            $ret          = $e;
        }
        return $ret;
    }

    public function getTotalRec()
    {
        return $this->totalRec;
    }

}


if ($_POST) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $dbconn  = new db();
    $conn    = $dbconn->getConn();
    $checker = new validChecker();

    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $userDetailBASIC = $checker->getUserByEmail($conn, $_SESSION['email']);
        if (is_array($userDetailBASIC)) {
            $id = $userDetailBASIC['Id'];
        }
    }

    if (!empty($id)) {

        $job = new providedJobList();
        $job->setConn($conn);
        $jobList = $job->getJobFunc($_POST, $id);

        if ($jobList && $job->status) {
            $output = "";
            foreach ($jobList as $jobs) {
                //for job type
                if ($jobs['job_hours'] == 1) {
                    $jobs['job_hours'] = 'Full Time';
                } elseif ($jobs['job_hours'] == 2) {
                    $jobs['job_hours'] = 'Part Time';
                } elseif ($jobs['job_hours'] == 0) {
                    $jobs['job_hours'] = 'Flexible Time';
                }
                //                for location
                if ($jobs['user_type'] == "O") {
                    if ($jobs['job_location'] != "0" && $jobs['job_location'] != "NULL" && $jobs['job_location'] != "") {
                        $location = $jobs['job_location'];
                    } elseif (!empty($jobs['user_state']) && !empty($jobs['user_country'])) {

                        $location = $jobs['user_state'] . ', ' . $jobs['user_country'];
                    } else {
                        $location = '';
                    }
                } else {
                    //                ADMIN ADDRESS
                    $location = 'GUJARAT, INDIA';
                }
                if (!isset($jobs['profile_userName'])) {
                    $jobs['profile_userName'] = "USER";
                }
                //for date jobs
                $datepost  = date_create(date("Y-m-d H:i:s", strtotime($jobs['job_create'])));
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
                $output .= '<article class="myjobListarticle">
                    <div class="mng-company">
                        <div class="col-md-2 col-sm-2">
                            <div class="mng-company-pic"><img
                                        src="' . _UPLOAD_URL . "images/" . $jobs["user_photo"] . '"
                                        class="img-responsive"
                                        alt="' . $jobs["profile_userName"] . "\'s image" . '">
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5">
                            <div class="mng-company-name">
                                <h4>' . $jobs["job_title"] . '<span
                                            class="cmp-tagline"></span>
                                </h4>
                                <span class="cmp-time">Vacancy: ' . $jobs["job_vacancy"] . '</span><br>
                                <span class="cmp-time">Created On: ' . date( "d/m/Y",strtotime($jobs['job_create'])) . '</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            <div class="mng-company-location">
                            <p><i class="fa fa-map-marker"></i>' . $location . '</p></div>
                            <span class="cmp-time">Category: ' . $jobs['job_hours'] . '</span>
                        </div>

                        <div class="col-md-2 col-sm-2 ">
                        
                            <div class="mng-company-action">
                             <a href="' . _HOME . "/job/detailview/jobDetailView.php?id=" . base64_encode($jobs["jobId"]) . '" class="view-job"><i class="fa fa-eye"></i></a>
                                <a href="' . _HOME . "/job/editJob.php?id=" . base64_encode($jobs["jobId"]) . '" class="view-job"><i class="fa fa-pencil"></i></a>
                                <span data-id="' . $jobs["jobId"] . '" class="my-delete-job"><i class="fa fa-trash-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <span class="tg-themetag tg-featuretag">' . $datepost . '</span>
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
            $output = ' <article><div class="mng-company"> NO JOBS FOUND </div></article>';
        }
        $retData['data']   = $output;
        $retData['result'] = true;
    } else {
        $retData['error']  = "Error On getting Jobs";
        $retData['result'] = false;
    }
    echo json_encode($retData);

}
