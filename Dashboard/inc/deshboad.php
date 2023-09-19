
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
                    <div class="theme-logger">
                        <span class="material-icons-sharp active"> light_mode</span>
                        <span class="material-icons-sharp">dark_mode</span>
                    </div>
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
                
                    <div class="item add-product">
                        <span class="material-icons-sharp">add</span>
                
                        <li id="adress-form"><a href="#"><h3>Cập nhật</h3></a></li>
                        <div class="adress-form">
                            <div class="adress-form-content">
                                <h2>Cào Dữ Liệu Website <span id="adress-close">X Đóng</span></h2>
                                    <form action="#" method="post">
                                   <p style="font-weight: bolder;">Chọn website bạn muốn thực hiện cào</p>
                                   
                                   <label class="containerr" style="font-weight: 400;">Thuocsi.vn
                                        <input type="checkbox" name='thuocsi' value="thuocsi" id="checkbox-1">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">Chosithuoc.com
                                        <input type="checkbox" name='chosithuoc' value="chosithuoc" id="checkbox-2">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">NhathuocAnKhang.com
                                        <input type="checkbox" name='ankhang' value="ankhang" id="checkbox-3">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">Thuocsi.pharex.vn
                                        <input type="checkbox" name='pharex' value="pharex" id="checkbox-4">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">Pharmacity.vn
                                        <input type="checkbox" name='pharmacity' value="pharmacity" id="checkbox-5">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">NhathuocLongchau.com.vn
                                        <input type="checkbox" name='longchau' value="longchau" id="checkbox-6">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">medigoapp.com
                                        <input type="checkbox" name='medigoapp' value="medigoapp" id="checkbox-7">
                                        <span class="checkmark"></span>
                                        </label>

                                        <label class="containerr" style="font-weight: 400;">Tất cả
                                        <input type="checkbox" name="alll" value='alll' id="checkbox-8">
                                        <span class="checkmark"></span>
                                        </label>
                                    <button type="submit" name="runpython" id="runButton">Xác nhận</button><br><br>
                                    <label for="" style="font-size: 1rem;">Quá trình cào dữ liệu có thể mất khá nhiều thời gian, vui lòng chờ !</label>
                                    <script>
                                        const chk1=document.getElementById("checkbox-1");
                                        const chk2=document.getElementById("checkbox-2");
                                        const chk3=document.getElementById("checkbox-3");
                                        const chk4=document.getElementById("checkbox-4");
                                        const chk5=document.getElementById("checkbox-5");
                                        const chk6=document.getElementById("checkbox-6");
                                        const chk7=document.getElementById("checkbox-7");
                                        const chk8=document.getElementById("checkbox-8");
                                        chk1.addEventListener('change',function(){  
                                                                                    
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        // //
                                        chk2.addEventListener('change',function(){ 
                                                                                       
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        //
                                        chk3.addEventListener('change',function(){ 
                                                                                      
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        chk4.addEventListener('change',function(){ 
                                                                                      
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        chk5.addEventListener('change',function(){ 
                                            
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        chk6.addEventListener('change',function(){ 
                                                                                    
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        chk7.addEventListener('change',function(){ 
                                                                                    
                                            if (chk1.checked||chk2.checked||chk3.checked||chk4.checked||chk5.checked||chk6.checked||chk7.checked) {                                            
                                                chk8.disabled = true;

                                            } else {                                            
                                                chk8.disabled = false;
                                            }
                                        })
                                        //
                                        chk8.addEventListener('change',function(){  
                                                                                      
                                        if(chk8.checked){
                                            chk1.disabled=true;
                                            chk2.disabled=true;
                                            chk3.disabled=true;
                                            chk4.disabled=true;
                                            chk5.disabled=true;
                                            chk6.disabled=true;
                                            chk7.disabled=true;
                                        }else{
                                            chk1.disabled=false;
                                            chk2.disabled=false;
                                            chk3.disabled=false;
                                            chk4.disabled=false; 
                                            chk5.disabled=false;
                                            chk6.disabled=false;    
                                            chk7.disabled=false;                                                                           
                                        }
                                    })
                                       
                                    </script>
                                    <script>
                   document.getElementById("runButton").addEventListener("click",function(){
                        var fun=[a,b]
                        for(var i=0;i<fun.length;i++){
                            fun[i]();
                        }
                    })
                    function a(){
                    // Thực hiện một yêu cầu HTTP (AJAX) để chạy file Python
                    setTimeout(function(){
                        document.querySelector('.adress-form').style.display = "none";
                        
                    },5000)
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "/run-python", true); // Đổi "/run-python" thành URL tương ứng với file Python của bạn
                    xhr.send();
                    
                    // Xử lý kết quả từ server (nếu cần thiết)
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;                       
                        }                        
                    }; 
                                 
                    };
                    function b(){                        
                        swal({
                        title: "Thông báo",
                        text: "Quá trình cào giá đang diễn ra, vui lòng chờ ...",
                        icon: "success",
                        timer: 3000, 
                        buttons: false,
                        });
                        setTimeout(function() {   <?php sleep(1)?>                             
                            }, 4000);
                            
                    }
                    </script>
                                    
                                    <?php
                                    $duongdan=require('db_config.php');
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                        if (isset($_POST['runpython'])) {
                                            echo '<div class="loading"></div>';
                                            ini_set('max_execution_time', (3600 * 24 * 7));
                                            ignore_user_abort(true);
                                            if (isset($_POST['alll'])) {
                                                
                                                if (
                                                        file_exists($duongdan['xpathcaogiachosithuoc']) &&
                                                        file_exists($duongdan['xpathcaogiathuocsi']) &&
                                                        file_exists($duongdan['xpathcaogiaankhang']) &&
                                                        file_exists($duongdan['xpathcaogiapharex']) &&
                                                        file_exists($duongdan['xpathcaogialongchau']) &&
                                                        file_exists($duongdan['xpathcaogiapharma']) &&
                                                        file_exists($duongdan['xpathcaogiamedigo'])) {
                                                    exec('python '.$duongdan['xpathcaogiachosithuoc'].' && python '.$duongdan['xpathcaogiathuocsi'].' && python '.$duongdan['xpathcaogiaankhang'].' && python '.$duongdan['xpathcaogiapharex'].' && '.$duongdan['xpathcaogialongchau'].' && python '.$duongdan['xpathcaogiapharma'].' && python '.$duongdan['xpathcaogiamedigo'],$output,$exit_code);
                                                    if($exit_code != 0){
                                                        echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Lỗi file',
                                                        icon: 'error',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                        setTimeout(function () {
                                                            window.location='index.php' 
                                                          }, 4000);
                                                </script>";
                                                foreach ($output as $line) {
                                                    echo $line . "\n";
                                                }  
                                            }   
                                                    else{

                                                    
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Quá trình cào giá đã hoàn tất',
                                                        icon: 'success',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                        setTimeout(function () {
                                                            window.location='index.php'  
                                                          }, 4000);
                                                </script>";}  }                                                  
                                             else {
                                                echo "<script>
                                                swal({
                                                    title: 'Thông báo',
                                                    text: 'File không tồn tại!',
                                                    icon: 'error',
                                                    timer: 3000,
                                                    buttons: false,
                                                });
                                                setTimeout(function() {
                                                    window.location='index.php'  
                                                }, 4000);
                                                </script>";}
                                            }
                                            } else {
                                                // Thêm phần xử lý cho các đường dẫn khác ở đây
                                                if (isset($_POST['thuocsi'])) {
                                                 if(file_exists($duongdan['xpathcaogiathuocsi'])){
                                                    exec('python '.$duongdan['xpathcaogiathuocsi'],$output,$exit_code);
                                                    if($exit_code != 0){
                                                        echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Lỗi file thuocsi.py',
                                                        icon: 'error',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                        setTimeout(function () {
                                                            window.location='index.php' 
                                                          }, 4000);
                                                </script>";
                                                foreach ($output as $line) {
                                                    echo $line . "\n";
                                                }  
                                            }   
                                                    else{

                                                    
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Quá trình cào giá đã hoàn tất',
                                                        icon: 'success',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                        setTimeout(function () {
                                                            window.location='index.php'  
                                                          }, 4000);
                                                </script>";}  }                                                  
                                             else {
                                                echo "<script>
                                                swal({
                                                    title: 'Thông báo',
                                                    text: 'File thuocsi.py không tồn tại!',
                                                    icon: 'error',
                                                    timer: 3000,
                                                    buttons: false,
                                                });
                                                setTimeout(function() {
                                                    window.location='index.php'  
                                                }, 4000);
                                                </script>";}
                                            }
                                                if(isset($_POST['chosithuoc'])){
                                                        if(file_exists($duongdan['xpathcaogiachosithuoc'])){
                                                            exec('python '.$duongdan['xpathcaogiachosithuoc'],$output,$exit_code);
                                                            if($exit_code != 0){
                                                                echo "<script>
                                                            swal({
                                                                title: 'Thông báo',
                                                                text: 'Lỗi file chosithuoc.py',
                                                                icon: 'error',
                                                                timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                                buttons: false,  // Ẩn nút Close
                                                                });
                                                                setTimeout(function () {
                                                                    window.location='index.php' 
                                                                  }, 4000);
                                                        </script>";
                                                        foreach ($output as $line) {
                                                            echo $line . "\n";
                                                        }  
                                                    }   
                                                            else{
    
                                                            
                                                            echo "<script>
                                                            swal({
                                                                title: 'Thông báo',
                                                                text: 'Quá trình cào giá đã hoàn tất',
                                                                icon: 'success',
                                                                timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                                buttons: false,  // Ẩn nút Close
                                                                });
                                                                setTimeout(function () {
                                                                    window.location='index.php'  
                                                                  }, 4000);
                                                        </script>";}  }                                                  
                                                     else {
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'File chosithuoc.py không tồn tại!',
                                                            icon: 'error',
                                                            timer: 3000,
                                                            buttons: false,
                                                        });
                                                        setTimeout(function() {
                                                            window.location='index.php'  
                                                        }, 4000);
                                                        </script>";}
                                                    }
                                                if(isset($_POST['ankhang'])){
                                                    if(file_exists($duongdan['xpathcaogiaankhang'])){
                                                        exec('python '.$duongdan['xpathcaogiaankhang'],$output,$exit_code);
                                                        if($exit_code != 0){
                                                            echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Lỗi file ankhang.py',
                                                            icon: 'error',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php' 
                                                              }, 4000);
                                                    </script>";
                                                    foreach ($output as $line) {
                                                        echo $line . "\n";
                                                    }  
                                                }   
                                                        else{

                                                        
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Quá trình cào giá đã hoàn tất',
                                                            icon: 'success',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php'  
                                                              }, 4000);
                                                    </script>";}  }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File ankhang.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location='index.php'  
                                                    }, 4000);
                                                    </script>";}
                                                }
                                                if(isset($_POST['pharex'])){
                                                    if(file_exists($duongdan['xpathcaogiapharex'])){
                                                        exec('python '.$duongdan['xpathcaogiapharex'].' > /dev/null 2>&1 & echo $!',$output,$exit_code);
                                                        if($exit_code != 0){
                                                            echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Lỗi file pharex.py',
                                                            icon: 'error',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php' 
                                                              }, 4000);
                                                    </script>";
                                                    foreach ($output as $line) {
                                                        echo $line . "\n";
                                                    }  
                                                }   
                                                        else{

                                                        
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Quá trình cào giá đã hoàn tất',
                                                            icon: 'success',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php'  
                                                              }, 4000);
                                                    </script>";}  }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File pharex.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location='index.php'  
                                                    }, 4000);
                                                    </script>";}
                                                }
                                                  
                                                if(isset($_POST['longchau'])){
                                                    if(file_exists($duongdan['xpathcaogialongchau'])){
                                                        exec('python '.$duongdan['xpathcaogialongchau'],$output,$exit_code);
                                                        if($exit_code != 0){
                                                            echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Lỗi file longchau.py',
                                                            icon: 'error',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php' 
                                                              }, 4000);
                                                    </script>";
                                                    foreach ($output as $line) {
                                                        echo $line . "\n";
                                                    }  
                                                }   
                                                        else{

                                                        
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Quá trình cào giá đã hoàn tất',
                                                            icon: 'success',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php'  
                                                              }, 4000);
                                                    </script>";}  }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File longchau.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location='index.php'  
                                                    }, 4000);
                                                    </script>";}
                                                }
                                                if(isset($_POST['pharmacity'])){
                                                    if(file_exists($duongdan['xpathcaogiapharma'])){
                                                        exec('python '.$duongdan['xpathcaogiapharma'],$output,$exit_code);
                                                        if($exit_code != 0){
                                                            echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Lỗi file pharmacity.py',
                                                            icon: 'error',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php' 
                                                              }, 4000);
                                                    </script>";
                                                    foreach ($output as $line) {
                                                        echo $line . "\n";
                                                    }  
                                                }   
                                                        else{

                                                        
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Quá trình cào giá đã hoàn tất',
                                                            icon: 'success',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php'  
                                                              }, 4000);
                                                    </script>";}  }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File pharmacity.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location='index.php'  
                                                    }, 4000);
                                                    </script>";}
                                                }
                                                if(isset($_POST['medigoapp'])){
                                                    if(file_exists($duongdan['xpathcaogiamedigo'])){
                                                        exec('python '.$duongdan['xpathcaogiamedigo'],$output,$exit_code);
                                                        if($exit_code != 0){
                                                            echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Lỗi file medigo.py',
                                                            icon: 'error',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php' 
                                                              }, 4000);
                                                    </script>";
                                                    foreach ($output as $line) {
                                                        echo $line . "\n";
                                                    }  
                                                }   
                                                        else{

                                                        
                                                        echo "<script>
                                                        swal({
                                                            title: 'Thông báo',
                                                            text: 'Quá trình cào giá đã hoàn tất',
                                                            icon: 'success',
                                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                            buttons: false,  // Ẩn nút Close
                                                            });
                                                            setTimeout(function () {
                                                                window.location='index.php'  
                                                              }, 4000);
                                                    </script>";}  }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File medigo.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location='index.php'  
                                                    }, 4000);
                                                    </script>";}
                                                }
                                                // echo "<script>
                                                    
                                                //         setTimeout(function () {
                                                //             window.location='index.php'
                                                //           }, 4000);
                                                // </script>";
                                            }
                                        
                                    }
                                    
                                    
                                    ?>
                                </form>
                                   
                                
                            </div>
                        </div>
                        <script>
                            // Click vào Button Địa chỉ
                            const adressbtn = document.querySelector('#adress-form')
                            // Click vào nút đóng ở phần địa chỉ giao hàng
                            const adressclose = document.querySelector('#adress-close')

                            // const rightbtn = document.querySelector('.fa-chevron-right')
                            // console.log(rightbtn)
                            adressbtn.addEventListener("click", function(){
                                document.querySelector('.adress-form').style.display = "flex"
                            })

                            adressclose.addEventListener("click", function(){
                                document.querySelector('.adress-form').style.display = "none"
                            })

                        </script>
                    </div>
                        </a>
                   
                    <?php
                    }else{
                        echo "";
                    }
                    ?>
                
                </div>
              
            </div>
       </div>
           


                      
