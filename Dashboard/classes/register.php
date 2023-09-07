<?php include_once('lib/session.php'); ?>
<?php  //Session::checkLogin(); ?>
<?php include_once('connect.php'); ?>
<?php include_once('format/format.php'); ?>


<?php

 class Register {
   
    function __construct()
    {
        
        
    }

    function insert_customer($fullname,$email,$signupuser,$password,$type){
        $db = new connect();
        
         $check_login = "SELECT COUNT(*) as a FROM tbl_admin WHERE email='$email' LIMIT 1";
        $result_check = $db->getList($check_login);
        $count = 0;
        while($rsc=$result_check->fetch()){
            $count = $rsc['a'];
        }
        // Kiểm tra email có trùng nhau hay không
        $checkemail = "SELECT * FROM tbl_admin WHERE email='$email' LIMIT 1";
        $resultCheck = $db->getList($checkemail);
        
        if($count >= 1){
            // header("Location: register.php");
            // echo "<script>show();</script>";
            #$msg=$_SESSION['login-fullname'].$_SESSION['login-email'].$_SESSION['login-signupuser'].$_SESSION['login-password'];
            $msg = "<span class='error' style='color:  #FF0000;'>Email đã tồn tại. Vui lòng thử lại với email khác!</span>
            <script>window.addEventListener('DOMContentLoaded', function() {
                
            
                var nameInput = document.getElementById('login-fullname');
                nameInput.value = '". $fullname."';
                var emailInput = document.getElementById('login-email');
                emailInput.value = '".$email."';
                emailInput.style.color = '#FF0000';
                emailInput.style.caretColor = 'black';
                emailInput.focus();
                var userInput = document.getElementById('login-signupuser');
                userInput.value = '".$signupuser."';
                var passInput = document.getElementById('hiiddenpassword');
                passInput.value = '';
                var btn = document.getElementById('sign-up-btn');
                btn.click();
              });</script>";
            return $msg;
        }else{
        $query = "INSERT INTO tbl_admin(fullname,email,username,password,type)VALUES('$fullname','$email','$signupuser','$password','$type')";
        $result = $db->exec($query);
        if($result){
            unset($_SESSION['login-fullname']);
            unset($_SESSION['login-email']);
            unset($_SESSION['login-signupuser']);
            unset($_SESSION['login-password']);
            $alert = "<span class='success' style='color: #0000FF;'>Đăng ký tài khoản thành công !</span>
            <script>window.addEventListener('DOMContentLoaded', function() {
                
            
                var nameInput = document.getElementById('login-fullname');
                nameInput.value = '". $fullname."';
                var emailInput = document.getElementById('login-email');
                emailInput.value = '".$email."';
                emailInput.style.color = 'black';                
                var userInput = document.getElementById('login-signupuser');
                userInput.value = '".$signupuser."';
                var passInput = document.getElementById('hiiddenpassword');
                passInput.value = '';
                var btn = document.getElementById('sign-up-btn');
                btn.click();
              });</script>";
            // header('Location: index.php');
            
            return $alert;
        }else {
        
            $msg = "<span class='error' style='color:  #FF0000;'>Đăng ký tài khoản thất bại !</span>
            <script>window.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('sign-up-btn');
                btn.click();
            
                var nameInput = document.getElementById('login-fullname');
                nameInput.value = ". $_SESSION['login-fullname'].";
                var emailInput = document.getElementById('login-email');
                emailInput.value = ".$_SESSION['login-email'].";
                emailInput.style.color = '#FF0000';
                emailInput.style.caretColor = 'black';
                emailInput.focus();
                var userInput = document.getElementById('login-signupuser');
                userInput.value = ".$_SESSION['login-signupuser'].";
                var passInput = document.getElementById('hiiddenpassword');
                passInput.value = '';
              });</script>";
            return $msg;
        }
        }
    }
 }

 ?>
 <script>
    window.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('sign-up-btn');
    btn.click();
  });
 </script>
