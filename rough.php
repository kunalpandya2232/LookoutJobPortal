<?php


session_start();
require "config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles = new settings();
$reqFiles->get_required_files();
$dbconn = new db();
$conn = $dbconn->getConn();

$record = 19;

echo md5(123456789);
exit;
$insOtpsql = "INSERT INTO testlookout_db_proj7911.lo_tblotp(user_email, verify_code, verify_status, is_verify)";
$insUsersql = "INSERT INTO testlookout_db_proj7911.lo_tblusers(user_fname, user_lname, user_email, user_contactNumber, user_dob, user_photo, user_password, user_type, is_live, is_deleted)";
$insPuser = "INSERT INTO testlookout_db_proj7911.lo_tblprofileuser(user_id, profile_userName) ";


$email = ['aakanksha','bhavik','chandu','diines','elsisha','fafad','gudiya','harsh','ishat','jaanus','kunal','lamnin','mera','nainan','owl','paassr','qorano','rajs','shyam','tenjvi','urvi','vyom','wrjoterj','xagqu','yogesh','zorion'];
$num = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15'];
$num10 = ['1','2','3','4','5','6','7','8','9','0'];
$more=['aq','dfa','dd','qpod','doif','qod','powbiq','iwud','own','qpq','zpm'];
$puid = 41;
for($i = 1 ; $i<=$record; $i++){
    $emailrand = rands($email, $num).'@gmail.com';
//    $insOtpsqlval = values();
    $vericode = rands($email,$num,1,$more);
    $insotpval = " VALUES('$emailrand','$vericode','1','1')";

    $fname = rands($more,$num);
    $lname = rands($more,$num);
    $cn = randnum($num10,10);
    $dob = randdob($num10,$num10,$num10);
    $type = thisthat(['O','J']);
    $live = thisthat(['N','Y']);
    $puname = rands($email,$num,3,$more);
    $pass=md5($vericode);
    $insuval = " VALUES('$fname', '$lname', '$emailrand',$cn,$dob,'default.png','$pass','$type','$live','N')";
    $inspval = " VALUES($puid,'$puname')";
    $puid ++;
    echo $insOtpsql.$insotpval."<br>";
    echo $insUsersql.$insuval."<br>";
    echo $insPuser.$inspval."<br>";
    if(true) {
        $otp = $conn->prepare($insOtpsql . $insotpval);
        $otp->execute();
        $usrs = $conn->prepare($insUsersql . $insuval);
        $usrs->execute();
        $pusers = $conn->prepare($insPuser . $inspval);
        $pusers->execute();
    }
}


function rands($email,$num,$a=3,$b=false){
    $out = $email[array_rand($email)];
    $nums='';
    for($i=1; $i<=$a;$i++){
        $nums .= $num[array_rand($num)];
    }    for($i=1; $i<=$a;$i++){
        $nums .= $num[array_rand($num)];
    }
    $out = $out.$nums;
    if($b){
        $more = $b[array_rand($b)];
        $out = $out.$more;
    }
    return $out;
}
function randnum($num,$len){
    $nums='';
    for($i=1; $i<=$len;$i++){
        $nums .= $num[array_rand($num)];
    }
    return $nums;
}
function randdob($date,$month,$year){
    $cdate = rand(0,1);
    $c2date = $date[array_rand($date)];
    $cmonth = $month[array_rand($month)];
    $c1year = rand(19,20);
    if($c1year==19){
        $c3year = $year[array_rand($year)];
    }else{
        $c3year = 0;
    }
    $c4year = $year[array_rand($year)];
    $dob=$c1year.$c3year.$c4year.'-0'.$cmonth."-".$cdate.$c2date;
    return (string)$dob;
}
function thisthat($type){
    $type = $type[array_rand($type)];
    return $type;
}
