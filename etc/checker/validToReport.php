<?php


class validToReport{
    private $report_sql = "INSERT INTO lo_tblreports (user_id, job_id, report_title, report_desc) VALUE (:uid,:jid,:title,:desc)";
    private $conn ='';
    public $status;

    /**
     * @param string $conn
     */
    public function setConn($conn): void
    {
        $this->conn = $conn;
    }
    public function reportFunc(array $data,$uid='',$jid=''){
        $ret = false;
        if(!empty($uid) && !empty($jid)){
            try {
                $stmt= $this->conn->prepare($this->report_sql);
                $stmt->execute(['uid'=>$uid,'jid'=>$jid,'title'=>$data['title'],'desc'=>$data['desc']]);
                $ret = true;
                $this->status = true;
            } catch (PDOException $e) {
                $this->status =$e->getMessage();
            }
        }
        return $ret;
    }
}
