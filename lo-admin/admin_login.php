<?php




if($_POST &&$_POST['login']){
    if(!empty($_POST['name'])&&!empty($_POST['pass'])){
        if($_POST['name']==OWNER){
            if($_POST['pass']=='123'){
                $_SESSION['admin_login']=true;
                header("location: "._ADMIN_HOME."/index.php");
            }else{
                $err='Paswword';
                $_SESSION['admin_login']=false;
            }
        }else{
            $err='Name';
            $_SESSION['admin_login']=false;
        }
    }else{
        $err='Something Wrong';
        $_SESSION['admin_login']=false;
    }

}
?>

<div>
    <?php

    if(isset($err)){
        echo $err.' is Wrong';
    }
    ?>
    <br>
    Admin Login
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label>Pass</label>
            <input type="password" name="pass" id="pass">
        </div>
        <div>
            <input type="submit" name="login" value="Submit">
        </div>
    </form>
</div>
