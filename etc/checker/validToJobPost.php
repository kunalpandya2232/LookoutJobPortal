<?php


class validToJobPost
{

    private $insertPost_sql = "INSERT INTO lo_tbljobs(user_id, job_title, job_desc, job_amt, job_hours, job_miniexp, job_vacancy, job_location, job_responsibility, job_skillRequire, category_id, is_reported, job_createdBy, job_lastlyEdited) VALUES (:userid,:title,:descp,:amt,:hrs,:minexp,:vcc,:location,:resp, :skill,:cat,:rep,:creat,:lastedit)";
    private $updateJob_sql ="UPDATE lo_tbljobs SET job_title=:title,job_desc=:descp,job_amt=:amt,job_hours=:hrs,job_miniexp=:minexp,job_vacancy=:vcc,job_location=:location,job_responsibility=:resp,job_skillRequire=:skill,category_id=:cat,job_lastlyEdited=:lastedit WHERE id=:jid ";
    private $data = '';
    private $conn = '';
    private $jobId="";
    public $user = "";
    public $status = "";

    public function validToJobPostFunc($conn,$data,$edit=''){
        $ret = false;
        $this->conn = $conn;
        $this->data = $data;
        $this->user = intval($data['uid']);
        $u_catid = $this->getCategoryId();
        if($this->user !== 0 &&$u_catid){
            if($edit!=''){
                $res = $this->updateJobPost();
            }else{
                $res = $this->insertJobPost();
            }
            if($res){
                $ret = true;
            }
        }else{
            $ret = false;
        }
        return $ret;
    }

    private function insertJobPost(){
        $this->data['cat'] = $this->data['cat'] == 0 ? 'OTHERS' : $this->data['cat'];
        try{
            $stmt = $this->conn->prepare($this->insertPost_sql);
            $stmt->bindParam('userid',$this->user, PDO::PARAM_INT);
            $stmt->bindParam('title',$this->data['jobtitle'], PDO::PARAM_STR);
            $stmt->bindParam('descp',$this->data['jobdescription'], PDO::PARAM_STR);
            $stmt->bindParam('amt',$this->data['jobamt'], PDO::PARAM_INT);
            $stmt->bindParam('hrs',$this->data['jobhours']);
            $stmt->bindParam('minexp',$this->data['minexp'], PDO::PARAM_INT);
            $stmt->bindParam('vcc',$this->data['jobvcc'], PDO::PARAM_INT);
            $stmt->bindParam('location',$this->data['jobLocation'], PDO::PARAM_STR);
            $stmt->bindParam('resp',$this->data['jobresponsiblity'], PDO::PARAM_STR);
            $stmt->bindParam('skill',$this->data['skillRequire'], PDO::PARAM_STR);
            $stmt->bindParam('cat',$this->data['cat'], PDO::PARAM_STR);
            $stmt->bindParam('rep',$this->data['report'], PDO::PARAM_STR);
            $stmt->bindParam('creat',$this->data['creat'], PDO::PARAM_STR);
            $stmt->bindParam('lastedit',$this->data['lastedit'], PDO::PARAM_STR);
            $stmt->execute();
            $this->status = 'Success';
            $ret = true;

        }catch(PDOException $e){
            $this->status = "Database Error to Insert Post ". $e->getMessage();
            $ret = false;
        }
        return $ret;
    }

    private function getCategoryId(){

        try{
            $stmt = $this->conn->prepare("SELECT id FROM lo_tblcategory WHERE category_subname =:subname");
            $stmt->execute(['subname'=> $this->data['cat']]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data['cat']= $res['id'];
            $ret = true;
        }catch (PDOException $e){
            $ret = false;
        }
        return $ret;
    }

    /**
     * @param string $jobId
     */
    public function setJobId($jobId): void
    {
        $this->jobId = $jobId;
    }
    private function updateJobPost(){
        $this->data['cat'] = $this->data['cat'] == 0 ? 'OTHERS' : $this->data['cat'];
        try{
            $stmt = $this->conn->prepare($this->updateJob_sql);
            $stmt->execute(['title'=>$this->data['jobtitle'],'descp'=>$this->data['jobdescription'],'amt'=>$this->data['jobamt'],'hrs'=>$this->data['jobhours'],'minexp'=>$this->data['minexp'],'vcc'=>$this->data['jobvcc'],'location'=>$this->data['jobLocation'],'resp'=>$this->data['jobresponsiblity'],'skill'=>$this->data['skillRequire'],'cat'=>$this->data['cat'],'lastedit'=>$this->data['lastedit'],'jid'=>$this->jobId]);

            $this->status = 'Success';
            $ret = true;

        }catch(PDOException $e){
            $this->status = "Database Error to Edit Post ". $e->getMessage();
            $ret = false;
        }
        return $ret;
    }

}
$validToJobPost = new validToJobPost();
