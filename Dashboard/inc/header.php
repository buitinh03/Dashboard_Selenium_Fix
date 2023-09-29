<?php
    header("Cache-Control: max-age=604800");
  ?>
<?php
    
    include_once "connect.php";
?>
<?php 

include_once('lib/session.php');
Session::checkSession();
// if(isset($_SESSION['sotrang'])){
//     $numpagecao=$_SESSION['sotrang'];
//  }else {
//     $numpagecao=0;
//     $_SESSION['sotrang']=0;
//  };
if(Session::get('sotrang')){
    $numpagecao=Session::get('sotrang');
}else{
    $numpagecao=0;
    Session::set('sotrang',0);
}
$checkLoginAdmin = Session::get('adminType');
$check = Session::get('adminlogin');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
<!--         <base href="http://localhost:3000/Dashboard_Selenium_Fix/Dashboard"> -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="images/favicon.png"/>
        <title>HB PHARMA</title>
        <!--MATERIAL CDN-->
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
        <link rel="stylesheet" href="./style.css">    
        <link rel="stylesheet" href="css/detail.css">
        <!-- <script>window.history.pushState(null, null, document.URL);
window.addEventListener('popstate', function(event) {
  window.history.pushState(null, null, document.URL);
});</script> -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

    </head>
    <body>
       <div class="container">
            <aside>

                <div class="top">
                    <div class="logo">
                        <a href="index.php" style="width:100%; margin-left:20px; margin-top: 5px;"><img src="./images/logo1.png"></a>
                        <!-- <h2 class="text-muted">HB<span class="sphone" style="color:#00CC33;"> Pharma</span></h2> -->
                    </div>
                
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>

                    <div class="sidebar">
                        <a href="index.php" for="Dashboard">
                            <span class="material-icons-sharp">space_dashboard</span>
                            <h3 id="Dashboard">Trang chủ</h3>
                        </a>
                        
                          <?php
                        ob_start();
                        if($checkLoginAdmin == 0){
                          
                         ?>
                       <a href="register.php">
                            <span class="material-icons-sharp">sms_failed</span>
                            <h3>Tạo tài khoản</h3>
                        </a>
                        <?php
                    
                        }else {
                            echo '';
                        }
                        ?>
                        <?php
                        if($checkLoginAdmin == 0){
                          
                          ?>
                        <a href="views_user.php">
                             <span class="material-icons-sharp">inventory_2</span>
                             <h3>Quản lý tài khoản</h3>
                         </a>
                         <?php
                     
                         }else {
                             echo '';
                         }
                         ?>
                      <!-- <a href="register.php">
                            <span class="material-icons-sharp">insights</span>
                            <h3>Analytics</h3>
                        </a> -->
                     <!--   <a href="#">
                            <span class="material-icons-sharp">mail_outline</span>
                            <h3>Messages</h3>
                            <span class="message-count">26</span>
                        </a>
                        <a href="#">
                            <span class="material-icons-sharp">inventory_2</span>
                            <h3>Products</h3>
                        </a>
                        <a href="#">
                            <span class="material-icons-sharp">sms_failed</span>
                            <h3>Reports</h3>
                        </a>
                        <a href="#">
                            <span class="material-icons-sharp">settings</span>
                            <h3>Settings</h3>
                        </a>
                        <a href="#">
                            <span class="material-icons-sharp">add</span>
                            <h3>Add Product</h3>
                        </a>  -->
                        <!-- <a href="#" id="nextPageButton">Xem thêm</a> -->
                        
                        <?php
                            // if(isset($_GET['action']) && $_GET['action'] == 'logout') {
                            //     Session::destroy();
                            //     ob_end_flush();
                            // }
                        ?>
                        <a href="#">
                            <span class="material-icons-sharp"></span>
                            <h3></h3>
                        </a>
                        <script>
                            window.onkeydown = function(event) {
  if (event.keyCode === 37) { // keyCode của nút mũi tên bên trái
    history.go(-1);
  }
};


                        </script>
                        
                    </div>
                
            </aside>
            
