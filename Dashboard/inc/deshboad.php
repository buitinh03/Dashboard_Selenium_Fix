
<?php include_once('header.php'); 
    include_once('format/format.php');?>

<?php

$pd = new product();

?>

<?php

// Tổng số lượng sản phẩm
    $chart = $pd->analysischart();
    $test = array();
    $counts = 0;
    while($row = $chart->fetch(PDO::FETCH_ASSOC)){
        $test[$counts]["label"] = "Tổng sản phẩm";
        $test[$counts]["y"] = $row["quantity"];
        $counts += 1;
    }
    ?>





<! END OF ASIDE>
    <link rel="stylesheet" href="css/dashboard.css">
            <main>
            <h1>BẢNG ĐIỀU KHIỂN</h1>
                
                <div class="date" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                 <h3><span id="rank"></span> - Ngày: <span id="dates"></span><br> Giờ:  <span id="coundtime"></span></h3>
                </div>
            
                <div class="insights">
                    
                <?php
                        $tongsanpham =  $pd->tongsanpham('tatcasanpham');
                        if($tongsanpham){
                            while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){

                  
                        ?>
                    
                  
                    <?php
                            }
                        }
                        ?>

                <?php 
                $numpage=1;
                if(isset($_GET['page'])){
                    $numpage=$_GET['page'];
                }
                 ?>
                </div>
                
                
                <div class="recent-updates">
                <h2>Tìm kiếm sản phẩm</h2>
                <div class="updates">
                    
                    
                    <form action="search.php" method="get" class="search-box">
                                <input type="text" name="keyword" placeholder="Nhập sản phẩm cần tìm..." required >
                                <button type="submit" name="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div>
    </main>
    <?php

    $pd = new product();
    $fm = new Format();

?>
<! END OF MAIN>
            <div class="right">
                <div class="top">
                    <button id="menu-btn"><span class="material-icons-sharp">
                        menu</span>
                    </button>
                    <div class="theme-logger">
                        <span class="material-icons-sharp active"> light_mode</span>
                        <span class="material-icons-sharp">dark_mode</span>
                    </div>
                    <div class="profile">
                        <div class="info">
                        <?php $chucvu = Session::get('adminType');?>
                             <p>Chào,<b><?php echo Session::get('adminName');?><span style="font-size: .88rem;">(<?php if($chucvu == 0){ echo "Admin";}else{echo "Nhân viên";} ?>)</span></b></p>
                          <?php
                          if(isset($_GET['action'])&&$_GET['action']=='logout'){
                            Session::unset();
                          }
                          ?>
                            
                            <small class="text-muted" ><a style='font-size:1rem;' href="?action=logout">Đăng xuất</a></small>
                        </div>
                    </div>
                    <div class="profile-photo">
                        <!-- <img src="./images/profile-1.jpg" > -->
                    </div>    
                </div>
            
            <! END OF TOP>
            <!-- <div class="recent-updates">
                <h2>Tìm kiếm sản phẩm</h2>
                <div class="updates"> -->
                    
                    
                    <!-- <form action="search.php" method="post" class="search-box">
                                <input type="text" name="keyword" placeholder="Nhập sản phẩm cần tìm..." required >
                                <button type="submit" name="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div> -->
            <!END OF RECENT>
             <div class="sales-analytics">
                    <h2>Sản phẩm bán chạy</h2>
                    <div class="item online" >
                        <div class="icon" style="background-color: #f97e0e;">
                         <span class="material-icons-sharp"><img src="images/vuongmien1.jpg" alt="" class="img"></span>
                     </div>
                
                        <div class="right">
                  
                         <?php
                         $tongsanpham =  $pd->tongsanpham('tatcasanpham');
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){
 
                   
                         ?>
                         
                         <div class="info">
                                <h3 class="h3"><a href="#"><span>Tổng sản phẩm</span></a></h3>
                         
                         </div>
                        
                        <h1 class="success" style="color: black; font-weight:normal;"><?php echo $result['quantity']?></h1>
                      
                       
                          <h3></h3>
                          <?php
                                
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <a href="?superAdmin"></a>
                    <?php
                  if(isset($_GET['superAdmin'])){

                    ?>
                     <form action="#" method="post"><div class="item add-product">
                        <span class="material-icons-sharp">add</span>
                        <li id="adress-form"><button type="submit" name="runpython" id="runButton"><h3>Cập nhật</h3></button></li>
                                    <?php
                                    if($_SERVER['REQUEST_METHOD']=='POST'){
                                        
                                        if (isset($_POST['runpython'])){
                                            echo '<div class="loading"></div>';
                                            ini_set('max_execution_time', (3600*24*7));
                                            ignore_user_abort(true);
                                            $duongdanf=require('db_config.php');
                                            if($duongdanf['HDH']=='Windows'){
                                                $commanddd= $duongdanf['operation'].' '.$duongdanf['xpathcaogia'];
                                                pclose(popen("start /B $commanddd", "r"));
                                                header("Location: index.php");
                                            }else{
                                                $commanddd= $duongdanf['operation'].' '.$duongdanf['xpathcaogia'];
                                                exec($commanddd.' > /dev/null 2>&1 &');
                                                header('Location: index.php');
                                            }
                                            
                                            
                                        //     echo "<script>
                                        //     swal({
                                        //         title: 'Thông báo',
                                        //         text: 'Quá trình cào giá đã hoàn tất',
                                        //         icon: 'success',
                                        //         timer: 3000,  // Thời gian tự động đóng (3 giây)
                                        //         buttons: false,  // Ẩn nút Close
                                        //         });
                                        //         setTimeout(function () {
                                        //             window.location = 'index.php';
                                        //           }, 4000);
                                        // </script>";
                                            
                                        }

                                    }
                                    
                                    ?>
                               
                                   
                                
                        
                    </div>
                    </form>
                    <?php
                    }else{
                        echo "";
                    }
                    ?>
                
                </div>
              
            </div>
       </div>
           


                      
