<?php include_once('lib/session.php'); ?>
<?php  Session::checkLogin(); ?>
<?php include_once('connect.php'); ?>
<?php include_once('format/format.php'); ?>
<?php

 class Login{
    // private $db;
    // private $fm;
    public function __construct()
    {
    }

    function login_customer($username,$password){
        $db = new connect();
        if($username == "" || $password == ""){
           $alert = "<span class='error' style='color:  #FF0000;'>Không được để trống</span>";
           return $alert;
       }else {
        // Kiểm tra nếu trùng email thì thông báo 
        $check_login = "SELECT COUNT(*) as a FROM tbl_admin WHERE email='$username' AND password='$password' LIMIT 1";
        $result_check = $db->getList($check_login);
        $count = 0;
        while($rsc=$result_check->fetch()){
            $count = $rsc['a'];
        }
        
        $check_logins = "SELECT * FROM tbl_admin WHERE email='$username' AND password='$password' LIMIT 1";
        $result_checks = $db->getList($check_logins);
        // return $result_check;
        if($count == 1){
          $value = $result_checks->fetch(PDO::FETCH_ASSOC);
          Session::set('adminlogin', true);
          Session::set('adminId', $value['id']);
          Session::set('adminName', $value['fullname']);
          Session::set('adminUser', $value['username']);
          Session::set('adminType', $value['type']);

          header('Location:index.php');
   
        }else{
            $msg = "<span class='error' style='color:  #FF0000;'>Tên đăng nhập hoặc mật khẩu không chính xác</span>";
            return $msg;
            }
        }
    }

 }
?>
