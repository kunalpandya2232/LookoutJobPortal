<?php
/**
 * Created by PhpStorm.
 * User: Shyam PC
 * Date: 3/27/2022
 * Time: 10:16 AM
 */

class validToAdminDash
{
    private $count_user = "SELECT u.user_fname as 'fname', u.user_lname as 'lname', u.user_type as 'type', u.date_created as 'date' FROM lo_tblusers as u INNER JOIN  lo_tblotp as otp ON u.user_email=otp.user_email WHERE u.is_deleted='N' AND otp.verify_status='1' AND otp.is_verify='1' AND u.user_type=:type ORDER BY u.date_created ";

    private $count_job = "SELECT u.user_fname as 'fname', u.user_lname as 'lname', job.date_created as 'date' FROM lo_tbljobs as job INNER JOIN lo_tblusers u on job.user_id = u.id  WHERE u.is_deleted='N' AND job.is_reported='N' AND job.is_deleted='N' ORDER BY job.date_created";

    private $report_sql = "SELECT u.id as 'uid', u2.user_fname as 'f_name', pu.org_name as 'org_name',u.user_photo as 'img', u2.is_deleted as 'user_delete', rep.id as 'rid',rep.* FROM lo_tblreports as rep  INNER JOIN lo_tbljobs as job ON job.id = rep.job_id  INNER JOIN lo_tblusers as u2 ON job.user_id = u2.id INNER JOIN lo_tblusers as u ON rep.user_id =u.id INNER JOIN lo_tblprofileuser pu on u2.id = pu.user_id ORDER BY rep.date_created ASC";

    private $bann_sql = "SELECT u.id as 'uid', u.user_fname as 'f_name', pu.org_name as 'org_name', u.user_photo as 'img' FROM lo_tblusers as u INNER JOIN lo_tblprofileuser pu on u.id = pu.user_id WHERE is_deleted ='Y' ORDER BY u.date_updated ";

    private $bann_rep_sql = "SELECT u.id as 'uid', u.user_fname as 'f_name',  u.user_photo as 'img',pu.org_name as 'org_name',rep.* FROM lo_tblusers as u INNER JOIN lo_tbljobs job on u.id = job.user_id  INNER JOIN lo_tblprofileuser pu on u.id = pu.user_id INNER JOIN lo_tblreports as rep ON rep.job_id = job.id WHERE u.is_deleted ='Y' ORDER BY rep.date_updated";

    private $conn = '';
    public $status='';

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers(){
        $jobseek = $this->getUserCountByType('J');
        $org= $this->getUserCountByType('O');
        $ret['users']['jobseek']=$jobseek['user'];
        $ret['users_count']['jobseek']=$jobseek['users_count'];
        $ret['users']['org']=$org['user'];
        $ret['users_count']['org']=$org['users_count'];
        return $ret;
    }

    public function getUserCountByType($type){
        try{
            $stmt=$this->conn->prepare($this->count_user);
            $stmt->execute(['type'=>$type]);
            $jobseek = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ret['user']=$jobseek;
            $ret['users_count']=count($jobseek);
        }catch(PDOException $e){
            $ret = "Error in counting".$e->getMessage();
        }
        return $ret;
    }

    public function getTotalJobs(){
        try{
            $stmt=$this->conn->prepare($this->count_job);
            $stmt->execute();
            $job= $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ret['job']=$job;
            $ret['job_count']=count($job);
        }catch(PDOException $e){
            $ret = "Error in counting";
        }
        return $ret;
    }

    public function getReports(){
        try{
            $stmt=$this->conn->prepare($this->report_sql);
            $stmt->execute();
            $rep= $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ret=$rep;
        }catch(PDOException $e){
            $ret = "Error in report data";
        }
        return $ret;
    }

    public function getBannedAccount(){
        try{
            $stmt=$this->conn->prepare($this->bann_sql);
            $stmt->execute();
            $bann= $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ret=$bann;
        }catch(PDOException $e){
            $ret = "Error in Bann";
        }
        return $ret;
    }
    public function getBannedAccountWithReport(){
        try{
            $stmt=$this->conn->prepare($this->bann_rep_sql);
            $stmt->execute();
            $bann= $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ret=$bann;
        }catch(PDOException $e){
            $ret = "Error in Bann";
        }
        return $ret;
    }
}
