<?php

   include_once('connect.php');
   include_once('format/format.php');
   include_once('classes/login.php');
   include_once('classes/customer.php');

   $db = new connect();
   $fm = new Format();

    $customer = new Login();
   $product = new product();
   $forgotpass = new Customer();
   if(Session::get('sotrang')){
    $numpagecao=Session::get('sotrang');
}else{
    $numpagecao=0;
    Session::set('sotrang',0);
}
?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])){
      
    $username = $_POST['email'];
    $hash = $_POST['password'];
    $password = hash('sha256', $hash);
 
    $login_customer = $customer->login_customer($username, $password);
    
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['xacnhan'])){
      
    $forgotemail = $_POST['forgotemail'];
    
 
    $user_confirmation = $forgotpass->user_confirmation($forgotemail);
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.png"/>
    <title>HB PHARMA</title>
</head>
<body>

    <div>
        <!-- <div onclick="showSuccessToast();" class="btn btn--success">Show success toast</div>
        <div onclick="showErrorToast();" class="btn btn--danger">Show error toast</div> -->
        <?php if(isset($user_confirmation)){
                        echo $user_confirmation;
            }?>
    </div>
    <div class="container">

        <div class="forms-container">
            <div class="signin-signup">
                             <!--------- Dang Nhap -------->
                       
                <form action="" method="post" class="sign-in-form" >
              
                    <h2 class="title">ĐĂNG NHẬP</h2>
                
                    <?php
                    if(isset($login_customer)){
                        echo $login_customer;
                    }
                   ?>
             
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Email đăng nhập"  id="">
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i> 
                        <input type="password" name="password" placeholder="Mật khẩu"  id="hiddenpassword">
                        <!-- <div id="eye" style="margin-top: -70%; position:relative;"> -->
                        <i  class="far fa-eye-slash" style="margin-left: 600%; margin-top: -100%; cursor: pointer;" id="eye"></i>
                        <!-- </div> -->
                    
                    </div>
                
                    <input type="submit" name="signin" value="Đăng nhập" class="btn solid">
                    <p class="social-text">Hãy đảm bảo rằng bạn đã nhập đúng tên đăng nhập và mật khẩu của bạn.</p>
                    <span id="adress-form" class="social-text-span">Quên mật khẩu ?</span>
                    <div class="social-media">
                   
                    </div>
                   
                </form>

          
              
            </div>
        </div>
        <!--  -->
        <div class="panels-container">
                <div class="panel left-panel">
                    <img src="images/logo1.png" alt="" class="image">
                    <div class="content">
                        <h3>Lưu ý ?</h3>
                        <p>Đảm bảo rằng bạn có kết nối internet ổn định và bạn đang cố gắng đăng nhập vào đúng trang web.</p>
                            <!-- <button class="btn transparent" id="sign-up-btn">ĐĂNG KÝ</button> -->
                    </div>
                    
                </div>

                <div class="panel right-panel">
                  
                </div>
        </div>
        <div class="adress-form">
            <div class="adress-form-content">
                <h2>QUÊN MẬT KHẨU ? <span id="adress-close">X Đóng</span></h2>
                <form action="" method="post">
                    <p>Bạn cần cung cấp thông tin liên quan đến tài khoản như Email hoặc số điện thoại để tạo mật khẩu mới.</p>
                        <label for="forgotemail">Email xác minh:</label>
                        <input type="email" placeholder="Nhập email ở đây" name="forgotemail" id="forgotemail" required>
                        <button type="submit" name="xacnhan">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
    <div hidden class="date" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                 <h3><span id="rank"></span> - Ngày: <span id="dates"></span><br> Giờ:  <span id="coundtime"></span></h3>
                </div>
    <script src="js/login.js"></script>
    <script src="js/time.js"></script>
    <script  src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/hiddenpassword.js"></script>
    <script src="js/loginmessage.js"></script>
</body>
</html>
