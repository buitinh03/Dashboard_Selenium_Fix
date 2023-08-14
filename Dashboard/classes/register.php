<?php include_once('lib/session.php'); ?>
<?php  //Session::checkLogin(); ?>
<?php include_once('connect.php'); ?>
<?php include_once('format/format.php'); ?>


<?php

 class Register {
   
    function __construct()
    {
        
        
    }

    function insert_customer($fullname,$email,$phone,$signupuser,$password,$type){
        $db = new connect();
        
        $query = "INSERT INTO tbl_admin(fullname,email,phone,username,password,type)VALUES('$fullname','$email','$phone','$signupuser','$password','$type')";
        $result = $db->exec($query);
        // return $result;
        if($result){
            $alert = "<span class='success' style='color: #0000FF;'>Đăng ký tài khoản thành công !</span>";
            return $alert;
        }else {
        
            $msg = "<span class='error' style='color:  #FF0000;'>Đăng ký tài khoản thất bại !</span>";
            return $msg;
        }
    }
 }

 ?>
