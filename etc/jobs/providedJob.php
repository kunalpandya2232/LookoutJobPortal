<?php


class providedJob
{
    private $getProvided_sql    = "SELECT jobs.id as 'jobId', jobs.*, user.*,pu.* FROM lo_tbljobs as jobs INNER JOIN lo_tblusers as user ON user.id = jobs.user_id  INNER JOIN lo_tblprofileuser as pu ON pu.user_id = jobs.user_id WHERE jobs.is_deleted='N' AND jobs.user_id=? ORDER BY jobs.job_title";

    private $getRequest_sql = "SELECT  appl.id as 'appl_id', jobs.id as 'job_id', pu2.category_id as 'cat_user',u.user_photo as 'image_user',pu2.user_id as 'id_puser', u.user_fname as 'fname', u.user_lname as 'lname', jobs.job_title as 'job_detail', appl.date_created as 'dateCreated', jobs.job_vacancy as 'vacancy', pu2.jobS_exp as 'exp_user', u.user_gender as 'user_gender' FROM lo_tblapplier as appl  INNER JOIN lo_tbljobs as jobs ON jobs.id = appl.job  INNER JOIN lo_tblprofileuser as pu ON pu.user_id = jobs.user_id INNER JOIN lo_tblprofileuser as pu2 ON appl.user_id = pu2.user_id INNER JOIN lo_tblusers as u ON u.id = pu2.user_id  WHERE jobs.user_id  =:orgId AND appl.apply = :applier AND u.is_deleted = 'N' AND jobs.is_reported = 'N' ORDER BY appl.date_created  ASC";
    private $conn   = "";
    public  $status = "";

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getProvidedJobs($id){
        $ret = false;
        if (!empty($id) && $id != '') {
            try {
                $stmt = $this->conn->prepare($this->getProvided_sql);
                $stmt->execute([$id]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->status = true;
                if(count($res)>0){
                    $ret = $res;
                }else{
                    $ret = false;
                }

            } catch (PDOException $e) {
                $this->status = $e->getMessage();
            }
        }
        return $ret;
    }

    public function getRequestJobs($id,$state='pending'){
        $ret = '';
        if($state =='pending'){
            $applier = '0';

        }elseif($state == 'apply'){
            $applier = '1';

        }
        try{
            $stmt=$this->conn->prepare($this->getRequest_sql);
            $stmt->execute(['orgId'=>$id,'applier'=>$applier]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->status = true;
            $ret = $res;
        }catch (PDOException $e){
            $this->status=$e->getMessage();
        }
        $catarray=[];
        if(isset($res)&&count($res)>0){

        foreach ($res as $val){
            if($val['cat_user'] != NULL){
                $catarray[]=$val['id_puser'];
            }
        }
        if(count($catarray)>0){
            try{
                $stmt= $this->conn->prepare("SELECT cat.category_subname FROM lo_tblcategory as cat INNER JOIN lo_tblprofileuser as pu ON pu.category_id = cat.id WHERE pu.user_id in(".$catarray.")");
                $stmt->execute();
                $getCat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch (PDOException $e){

            }
        }
        }

        return $ret;
    }
}
