<?php


class jobView
{
    private $job_sql             = "SELECT * FROM lo_tbljobs as jobs INNER JOIN lo_tblusers as user ON jobs.user_id = user.id INNER JOIN lo_tblprofileuser as puser ON puser.user_id = user.id  INNER JOIN lo_tblcategory as cat ON cat.id = jobs.category_id WHERE jobs.id = :job AND is_reported=\"N\"";
    private $verifyJobStatus_sql = "SELECT appl.* FROM lo_tblapplier as appl INNER JOIN lo_tbljobs as jobs ON appl.job=jobs.id INNER JOIN lo_tblprofileuser as puser ON puser.user_id = appl.user_id WHERE appl.user_id = :userId and appl.job = :jobId ORDER BY appl.id LIMIT 1 ";
    private $applyJob_sql        = "INSERT INTO lo_tblapplier(user_id,apply,job,is_delete)VALUES(:userId,:apply,:jobId,:delete);";
    private $report_sql = "SELECT id FROM lo_tblreports WHERE user_id =:userId AND job_id = :jid ";
    private $link_sql             = "SELECT link.facebook, link.instagram, link.twitter, link.linkedIn FROM lo_tbllinks as link INNER JOIN lo_tblusers as user ON link.user_id = user.id WHERE user.id = :uid AND user.is_deleted=\"N\"";

    private $conn                = "";
    public  $status              = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return string
     */
    public function getJobSql()
    {
        return $this->job_sql;
    }

    public function jobDetailVIewFunc($data)
    {
        $ret = false;
        try {
            $stmt = $this->conn->prepare($this->job_sql);
            $stmt->execute(['job' => $data['jobId']]);
            $res          = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = $res;
        } catch (PDOException $e) {
            $this->status = false;
            $ret          = $e->getMessage();
        }
        return $ret;
    }

    public function applyJobFunc($conn, $data)
    {
        $ret = false;
        if (count($data)) {
            $this->setConn($conn);
            try {
                $stmt = $this->conn->prepare($this->applyJob_sql);
                $stmt->execute(['userId' => $data['userId'], 'apply' => 0, 'jobId' => $data['jobId'], 'delete' => 'N']);
                $this->status = true;
                $ret          = true;
            } catch (PDOException $e) {
                $this->status = false;

            }
        }
        return $ret;
    }

    public function checkJobApplied($data)
    {
        try {
            $stmt = $this->conn->prepare($this->verifyJobStatus_sql);
            $stmt->execute(['userId' => $data['userId'], 'jobId' => $data['jobId']]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = $res;
        } catch (PDOException $e) {
            $this->status = false;

        }
        return $ret;
    }

    public function isReportByUser($data){
        try {
            $stmt = $this->conn->prepare($this->report_sql);
            $stmt->execute(['userId' => $data['userId'], 'jid' => $data['jobId']]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res && count($res)>0){

                $ret          = true;
            }else{
                $ret          = false;
            }
        } catch (PDOException $e) {

        }
        return $ret;
    }

    public function getLinks($id){
        $ret = false;
        try {
            $stmt = $this->conn->prepare($this->link_sql);
            $stmt->execute(['uid' => $id]);
            $res          = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret          = $res;
        } catch (PDOException $e) {
            $this->status = false;
            $ret          = $e->getMessage();
        }
        return $ret;
    }
}
