
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

        <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
<link rel="stylesheet" href="css/search_css.css">
 
      <?php $fm = new Format();
    $product=new product();
    $trangthu=1;
    $from=1;
    $to=1;
    
    if($_SERVER["REQUEST_METHOD"]== 'GET' && isset($_GET['submit'])){
        $search=$_GET['keyword'];
        
        $_SESSION['search']=$search;
        unset($_SESSION['mach']);
    }elseif(isset($_GET['masp'])){
        $search=$_GET['masp'];
        $_SESSION['search']=$search;
        $_SESSION['mach']=$search;
    }elseif(isset($_SESSION['search'])){
        $search=$_SESSION['search'];
    }
//
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submitMasp'])){
        $id = $_GET['id_p'];
        $id_product = $_GET['text'];

        $insert_id_product = $product->insert_id_product($id, $id_product);
        if($insert_id_product){
                                                        echo "<script>
                                                            swal({
                                                                title: 'Thông báo',
                                                                text: 'Thêm mã chuyển hóa thành công',
                                                                icon: 'success',
                                                                timer: 3000,
                                                                buttons: false,
                                                            });
                                                           
                                                            </script>";
                                                    }
                                                    else{
                                                        echo "<script>
                                                            swal({
                                                                title: 'Thông báo',
                                                                text: 'Thêm mã chuyển hóa không thành công',
                                                                icon: 'error',
                                                                timer: 3000,
                                                                buttons: false,
                                                            });
                                                            
                                                            </script>";
                                                    }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submitMasp_sua'])){
        $id_sua = $_GET['id_p_sua'];
        $id_product_sua = $_GET['text_sua'];

        $insert_id_product_sua = $product->insert_id_product_sua($id_sua, $id_product_sua);
        if($insert_id_product_sua){
            echo "<script>
                swal({
                    title: 'Thông báo',
                    text: 'Sửa mã chuyển hóa thành công',
                    icon: 'success',
                    timer: 3000,
                    buttons: false,
                });
                
                </script>";
        }
        else{
            echo "<script>
                swal({
                    title: 'Thông báo',
                    text: 'Sửa mã chuyển hóa không thành công',
                    icon: 'error',
                    timer: 3000,
                    buttons: false,
                });
                
                </script>";
        }
    }
    
    
       
//
    // $search=$_SESSION['search'];
    if(isset($_GET['masp']) or isset($_SESSION['mach'])){
        $demtrang = $product->count_search_xemthem($search);
    }else{
        $demtrang = $product->count_search($search);
    }
    $demd = $demtrang->fetch();
    $sotrang=$demd['count'];
    $trang=ceil($sotrang/10);
    $_SESSION['sotrangsearch']=$trang;

    if(isset($_GET['page'])){
        $trangthu=$_GET['page'];
        $from=$trangthu-4; if($from<3){$from=2;}
        $to=$trangthu+4; if($to>$trang){$to=$trang-1;}
        $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
        $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
    }else{        
        $from=$trangthu-4; if($trangthu<4){$from=2;}
        $to=$trangthu+4; if($to>$trang){$to=$trang-1;}
        $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
        $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
    }

    
    
     

    
    $giabd=[];
    $tenbd=[];
    $nguonbd=[];
?>
                </div>
                <div class="recent-order">
                <style>
                        #pagination {
                            display: flex;
                            text-align: center;
                            justify-content: center;
                        }
                        #pagination a{
                            display: flex;
                            text-align: center;
                            padding: 5px 8px;
                            margin: 5px;
                            background:bisque;
                            border-radius: 3px;
                        }
                        #pagination a:hover{
                            color: #0000BB;
                            background: #fff;
                        }
                        .bloc p{
                            /* position:relative; */
                            color: chocolate;
                            /* margin-top: .5rem;                         
                            margin-left: .5rem; */
                        }
                        #pagination .bloc select{
                                
                                text-align: center;
                                padding: 7px 20px 7px 8px;
                             
                                background: bisque;
                                border-radius: 3px;
                              
                                color: #7380ec;
                                margin-left: 5px; 
                        }
                        
                        #pagination .bloc i{
                            position: relative;
                            left: -1.3rem;
                            color: chocolate;
                        }
                                                
                    </style>
                    <h2>TỪ KHÓA TÌM KIẾM: <?php
                                        if($checkLoginAdmin == 0){
                                        ?><li id="adress-form1" ><a href="#"><h3 style="margin-left: .5rem;font-size: 1.2rem;font-weight: bold;color: #7380ec;background: bisque;padding: 5px;margin-right: .5rem;margin-top: -.5rem;border-radius: 5px;">Cập nhật</h3></a></li><?php }?>
                         <?php if(isset($_SESSION['search'])){echo $_SESSION['search']; } elseif(isset($search)) {echo $search;}?> </h2>
                    
                    
                        <div class="adress-form1">
                            <div class="adress-form-content">
                                <h2>Cào Dữ Liệu Website <span id="adress-close1">X Đóng</span></h2>

                                    <form action="#" method="post">
                                   <p style="font-weight: bolder;">Bạn có muốn thực hiện cào giá theo từ khóa: </p>
                                   <h5><?php echo $search ?></h5>

                                   <button type="submit" name="Capnhattimkiem" id="runButton1">Xác nhận</button><br><br>
                                    <label for="" style="font-size: 1rem; margin: 0 auto;">Quá trình cào dữ liệu có thể mất khá nhiều thời gian, vui lòng chờ !</label>
                                    <script>
                                document.getElementById("runButton1").addEventListener("click",function(){
                                        var fun=[a,b]
                                        for(var i=0;i<fun.length;i++){
                                            fun[i]();
                                        }
                                    })
                                    function a(){
                                    // Thực hiện một yêu cầu HTTP (AJAX) để chạy file Python
                                    setTimeout(function(){
                                        document.querySelector('.adress-form1').style.display = "none";
                                        
                                    },5000)  
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
                            if($_SERVER['REQUEST_METHOD']=='POST'){
                                if(isset($_POST['Capnhattimkiem'])){
                                    
                                    $duongdanf=require('db_config.php');
                                    if(!file_exists($duongdanf['xpathcaogiathuocsi_link'])){
                                        echo "<script>
                                                swal({
                                                    title: 'Thông báo',
                                                    text: 'File thuocsi.py không tồn tại!',
                                                    icon: 'error',
                                                    timer: 3000,
                                                    buttons: false,
                                                });
                                                </script>";}
                                    if(!file_exists($duongdanf['xpathcaogiapharex_link'])){
                                        echo "<script>
                                                swal({
                                                    title: 'Thông báo',
                                                    text: 'File pharex.py không tồn tại!',
                                                    icon: 'error',
                                                    timer: 3000,
                                                    buttons: false,
                                                });
                                                </script>";}
                                if(!file_exists($duongdanf['xpathcaogiamedigo_link'])){
                                    echo "<script>
                                            swal({
                                                title: 'Thông báo',
                                                text: 'File medigo.py không tồn tại!',
                                                icon: 'error',
                                                timer: 3000,
                                                buttons: false,
                                            });
                                            </script>";}
                                if(!file_exists($duongdanf['xpathcaogiapharma_link'])){
                                    echo "<script>
                                            swal({
                                                title: 'Thông báo',
                                                text: 'File pharmacity.py không tồn tại!',
                                                icon: 'error',
                                                timer: 3000,
                                                buttons: false,
                                            });
                                            </script>";}
                                            ini_set('max_execution_time', (3600*24*7));
                                            ignore_user_abort(true);
                                            $pro = new product();
                                    $sc=$pro->search_capnhat($search,'thuocsi.vn');
                                   
                                    $tam;
                                    $qww='';
                                    $qww1='';
                                    $qww2='';
                                    $qww3='';
                                    $qww4='';
                                    $qww5='';
                                    $qww6= '';
                                    $qwwd=0;
                                    $qwwd1=0;
                                    $qwwd2=0;
                                    $qwwd3=0;
                                    $qwwd4=0;
                                    $qwwd5=0;
                                    $qwwd6=0;
                                    $loii=$loii1=$loii2= $loii3= $loii4= $loii5= $loii6='';
                                    $demloi=0;
                                    $po=1;
                                     while($la=$sc->fetch()){
                                       $tam=$la['link']; 
                                       $qww=$qww.' '.$tam ;
                                       $qwwd=$qwwd+1;
                                    }
                                    $sc1=$pro->search_capnhat($search,'pharmacity.vn');
                                    while($la1=$sc1->fetch()){
                                        $tam=$la1['link']; 
                                        $qww1=$qww1.' '.$tam ;
                                        $qwwd1=$qwwd1+1;
                                    }
                                    $sc2=$pro->search_capnhat($search,'thuocsi.pharex.vn');
                                    while($la2=$sc2->fetch()){
                                        $tam=$la2['link']; 
                                       $qww2=$qww2.' '.$tam ;
                                       $qwwd2=$qwwd2+1;
                                    }
                                    $sc3=$pro->search_capnhat($search,'medigoapp.com');
                                    while($la3=$sc3->fetch()){
                                        $tam=$la3['link']; 
                                       $qww3=$qww3.' '.$tam ; 
                                       $qwwd3=$qwwd3+1;
                                    }
                                    $sc4=$pro->search_capnhat($search,'ankhang.com');
                                    while($la4=$sc4->fetch()){
                                        $tam=$la4['link']; 
                                        $qww4=$qww4.' '.$tam ;
                                        $qwwd4=$qwwd4+1;
                                    }
                                    $sc5=$pro->search_capnhat($search,'longchau.vn');
                                    while($la5=$sc5->fetch()){
                                        $tam=$la5['link']; 
                                       $qww5=$qww5.' '.$tam ;
                                       $qwwd5=$qwwd5+1;
                                    }
                                    $sc6=$pro->search_capnhat($search,'chosithuoc.com');
                                    while($la6=$sc6->fetch()){
                                        $tam=$la6['link']; 
                                       $qww6=$qww6.' '.$tam ;
                                       $qwwd6=$qwwd6+1;
                                    }if($qwwd>0){
                                        if(file_exists($duongdanf['xpathcaogiathuocsi_link'])){
                                        exec('python '.$duongdanf['xpathcaogiathuocsi_link'] .$qww,$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii='thuocsi_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                          }                                                 
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File thuocsi_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                    }}
                                    if($qwwd1>0){
                                        
                                        if(file_exists($duongdanf['xpathcaogiapharma_link'])){
                                       exec('python '.$duongdanf['xpathcaogiapharma_link'] .$qww1,$output,$exit_code);
                                       if($exit_code != 0){
                                           $loii1='pharmacity_link.py';
                                        $demloi=$demloi+1;
                                   foreach ($output as $line) {
                                       echo $line . "\n";
                                   }  
                               }   
                                
                                                        }else {
                                                            echo "<script>
                                                            swal({
                                                                title: 'Thông báo',
                                                                text: 'File pharmacity_link.py không tồn tại!',
                                                                icon: 'error',
                                                                timer: 3000,
                                                                buttons: false,
                                                            });
                                                            setTimeout(function() {
                                                                window.location = 'search.php';
                                                            }, 4000);
                                                            </script>";
                                            }
                                    }
                                    if($qwwd2>0){
                                        if(file_exists($duongdanf['xpathcaogiapharex_link'])){
                                        exec('python '.$duongdanf['xpathcaogiapharex_link'] .$qww2.'',$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii2='pharex_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                          }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File pharex_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                        
                                    }}
                                    if($qwwd3>0){
                                        if(file_exists($duongdanf['xpathcaogiamedigo_link'])){
                                        exec('python '.$duongdanf['xpathcaogiamedigo_link'] .$qww3.'',$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii3='medigo_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                         }                                                  
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File medigo_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                       
                                    }}
                                    if($qwwd4>0){
                                        if(file_exists($duongdanf['xpathcaogiaankhang_link'])){
                                        exec('python '.$duongdanf['xpathcaogiaankhang_link'] .$qww4,$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii4='ankhang_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                                }                                            
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File ankhang_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                        
                                    }}
                                    if($qwwd5>0){
                                        if(file_exists($duongdanf['xpathcaogialongchau_link'])){
                                        exec('python '.$duongdanf['xpathcaogialongchau_link'] .$qww5,$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii5='longchau_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                             }                                               
                                                 else {
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File longchau_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                        
                                    }}
                                    if($qwwd6>0){
                                        if(file_exists($duongdanf['xpathcaogiachosithuoc_link'])){
                                        exec('python '.$duongdanf['xpathcaogiachosithuoc_link'] .$qww6,$output,$exit_code);
                                        if($exit_code != 0){
                                            $loii6='chosithuoc_link.py';
                                        $demloi=$demloi+1;
                                    foreach ($output as $line) {
                                        echo $line . "\n";
                                    }  
                                }   
                                             }                                               
                                                 else {
                                                    
                                                    echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'File chosithuoc_link.py không tồn tại!',
                                                        icon: 'error',
                                                        timer: 3000,
                                                        buttons: false,
                                                    });
                                                    setTimeout(function() {
                                                        window.location = 'search.php';
                                                    }, 4000);
                                                    </script>";
                                        
                                    }}
                                    if($demloi>0){
                                    ?>
                                    <script>
                                        swal({
                                            title: 'Thông báo',
                                            text: 'Lỗi file '+<?php echo $loii.' '.$loii1.' '.$loii2.' '.$loii3.' '.$loii4.' '.$loii5.' '.$loii6 ?>,
                                            icon: 'error',
                                            timer: 3000,  // Thời gian tự động đóng (3 giây)
                                            buttons: false,  // Ẩn nút Close
                                            });
                                            setTimeout(function () {
                                                window.location='index.php' 
                                              }, 4000);
                                    </script>
                                    <?php
                                    }
                                    if($demloi<7){
                                        ?><script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Quá trình cào giá đã hoàn tất',
                                                        icon: 'success',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                        setTimeout(function () {
                                                            window.location = 'search.php';
                                                          }, 4000);
                                                </script><?php
                                    }
                                    
                                }
                            }
                         ?>
                    </form>
                            </div>
                        </div>
                     
                        <script>
                            // Click vào Button Địa chỉ
                            const adressbtn1 = document.querySelector('#adress-form1')
                            // Click vào nút đóng ở phần địa chỉ giao hàng
                            const adressclose1 = document.querySelector('#adress-close1')

                            // const rightbtn = document.querySelector('.fa-chevron-right')
                            // console.log(rightbtn)
                            adressbtn1.addEventListener("click", function(){
                                document.querySelector('.adress-form1').style.display = "flex"
                            })

                            adressclose1.addEventListener("click", function(){
                                document.querySelector('.adress-form1').style.display = "none"
                            })

                        </script>
                    <?php if($trang>1){
                    ?>
                    <div id="pagination">
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&page=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="start">1</a>

                            <?php
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="pa".($i);
                            }
                            $next=1; 
                            if(($from-1)>1){
                                ?>
                            <a href="#">...</a>
                            
                            <?php    
                            }
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($trang)?>" id="end"><?php echo $trang?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                       
                        <div class="bloc" style="display: flex;align-items: center;/* background: bisque; */border-radius: 3px;margin: 5px 5px 5px 3rem;">
                        <p>Sắp xếp theo: 
                        <form method="POST" action="" class="boloc" >
                        <!-- <i class="fa fa-caret-down dropdown__caret"></i> -->
                            <select  name="myComboBox" onchange="this.form.submit()">
                                <option value="option1" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option1') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option1'){echo "selected";} ?>>Giá lệch</option> <i class="fa fa-caret-down dropdown__caret"></i>
                                <option value="option2" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option2') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option2'){echo "selected";} ?>>Thời gian</option><i class="fa fa-caret-down dropdown__caret"></i>
                            </select>                 
                            <noscript><button type="submit">Submit</button></noscript>                        
                            <?php
                            
                            if (isset($_POST['myComboBox'])) {
                                $selectedValue = $_POST['myComboBox'];
                                unset($_SESSION['selectedValue']);
                                $_SESSION['selectedValue'] = $selectedValue;
                            }elseif(isset($_SESSION['selectedValue'])){
                                $selectedValue=$_SESSION['selectedValue'];
                            } else {$selectedValue='option1';}
                            ?>
                            <i class="fa fa-caret-down dropdown__caret"></i>
                        </form></p>
                        
                    </div>
                    </div>
                    <?php }else{ ?>
                        <div id="pagination" >
                           
                       
                        <div class="bloc" style="display: flex;align-items: center;/* background: bisque; */border-radius: 3px;margin: 5px 5px 5px 3rem;">
                        <p>Sắp xếp theo: 
                        <form method="POST" action="" class="boloc" >
                        <!-- <i class="fa fa-caret-down dropdown__caret"></i> -->
                            <select  name="myComboBox" onchange="this.form.submit()">
                                <option value="option1" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option1') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option1'){echo "selected";} ?>>Giá lệch</option> <i class="fa fa-caret-down dropdown__caret"></i>
                                <option value="option2" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option2') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option2'){echo "selected";} ?>>Thời gian</option><i class="fa fa-caret-down dropdown__caret"></i>
                            </select>                 
                            <noscript><button type="submit">Submit</button></noscript>                        
                            <?php
                            
                            if (isset($_POST['myComboBox'])) {
                                $selectedValue = $_POST['myComboBox'];
                                unset($_SESSION['selectedValue']);
                                $_SESSION['selectedValue'] = $selectedValue;
                            }elseif(isset($_SESSION['selectedValue'])){
                                $selectedValue=$_SESSION['selectedValue'];
                            } else {$selectedValue='option1';}
                            ?>
                            <i class="fa fa-caret-down dropdown__caret"></i>
                        </form></p>
                        
                    </div>
                    
                    </div>
                    <?php } ?>
                    <?php if(isset($_GET['masp']) or isset($_SESSION['mach'])){
                        if(!empty($selectedValue)){
                            $product_search=$product->search_xemthem($selectedValue,$_SESSION['search'],$trangthu,10);
                        }else{$product_search=$product->search_xemthem('option1',$_SESSION['search'],$trangthu,10);}
                       
                    }else{
                           $product_search=$product->search($selectedValue,$_SESSION['search'],$trangthu,10);
                 
                    }
                    ?>

                    <table>
                    
                        <thead style="color:#FF8247;">
                                    <tr>
                                        <th>STT</th>
                                        <th>TÊN SẢN PHẨM</th>
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <th>GIÁ CŨ</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ MỚI</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ LỆCH</th>
                                        <?php
                                        }else{
                                        ?>
                                        <th>GIÁ CŨ</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ MỚI</th>
                                        <th>THỜI GIAN</th>
                                        <?php
                                        }
                                        ?>
                                        <th>NGUỒN</th>
                                        <th>ẢNH</th>
                                        <th>MÃ CHUẨN HÓA</th>
                                        <th>CHỨC NĂNG</th>
                                        <?php
                                            for($k=1;$k<=12;$k++){
                                                ?>
                                                <th hidden>MONTH_<?php echo $k ?></th>
                                        <?php
                                            }
                                        ?>
                                        
                                    </tr>
                                </thead>
                        <?php 
                        $format = new Format();
                        if(!empty($product_search) ){
                            $j=0;
                            while($set = $product_search->fetch()){
                                $giabd[$j]=$set['giamoi'];
                                $tenbd[$j]=$set['title'];
                                $nguonbd[$j]=$set['nguon'];
                                $j++
                        ?>
                                                         <tbody>
                                    <tr onclick="handleClick(event)" id="tbody" class="tr" style="font-size: 1rem;">
                                        <td><?php echo $j;?></td>
                                        <td class="title"><a style="color: var(--color-info-dark); font-weight:bold;" href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <?php 
                                        if(is_null($set['giacu'])){
                                        ?>
                                        <td  style="text-align: center;">-</td>
                                        <td  style="text-align: center;">-</td>
                                        <?php   
                                        }else{
                                        ?>
                                        <?php if($set['giacu'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                        <?php
                                        }elseif($set['giacu'] == ''){
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson">-</td>
                                        <?php } else {
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                        <?php } ?>
                                            
                                        <td  style="text-align: center; padding-left: 5px; width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                        <?php
                                        }elseif($set['giamoi'] == ''){
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson">-</td>
                                        <?php } else {
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>

                                        <td  style="text-align: center; padding-left: 5px;  width: 10%;"><?php echo $set['ngaymoi']; ?></td>

                                        
                                        <?php
                                            if($set['giamoi']!=0&&$set['giamoi']!=''&&$set['giacu']!=0&&$set['giacu']!=''){
                                                if( $set['giamoi']>$set['giacu']){
                                                $gialech=($set['giamoi']/$set['giacu']*100)-100;
                                                }
                                                else $gialech=100-($set['giamoi']/ $set['giacu']*100);
                                            }else {$gialech= 0;}
                                            $gialech=round($gialech,2);
                                            if ($set['giamoi']>$set['giacu'] && $set['giacu']!=0){
                                        ?>
                                        <td class="primary" style="text-align: center; width: 7%; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                        <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                            <td class="primary" style="text-align: center; width: 7%; color:red"><?php echo "-".$gialech."%" ?></td>
                                        <?php } else { ?>
                                            <td  style="text-align: center; width: 7%;"><?php echo $gialech."%" ?></td>
                                        <?php } ?>
                                        <?php
                                        }else{
                                            ?>
                                                <?php 
                                            if(is_null($set['giacu'])){
                                            ?>
                                            <td class="primary" style="text-align: center;">-</td>
                                            <td class="primary" style="text-align: center;">-</td>
                                            <?php   
                                            }else{
                                            ?>
                                            <?php if($set['giacu'] == 0){?>
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                            <?php
                                            }else{
                                            ?>
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;"><?php 
                                            $priceString = (string) $set['giacu'];
    
                                            // Lấy số ký tự đầu tiên của giá trị
                                            $numberOfCharactersToMask = 1;
                                            $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                            $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                            $asterisksString = str_repeat('*', $numberOfAsterisks);
                                            echo $maskedValue . $asterisksString;?>đ</td>
                                        <?php } ?>
                                        <td  style="text-align: center; padding-left: 5px; width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%; color:crimson"><?php 
                                        $priceString = (string) $set['giamoi'];

                                        // Lấy số ký tự đầu tiên của giá trị
                                        $numberOfCharactersToMask = 1;
                                        $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                        
                                        // Tạo chuỗi dấu "*"
                                        $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                        $asterisksString = str_repeat('*', $numberOfAsterisks);
                                        
                                        // Hiển thị kết quả
                                        echo $maskedValue . $asterisksString;?>đ</td>
                                        <?php } ?>

                                        <td  style="text-align: center; padding-left: 5px; width: 10%; "><?php echo $set['ngaymoi']; ?></td>
                                        <?php
                                        
                                        }
                                        ?>
                                        <?php 
                                            if($set['nguon'] == 'thuocsi.vn'){
                                        ?>
                                         <td class="nguon"><a href="<?php echo $set['link'];?>" target="_blank" class="thea1"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'chosithuoc.com'){
                                        ?>
                                        <td class="nguona"><a href="<?php echo $set['link'];?>" target="_blank" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'ankhang.com'){
                                        ?>
                                        <td class="nguonb"><a href="<?php echo $set['link'];?>" target="_blank" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'thuocsi.pharex.vn'){
                                                ?>
                                                <td class="nguonc"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">pharex.vn</a></td>
                                                <?php
                                                }elseif($set['nguon'] == 'longchau.vn'){
                                                    ?>
                                                    <td class="nguond"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">longchau.vn</a></td>
                                                    <?php  
                                                }elseif($set['nguon'] == 'pharmacity.vn'){
                                                    ?>
                                                    <td class="nguone"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">pharmacity.vn</a></td>
                                                    <?php
                                                }elseif($set['nguon'] == 'medigoapp.com'){
                                                    ?>
                                                    <td class="nguonf"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">medigoapp.com</a></td>
                                                    <?php  
                                            }else{
                                                echo "";
                                            }
                                            ?>

                                        

                                        <td style="align-items: center; text-align:center; margin: 0 auto; width: 5%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:100%; text-align:center; margin: 0 auto;"></td>
                                       
                                        <?php if($set['masp'] == null){?>
                                        <td><div>
                                        <?php if($checkLoginAdmin == 0){?>    
                                        <form action="" method="get">
                                            
                                            <input type="hidden" name="id_p" value="<?php echo $set['id']?>">
                                            <div class="input-flex" style="display: flex; justify-content: center;">
                                            <input type="text" name="text" value="" id="" placeholder="Thêm mã..." style="border: 1px solid #777777; padding: .2rem .5rem; border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;  max-width: 60%;">
                                            <button type="submit" id="themma" name="submitMasp" style="border: 1px solid #777777; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem; padding: .2rem 1rem;   background-color:#669966; color: #fff; cursor:pointer; margin-left: -2%;">+</button>
                                            </div>
                                            
                                        </form>
                             
                                        </div></td>
                                        <?php }elseif($checkLoginAdmin == 1){?>    
                                        <form action="" method="get">
                                            <input type="hidden" name="id_p" value="<?php echo $set['id']?>">
                                            <input type="text" name="text" value="" id="" placeholder="Thêm mã..." style="border: 1px solid #777777; padding: .2rem .5rem; border-radius: 1rem;  max-width: 60%;">
                                            <!-- <button type="submit" id="themma" name="submitMasp" style="position:absolute; border: 1px solid #777777; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem; padding: .2rem .77rem;   background-color:#669966; color: #fff; cursor:pointer; margin-left: -2%;">+</button> -->
                                        </form></div></td>
                                        <?php } ?>
                                        <?php }else{ ?>
                                         
                                            <td><div >
                                            <form action="" method="get">
                                                <input type="hidden" name="id_p_sua" value="<?php echo $set['id']?>">
                                                <div class="input-flex" style="display: flex; justify-content: center;">
                                                <input type="text" name="text_sua" value="<?php echo $set['masp']?>" id="" placeholder="Sửa mã..." style="border: 1px solid #777777; padding: .2rem .5rem; border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;  max-width: 60%;">
                                                <?php if($checkLoginAdmin == 0){?>
                                                    <button type="submit" id="suama" name="submitMasp_sua" style="border: 1px solid #777777; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem; padding: .2rem .7rem;   background-color:darksalmon; color: #fff; cursor:pointer; margin-left: -2%;"><i class="fa fa-save"></i></button>
                                                <?php } ?>
                                                </div>
                                                 <a href="search.php?masp=<?php echo $set['masp']?>"style="border-radius: 1rem; padding: .1rem .5rem;   background-color:var(--color-white); color: #FF9966; cursor:pointer; margin:0 auto;">SP Tương Tự <i class="fa fa-angle-right"></i></a>
                                            </form>
                                            
                                        </div></td>
                                        <?php } ?>

                                        <td class="chitiet"  style="margin-left: 1rem;"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
                                        
                                        <?php
                                            for($k=1;$k<=12;$k++){
                                                ?>
                                                <td hidden><?php echo $set['month_'.$k] ?></td>
                                        <?php
                                            }
                                        ?>
                                        
                                    </tr>
                                    <?php 
                                        }
                                    }
                                    ?>
                            
                                </tbody>
                                
                
                    </table>
                     
                                            
                    <?php if($trang>1){
                    ?>
                    <div id="pagination">
                            
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&page=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } ?><a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="start1">1</a><?php
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="p".($i);
                            }
                            $next=1; 
                            if(($from-1)>1){
                                ?>
                            <a href="#">...</a>
                            
                            <?php    
                            }
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?>
                        <a href="search.php?&word=<?=($search)?>&page=<?=($trang)?>" id="end1"><?php echo $trang;?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        
                    </div>
                    <?php } ?>
                    <!-- <a href="#">Show All</a> -->
                </div>
                <script>
                        // document.querySelector("#ne").style.background = '#C0C0C0';
                        // document.querySelector("#ne").style.color = 'black';
                        if(<?php echo $numpage?>==1){
                            document.querySelector("#start").style.background = '#fff';  
                            document.querySelector("#start1").style.background = '#fff';  
                        }
                        if(<?php echo $numpage?>==<?php echo $trang?>){
                            document.querySelector("#end").style.background = '#fff';  
                            document.querySelector("#end1").style.background = '#fff';
                        }
                        document.querySelector("#p<?php echo $numpage?>").style.background = '#fff';
                        document.querySelector("#pa<?php echo $numpage?>").style.background = '#fff';
                    </script>
          
            <?php
                if($checkLoginAdmin == 0){
            
            ?>
                <div class="recent-order sosanh"  style="padding-top:2.5rem;">
                    <h2 style="padding-top:1rem;">BIỂU ĐỒ SO SÁNH CHO TỪ KHÓA TÌM KIẾM: <?php if(isset($search)){echo $search; }?> </h2> 
                    <canvas id="myChart"  style="height: 300px; width: 88%; margin-bottom: 3rem;"></canvas>
                      
                        
                        <script>
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                            labels: [],
                                            datasets: []
                                        },
                                        options: {
                                            labels: {
                                                style: {
                                                    width:'auto',
                                                    overflow:'hidden',
                                                    textOverflow: 'ellipsis'
                                                }
                                            }
                                        }
                                    });
                            
                            function handleClick() {
                                var data = [];
                                var lb=[];
                                var lab=[];
                                <?php
                                for($y=0;$y<sizeof($giabd);$y++){
                                ?>
                                data[<?php echo $y?>]=parseInt(<?php echo $giabd[$y] ?>);
                                lb[<?php echo $y?>]='<?php echo $tenbd[$y] ?>'
                                lab[<?php echo $y?>]='<?php echo $nguonbd[$y] ?>'
                                <?php
                            
                                    };
                                 ?>
                                var dataset = {
                                    label:'Sản phẩm',
                                    data: data,
                                    backgroundColor: 'blue'
                                };
                    
                                myChart.data.labels = lb;
                                myChart.data.datasets = [dataset];
                                myChart.update();
                            }
                            
                            window.onload=handleClick;
                            var chart =document.getElementById('myChart');
                            chart.labels.addEventListener('mouseover',function(){
                                this.style.display = 'block';
                            });
                            chart.labels.addEventListener('mouseout',function(){
                                this.style.display = 'none';
                            });
                        </script>
                </div>
                    <?php
                }else {
                    echo "";
                }
                ?>
            <div class="div">

            </div>


            </div>   <script src="js/time.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            <?php include_once('inc/footer.php')?>
