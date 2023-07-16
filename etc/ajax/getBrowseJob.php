<?php


if (!isset($_SESSION)) {
    session_start();
    require '../../config/settingsFiles.php';

}

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

    class getJob
    {
        private $getJob_sql = "SELECT job.id as 'job_id', job.*, user.user_fname, user.user_photo, puser.profile_userName, user.user_type,user.user_email,user.user_country, user.user_state,puser.profile_userName, puser.org_name FROM lo_tbljobs as job INNER JOIN lo_tblusers as user ON job.user_id = user.id INNER JOIN lo_tblprofileuser as puser ON puser.user_id = user.id INNER JOIN lo_tblcategory as cat ON cat.id = job.category_id ";
        private $conn       = "";
        private $totalRec   = "";
        public  $status     = "";

        public function setConn($conn)
        {
            $this->conn = $conn;
        }

        /**
         * @return string
         */
        public function getGetJobSql()
        {
            return $this->getJob_sql;
        }

        public function getJobFunc($sortlist)
        {
            $ret       = false;
            $condition = " WHERE job.is_deleted = 'N' AND job.is_reported ='N' AND user.is_deleted ='N' ";
            if (!empty($sortlist)) {
                if (isset($sortlist['locate']) && $sortlist['locate'] != '') {
                    $condition .= " AND job.job_location='" . $sortlist['locate'] . "' ";
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
            $this->totalRec = $this->getTotalRecordsRow($condition);
            if (!empty($sortlist)) {
                if (isset($sortlist['limit']) && $sortlist['limit'] != '') {
                    $offset    = PERPAGE;
                    $limit     = $sortlist['limit'];
                    $limit     = ((intval($limit) - 1) * $offset);
                    $condition .= ' LIMIT ' . $limit . ', ' . $offset;
                }
            }
            $this->getJob_sql = $this->getJob_sql . $condition;


            try {
                $stmt = $this->conn->prepare($this->getJob_sql);
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


        private function getTotalRecordsRow($condition)
        {
            try {
                $stmt = $this->conn->prepare($this->getJob_sql . $condition);
                $stmt->execute();
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

        public function getJob_sql()
        {
            return $this->getJob_sql;
        }

    }


if ($_POST) {
    $retData  = [];
    $reqFiles = new settings();
    $reqFiles->get_required_files();
    $reqFiles->get_valid_checker();
    $valid   = new validChecker();
    $dbClass = new db();
    // clean and check again
    $noremove = ['category' => $_POST['category']];
    $data     = $valid->cleanData($_POST, $noremove);
    $getJob   = new getJob();
    $getJob->setConn($dbClass->getConn());

    $res    = $getJob->getJobFunc($data);
    $output = '';
    if (is_array($res)) {
        foreach ($res as $jobs) {
            //for job type
            if ($jobs['job_hours'] == 1) {
                $jobs['job_hours'] = 'Full Time';
            } elseif ($jobs['job_hours'] == 2) {
                $jobs['job_hours'] = 'Part Time';
            } elseif ($jobs['job_hours'] == 0) {
                $jobs['job_hours'] = 'Flexible Time';
            }
//                for company name else user name
            if ($jobs['user_type'] == "O") {
                if ($jobs['org_name'] == "NULL" || $jobs['org_name'] == NULL) {
                    $company = $jobs['user_fname'];
                } else {
                    $company = $jobs['org_name'];
                }
            } else {
                $company = "LOOKOUT";
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
            $redirect = _HOME.'/job/detailview/jobDetailView.php?id='.base64_encode($jobs['job_id']);
            $output .= '<div class="item-click">
           
                        <div class="col-md-4 col-sm-6 browjob" onclick="window.location.href=\' '.$redirect.'\'" >
                <div class="grid-view brows-job-list">
                    <div class="brows-job-company-img">
                    <img src="' . _HOME . "/uploads/images/" . $jobs["user_photo"] . '"
                            alt="' . $jobs["profile_userName"] . '"\'s image class="img-responsive"/>
                    </div>
                    <div class="brows-job-position">
                        <a href="#"><h3>' . $jobs['job_title'] . '</h3></a>
                        <p><span>' . $company . '</span></p>
                    </div>
                    <div class="job-position">
                        <span class="job-num">'.$jobs['job_vacancy'].'  vacancy'.'</span>
                    </div>
                    <div class="brows-job-type">
                        <span class="full-time">' . $jobs["job_hours"] . '</span>
                    </div>
                    <ul class="grid-view-caption">
                        <li>
                            <div class="brows-job-location">';
            if ($location) {
                $output .= ' <p><i class="fa fa-map-marker"></i>' . $location . '</p> ';
            }
            $output .= '</div>
                        </li>
                        <li>
                            <p><span class="brows-job-sallery"><i
                                class="fa fa-money"></i>' . $jobs["job_amt"] . '</span></p>
                        </li>
                    </ul>
    <span class="tg-themetag tg-featuretag">' . $datepost . '</span>
                </div>
            </div>

        </div>';
        }
        $offset = PERPAGE;
        $page   = ceil($getJob->getTotalRec() / $offset);
        $button = '';

        for ($i = 1; $i <= $page; $i++) {
            $button .= '<li><a class="pagingdat" data-page="' . $i . '">' . $i . '</a></li>';
        }
        $retData = [
            'result' => true,
            'res'    => $output,
            'pagbut' => $button,
            'etc'    => $getJob->getJob_sql()
        ];
    } else {
        $retData = [
            'result' => false,
            'res'    => $res
        ];
    }

    echo json_encode($retData);
}
