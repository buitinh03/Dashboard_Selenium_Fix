<?php

   include_once('../connect.php');
   include_once('format/format.php');
   include_once('classes/login.php');

   $db = new connect();
   $fm = new Format();

    $customer = new Login();
   $product = new product();

?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])){
      
    $username = $_POST['username'];
    $hash = $_POST['password'];
    $password = hash('sha256', $hash);
 
    $login_customer = $customer->login_customer($username, $password);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!--     <base href="http://localhost:3000/Dashboard_Selenium_Fix/Dashboard"> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/54f0cb7e4a.js"> crossorigin="anonymous" </script>
    <link rel="stylesheet" href="css/login.css">
    <title>Đăng nhập & Đăng ký</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                             <!--------- Dang Nhap -------->
                       
                <form action="" method="post" class="sign-in-form">
              
                    <h2 class="title">ĐĂNG NHẬP</h2>
                
                    <?php
                    if(isset($login_customer)){
                        echo $login_customer;
                    }
                   ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Email đăng nhập"  id="">
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i> 
                        <input type="password" name="password" placeholder="Mật khẩu"  id="hiddenpassword">
                        <div id="eye" style="margin-top: -63%;">
                        <i  class="far fa-eye-slash" style="margin-left: 600%; margin-top: -150%; cursor: pointer;"></i>
                        </div>
                    
                    </div>
                
                    <input type="submit" name="signin" value="Đăng nhập" class="btn solid">
                    <p class="social-text">Hãy đảm bảo rằng bạn đã nhập đúng tên đăng nhập và mật khẩu của bạn.</p>
                    <div class="social-media">
                   
                    </div>
                   
                </form>
              
            </div>
        </div>
        <!--  -->
        <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Lưu ý?</h3>
                        <p>Đảm bảo rằng bạn có kết nối internet ổn định và bạn đang cố gắng đăng nhập vào đúng trang web.</p>
                            <!-- <button class="btn transparent" id="sign-up-btn">ĐĂNG KÝ</button> -->
                    </div>
                    <img src="images/signin1.svg" alt="" class="image">
                </div>

                <div class="panel right-panel">
                  
                </div>
        </div>
    </div>
    <script src="js/login.js"></script>
    <script  src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/hiddenpassword.js"></script>
</body>
</html>
