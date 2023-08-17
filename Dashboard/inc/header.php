
<?php
    include "connect.php";
?>
<?php 

include_once('lib/session.php');
Session::checkSession();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        // <base href="http://localhost:3000/Dashboard_Selenium_Fix/Dashboard">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ADMIN DASHBOARD</title>
        <!--MATERIAL CDN-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
        <link rel="stylesheet" href="./style.css">    
        <link rel="stylesheet" href="css/detail.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<<<<<<< HEAD
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

=======
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
>>>>>>> a1e80eb37bc1ad88a6f41aab8ac6633d05490f1c
    </head>
    <body>
       <div class="container">
            <aside>

                <div class="top">
                    <div class="logo">
                        <img src="./images/logo1.png">
                        <!-- <h2 class="text-muted">HB<span class="sphone" style="color:#00CC33;"> Pharma</span></h2> -->
                    </div>
                
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>

                    <div class="sidebar">
                        <a href="index.php" for="Dashboard">
                            <span class="material-icons-sharp">space_dashboard</span>
                            <h3 id="Dashboard">Bảng chính</h3>
                        </a>
                        
                          <?php
                        $checkLoginAdmin = Session::get('adminType');
                        $check = Session::get('adminlogin');
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
                            if(isset($_GET['action']) && $_GET['action'] == 'logout') {
                                Session::destroy();
                            }
                        ?>
                        <a href="?action=logout">
                            <span class="material-icons-sharp">logout</span>
                            <h3>Đăng xuất</h3>
                        </a>
                        
                    </div>
                
            </aside>
