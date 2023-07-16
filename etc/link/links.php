<?php

class links{
	private $links_sql = "SELECT facebook, twitter, instagram, linkedIn FROM lo_tbllinks WHERE user_id = :uid";
	private $conn = "";
	public $link= "";
	public $status="";

    public function setConn( $conn): void
    {
        $this->conn = $conn;
    }
    public function getLinks($uid){
        $ret = false;
        if(!empty($uid)){
            $this->getLinksFunc($uid);
            $ret = true;
        }
        return $ret;
    }

    private function getLinksFunc($uid){
        try{
            $stmt = $this->conn->prepare($this->links_sql);
            $stmt->execute(['uid'=>$uid]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row && count($row)>0){
                $this->link = $row;
                $this->link['facebook'] = !empty($this->link['facebook']) && $this->link['facebook']!=""? $this->link['facebook'] : '';
                $this->link['twitter'] = !empty($this->link['twitter']) && $this->link['twitter']!=""? $this->link['twitter'] : '';
                $this->link['instagram'] = !empty($this->link['instagram']) && $this->link['instagram']!=""? $this->link['instagram'] : '';
                $this->link['linkedIn'] = !empty($this->link['linkedIn']) && $this->link['linkedIn']!=""? $this->link['linkedIn'] : '';
            }else{
                $this->link =[
                    'facebook'=>"",
                    'twitter'=>"",
                    'instagram'=>"",
                    'linkedIn'=>"",
                ];
            }
        }catch(PDOException $e){

        }
    }
}
