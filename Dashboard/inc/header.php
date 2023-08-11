<?php
    include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ADMIN DASHBOARD</title>
        <!--MATERIAL CDN-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp">
        <link rel="stylesheet" href="./style.css">    
        <link rel="stylesheet" href="css/detail.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <!-- class="active" -->
                      <a href="productview.php" >
                            <!-- <span class="material-icons-sharp">person_outline</span> -->
                            <span class="material-icons-sharp">local_mall</span>
                            <h3>Sản phẩm phụ</h3>
                        </a> 
                        <!-- <a href="#">
                            <span class="material-icons-sharp">local_mall</span>
                            <h3>Orders</h3>
                        </a>
                        <a href="#">
                            <span class="material-icons-sharp">insights</span>
                            <h3>Analytics</h3>
                        </a>
                        <a href="#">
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
                        <a href="#">
                            <span class="material-icons-sharp">logout</span>
                            <h3>Đăng xuất</h3>
                        </a>
                        
                    </div>
                
            </aside>