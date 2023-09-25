
<?php include_once('header.php'); 
      include_once('format/format.php');
?>

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
                
                if(isset($_GET['page'])){
                    $numpage=$_GET['page'];
                }else{
                    $numpage=1;
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
                    <!-- <div class="theme-logger">
                        <span class="material-icons-sharp active"> light_mode</span>
                        <span class="material-icons-sharp">dark_mode</span>
                    </div> -->
                    <div class="profile">
                        <div class="info">
                        <?php $chucvu = Session::get('adminType');?>
                             <p  style="margin-bottom: .3rem;">Chào,<b><?php echo Session::get('adminName');?><span style="font-size: .7rem;">(<?php if($chucvu == 0){ echo "Admin";}else{echo "Nhân viên";} ?>)</span></b></p>
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
       
            <!END OF RECENT>
             <div class="sales-analytics">
                    <h2></h2>
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
                        
                        <h1 class="success" style="color: var(--color-info-dark); font-weight:normal;"><?php echo $result['quantity']?></h1>
                      
                       
                          <h3></h3>
                          <?php
                                
                            }
                        }
                        ?>
                        </div>
                    </div>
                
                </div>
              
            </div>
       </div>
           


                      
