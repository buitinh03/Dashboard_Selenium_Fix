<?php 
include_once('lib/session.php');
Session::checkSession();
?>
<?php include_once('classes/register.php');?>
<?php
    $customer = new Register();
?>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $signupuser = $_POST['signupuser'];
    $hash = $_POST['password'];
    $password = hash('sha256', $hash);
    $type = $_POST['type'];

    $insert_customer = $customer->insert_customer($fullname,$email,$signupuser,$password,$type);
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
    <link rel="icon" type="image/x-icon" href="images/favicon.png"/>
    <title>Đăng nhập & Đăng ký</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                             <!--------- Dang Nhap -------->
                       
                <form action="" method="post" class="sign-in-form">
              
                    <h2 class="title">Điều Khoản Đăng Ký</h2>
                    
                   <p class="social-text">Khi đăng ký tài khoản trên Dịch vụ, bạn sẽ được yêu cầu cung cấp một số thông tin cá nhân, bao gồm tên, địa chỉ email và mật khẩu. Bạn phải chịu trách nhiệm về tính chính xác và đầy đủ của tất cả thông tin mà bạn cung cấp trong quá trình đăng ký. Bạn cũng phải chịu trách nhiệm bảo mật mật khẩu của mình và không được tiết lộ cho bất kỳ ai khác.</p>
                
                    <!-- <input type="submit" name="signin" value="Đăng nhập" class="btn solid"> -->
                    <p class="social-text"><a href="index.php">Quay lại trang chủ</a></p>
                    <div class="social-media">
                  
                    </div>
                   
                </form>
                    <!--------- Dang Ky -------->
                <form action="" method="post" class="sign-up-form">
                    <h2 class="title">ĐĂNG KÝ</h2>
                    <?php
                    if(isset($insert_customer)){
                        echo $insert_customer;
                        unset($_SESSION['insert_customer']) ;
                        $_SESSION['insert_customer']= $insert_customer;                      
                    }
                   ?>
                   <!-- $_SESSION['insert_customer'] -->
                   
                   
                    <div class="input-field">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" name="fullname" placeholder="Họ và tên" required id="login-fullname">
                        
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required id="login-email">
                    </div>
                    <div class="input-field">
                        <i class="fas fa-address-card"></i>
                        <select name="type" id="">
                            <option value="1">Nhân viên</option>
                            <option value="0">Toàn quyền</option>
                        </select>
                    </div>
                 
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="signupuser" placeholder="Tên đăng nhập" required id="login-signupuser">
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mật khẩu" required id="hiiddenpassword">
<!--                         <div id="eyes" style="margin-top: -63%;"> -->
                        <i  class="far fa-eye-slash" style="margin-left: 600%; margin-top: -100%; cursor: pointer;" id="eyes"></i>
<!--                         </div> -->
                    </div>
                    <input type="submit" name="signup" value="Đăng ký" class="btn solid">
                    <p class="social-text"><a href="index.php">Quay lại trang chủ</a></p>
                    <div class="social-media">
                    <?php 
                    if (isset($_POST['fullname'])) {
                        $login_fullname = $_POST['fullname'];
                        unset($_SESSION['login-fullname']);
                        $_SESSION['login-fullname'] = $login_fullname;
                    }elseif(isset($_SESSION['login-fullname'])){
                        $login_fullname=$_SESSION['login-fullname'];
                    }
                    if (isset($_POST['email'])) {                        
                        $login_email = $_POST['email'];
                        unset($_SESSION['login-email']);
                        $_SESSION['login-email'] = $login_email;
                    }elseif(isset($_SESSION['login-email'])){
                        $login_fullname=$_SESSION['login-email'];
                    } 
                    if (isset($_POST['signupuser'])) {                        
                        $login_signupuser = $_POST['signupuser'];
                        unset($_SESSION['signupuser']);
                        $_SESSION['login-signupuser'] = $login_signupuser;
                    } 
                    if (isset($_POST['password'])) {                        
                        $login_password = $_POST['password'];
                        unset($_SESSION['login-password']);
                        $_SESSION['login-password'] = $login_password;
                    } 
                     ?>
                    </div>
                </form>
            </div>
        </div>
<!--        
//             var tb='Đăng ký tài khoản thành công !';
//     var phpMessage = "<?php echo $insert_customer; ?>";
// if (phpMessage !=tb ) {
//   var
// } else {
//   window.addEventListener('DOMContentLoaded', function() {
//     var btn = document.getElementById('sign-up-btn');
//     btn.click();
//     var nameInput = document.getElementById("login-fullname");
//     nameInput.value = "<?php echo $_SESSION['login-fullname']; ?>";
//     var emailInput = document.getElementById("login-email");
//     emailInput.value = "<?php echo $login_email; ?>";
//     emailInput.style.color = "black";
    
//     var userInput = document.getElementById("login-signupuser");
//     userInput.value = "<?php echo $_SESSION['login-signupuser']; ?>";
//     var passInput = document.getElementById("hiiddenpassword");
//     passInput.value = "<?php echo $_SESSION['login-password']; ?>";
//   });
// } -->


  <script>   
 </script>
        <script language="javascript" type="text/javascript">
            function limitText(limitField, limitNum) {
                if (limitField.value.length > limitNum) {
                    limitField.value = limitField.value.substring(0, limitNum);
                }
            }
        </script>
        <!--  -->
        <div class="panels-container">
                <div class="panel left-panel">
                    <img src="images/logo1.png" alt="" class="image">
                    <div class="content">
                        <h3>Đăng Ký Tại Đây !</h3>
                        <p>Tên tài khoản của bạn sẽ được sử dụng để đăng nhập vào tài khoản của bạn, vì vậy hãy đảm bảo rằng bạn có thể nhớ nó.</p>
                            <button class="btn transparent" id="sign-up-btn">ĐĂNG KÝ</button>
                    </div>
                    
                </div>

                <div class="panel right-panel">
                    <img src="images/logo1.png" alt="" class="image">
                    <div class="content">
                        <h3>Hướng dẫn đăng ký tài khoản ?</h3>
                        <p>Một số hướng dẫn cần chú ý khi đăng ký tài khoản ?</p>
                            <button class="btn transparent" id="sign-in-btn">Lưu Ý</button>
                    </div>
                    
                </div>
        </div>
    </div>
    <script src="js/login.js"></script>
    <script  src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/hiddenpassword.js"></script>
</body>
</html>
