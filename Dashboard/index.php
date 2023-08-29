<?php include_once('inc/header.php');
    include_once('format/format.php');

?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
var loader = function() {
    setTimeout(function() {
        $('#loader').css({ 'opacity': 0, 'visibility':'hidden' });
    }, 2500);
};
$(function(){
    loader();
});
</script>
<section id="loader" class="section">
        <div class="loader">
            <span style="--i:1;"></span>
            <span style="--i:2;"></span>
            <span style="--i:3;"></span>
            <span style="--i:4;"></span>
            <span style="--i:5;"></span>
            <span style="--i:6;"></span>
            <span style="--i:7;"></span>
            <span style="--i:8;"></span>
            <span style="--i:9;"></span>
            <span style="--i:10;"></span>
            <span style="--i:11;"></span>
            <span style="--i:12;"></span>
            <span style="--i:13;"></span>
            <span style="--i:14;"></span>
            <span style="--i:15;"></span>
            <span style="--i:16;"></span>
            <span style="--i:17;"></span>
            <span style="--i:18;"></span>
            <span style="--i:19;"></span>
            <span style="--i:20;"></span>
        </div>
    </section>
                <?php 
                $numpage=1;
                if(isset($_GET['trang'])){
                    $numpage=$_GET['trang'];
                }
                 ?>
                </div>
                
                <style>
                    main .recent-order .a{
                        text-align: start;
                        display:contents;
                        color: green;
                    }
                </style>
                <div class="recent-updates">
                <h2>Tìm kiếm sản phẩm</h2>
                <div class="updates">
                    
                    <style>
        .search-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 4vh;
        }

        .search-box input[type="text"] {
            width: 85%;
            padding: 10px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .search-box button {
            width: 100;
            padding: 7px 7px;
            background-color:orange;
            color:aliceblue;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            cursor: pointer;
        }
    </style>
                    <form action="search.php" method="post" class="search-box">
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
                            <p>Chào,<b><?php echo Session::get('adminName');?></b></p>
                            <?php $chucvu = Session::get('adminType');?>
                            <small class="text-muted"><?php if($chucvu == 0){ echo "Admin";}else{echo "Nhân viên";} ?></small>
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
                    
                    <style>
        .search-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 4vh;
        }

        .search-box input[type="text"] {
            width: 70%;
            padding: 10px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .search-box button {
            width: 100;
            padding: 7px 7px;
            background-color:orange;
            color:aliceblue;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            cursor: pointer;
        }
    </style>
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
                         $tongsanpham =  $pd->tongsanpham();
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){
 
                   
                         ?>
                         <style>

                            .img {
                                background-color: #ddd;
                            }
                          
                          .right .item.online h3 a span{
                            transition: all .5s ease;
                           
                        }

                        .right .item.online h3 a:hover span{
                            color:  #f97e0e;
                            margin-top: 5px;
                        }

                        .right .item.online .h3 {
                            margin-top: 10px;
                        }

                        .info a:hover span{
                            color:  #f97e0e;
                        }
                         </style>
                         <div class="info">
                                <h3 class="h3"><a href="#"><span>Tổng sản phẩm</span></a></h3>
                         
                         </div>
                        
                        <h1 class="success" style="color: black; font-weight:normal;"><?php echo $result['quantity']?>Sp</h1>
                      
                       
                          <h3></h3>
                          <?php
                                
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <?php
                    if($chucvu == 0){

                    ?>
                    <div class="item add-product">
                        <span class="material-icons-sharp">add</span>
                        <style>
                            
                            /* -------------------- adress form --------------- */

                            .adress-form {
                                position: fixed;
                                width: 100vw;
                                height: 100vh;
                                background-color: rgba(0, 0, 0, 0.3);
                                top: 0;
                                left: 0;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                text-align: center;
                                color: #333;
                                display: none;
                                z-index: 999;
                            }

                            .adress-form-content {
                                width: 400px;
                                height: 450px;
                                background-color: #fff;
                                border-radius: 5px;
                            }

                            .adress-form-content form {
                                padding: 12px 40px;
                            }

                            .adress-form-content h2 {
                                font-size: 16px;
                                padding: 12px 0;
                                border-bottom: 1px solid #333;
                                position: relative;
                            }

                            .adress-form-content h2 span {
                                display: block;
                                position: absolute;
                                height: 30px;
                                padding: 0 6px;
                                border: 1px solid #ddd;
                                right: 12px;
                                cursor: pointer;
                                top: 50%;
                                transform: translateY(-50%);
                                line-height: 30px;
                                color: #333;
                                border-radius: 5px;
                            }

                            .adress-form-content form p {
                                font-size: 16px;
                            }

                            
.adress-form-content form button {
                                margin-top: 20px;
                                height: 40px;
                                width: 80%;
                                cursor: pointer;
                                background-color: #f97e0e;
                                outline: none;
                                border: none;
                                color: #fff;
                                border-radius: 5px;
                            }

                        </style>
                        <li id="adress-form"><a href="#"><h3>Cập nhật</h3></a></li>
                        <div class="adress-form">
                            <div class="adress-form-content">
                                <h2>Cào Dữ Liệu Website <span id="adress-close">X Đóng</span></h2><br>
                                    <form action="#" method="post">
                                   <p style="font-weight: bolder;">Chọn website bạn muốn thực hiện cào</p>
                                   <style>
                                    /* Customize the label (the container) */
                                    .containerr {
                                    margin-top: 8px;
                                    display: block;
                                    position: relative;
                                    padding-left: 20px;
                                    margin-bottom: 8px;
                                    cursor: pointer;
                                    font-size: 14px;
                                    -webkit-user-select: none;
                                    -moz-user-select: none;
                                    -ms-user-select: none;
                                    user-select: none;
                                    text-align: left;
                                    }
                                    

                                    /* Hide the browser's default radio button */
                                    .containerr input {
                                        margin-top: 8px;   
                                    position: absolute;
                                    opacity: 0;
                                    cursor: pointer;
                                    height: 0;
                                    width: 0;
                                    }

                                    /* Create a custom radio button */
                                    .checkmark {
                                    
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    height: 15px;
                                    width: 15px;
                                    background-color:bisque;
                                    border-radius: 50%;
                                    }

                                    /* On mouse-over, add a grey background color */
                                    .containerr:hover input ~ .checkmark {
                                    background-color:#f97e0e;
                                    }

                                    /* When the radio button is checked, add a blue background */
                                    .containerr input:checked ~ .checkmark {
                                    background-color: #2196F3;
                                    }
                                    .containerr input:disabled ~ .checkmark {
                                    background-color:darkgray;
                                    }

                                    /* Create the indicator (the dot/circle - hidden when not checked) */
                                    .checkmark:after {
                                    content: "";
                                    position: absolute;
                                    display: none;
                                    }

                                    /* Show the indicator (dot/circle) when checked */
                                    .containerr input:checked ~ .checkmark:after {
                                    display: block;
                                    }

                                    /* Style the indicator (dot/circle) */
                                    .containerr .checkmark:after {
                                       
                                    top: 5px;
                                    left: 5px;
                                    width: 5px;
                                    height: 5px;
                                    border-radius: 50%;
                                    background: white;
                                    }
                                   </style>
                                   
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

                                        <label class="containerr" style="font-weight: 400;">Tất cả
                                        <input type="checkbox" name="alll" value='alll' id="checkbox-5">
                                        <span class="checkmark"></span>
                                        </label>
                                    <button type="submit" name="runpython" id="runButton">Xác nhận</button><br>
                                    <label for="">Quá trình cào dữ liệu có thể mất khá nhiều thời gian, vui lòng chờ <a href="https://www.youtube.com/watch?v=WYduvea9Qgc" style="color:#2196F3;">Click</a></label>
                                    <script>
                                        const chk1=document.getElementById("checkbox-1");
                                        const chk2=document.getElementById("checkbox-2");
                                        const chk3=document.getElementById("checkbox-3");
                                        const chk4=document.getElementById("checkbox-4");
                                        const chk5=document.getElementById("checkbox-5");
                                        chk1.addEventListener('change',function(){  
                                                                                    
                                            if (chk1.checked) {                                            
                                                chk5.disabled = true;
                                            } else {                                            
                                                chk5.disabled = false;
                                            }
                                        })
                                        // //
                                        chk2.addEventListener('change',function(){ 
                                                                                       
                                            if (chk2.checked) {                                            
                                                chk5.disabled = true;
                                            } else {                                            
                                                chk2.disabled = false;
                                            }
                                        })
                                        //
                                        chk3.addEventListener('change',function(){ 
                                                                                      
                                            if (chk3.checked) {                                            
                                                chk5.disabled = true;
                                            } else {                                            
                                                chk3.disabled = false;
                                            }
                                        })
                                        chk4.addEventListener('change',function(){ 
                                                                                      
                                            if (chk4.checked) {                                            
                                                chk5.disabled = true;
                                            } else {                                            
                                                chk4.disabled = false;
                                            }
                                        })
                                        //
                                        chk5.addEventListener('change',function(){  
                                                                                      
                                        if(chk4.checked){
                                            chk1.disabled=true;
                                            chk2.disabled=true;
                                            chk3.disabled=true;
                                            chk4.disabled=true;
                                        }else{
                                            chk1.disabled=false;
                                            chk2.disabled=false;
                                            chk3.disabled=false;
                                            chk4.disabled=false;                                        
                                        }
                                    })
                                       
                                    </script>
                                    <?php
                                    if($_SERVER['REQUEST_METHOD']=='POST'){
                                        
                                        if (isset($_POST['runpython'])){
                                            echo '<div class="loading"></div>';
                                            ini_set('max_execution_time', (3600*24*7));
                                            ignore_user_abort(true);
                                            if(isset($_POST['alll'])){
                                                if(empty(system('python ../backend/auto/run_chosithuoc.py && python ../backend/auto/thuocsi.py "0" && python ../backend/auto/ankhang.py "0" && python ../backend/auto/pharex.py "0"'))){
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
                                                </script>";
                                                }else echo "<script>
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
                                                </script>";
                                            }else{
                                                if(isset($_POST['thuocsi'])){
                                                    system('python ../backend/auto/thuocsi.py "0"');
                                                }
                                                if(isset($_POST['chosithuoc'])){
                                                    system('python ../backend/auto/run_chosithuoc.py');
                                                }
                                                if(isset($_POST['ankhang'])){
                                                    system('python ../backend/auto/ankhang.py "0"');
                                                }
                                                if(isset($_POST['pharex'])){
                                                    system('python ../backend/auto/pharex.py "0"');
                                                }
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
                                                </script>";
                                            }
                                            
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
                    <label style='font-size: 15px;display: flex;align-items: center;justify-content: center;'>Số trang đã cào Auto được: <?php echo $numpagecao?></label>
                    <?php
                    }else{
                        echo "";
                    }
                    ?>
                
                </div>
              
            </div>
       </div> 
       <div class="recent-order">
 <h2>SẢN PHẨM - <span style="color: green; "><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.vn/products" class="a" >Thuocsi.vn</a></span> - <span style="color: blue;">
 <i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a" style="color:blue;">Chosithuoc</a></span>- <span style="color: #33CC33;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.nhathuocankhang.com/" class="a" style="color: #33CC33;">Ankhang.com</a></span> - <span style="color: #17a2b8;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a" style="color: #17a2b8; ">Pharex.vn</a></span> - <span style="color: #1250dc;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a" style="color: #1250dc; ">Longchau.vn</a></span></h2>
                
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
                    </style>
                    <?php
                    $sotrang=1;
                         $tongsanpham =  $pd->tongsanpham();
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){                   
                            $tong= $result['quantity'];
                         }
                         if($tong%100==0){$trang=$tong/100;}
                         else{$trang=ceil($tong/100);}
                        }
                         
                                $format = new Format();
                                $pro = new product();
                                $trangthu=1;
                                $from=1;
                                $to=6;
                        if(isset($_GET['trang'])){
                            $trangthu=$_GET['trang'];
                            $from=$trangthu-4; if($from<3){$from=1;}
                            $to=$trangthu+4; if($to>$trang){$to=$trang;}
                            $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
                            $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
                        }
                        $result = $pro ->getListproduct($trangthu,100);
                        ?>  
                    
                    <?php
                    
                        $pro = new product();
                            $demcol = $pro->testcol('giacu');
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                        ?>
                        <div id="pagination">
                            <a href="index.php?&trang=<?=(1)?>" id="start">Trang đầu</a>
                            <?php if($trangthu==1){ ?> 
                            <a href="index.php?&trang=<?=(1)?>" id="st" style="display:none" ">Trước</a>
                            <?php }else{ ?> 
                                <a href="index.php?&trang=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="pa".($i);
                            }
                            $next=1; 
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="index.php?&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="index.php?&trang=<?=($nextpage)?>" id="ne" style="display:none" ">Sau</a>
                            <?php }else{ ?>                     
                        <a href="index.php?&trang=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        <a href="index.php?&trang=<?=($trang)?>" id="end">Trang cuối</a>
                    </div>
                            <table id="mytable">                    
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <th>Giá cũ</th>
                                        <th>Thời gian</th>
                                        <th>Giá mới</th>
                                        <th>Thời gian</th>
                                        <th>Giá lệch</th>
                                        <?php
                                        }else{
                                            echo "";
                                        }
                                        ?>
                                        <th>Nguồn</th>
                                        <th>Ảnh</th>
                                        <th>Chức năng</th>
                                        <?php
                                            for($k=1;$k<=12;$k++){
                                                ?>
                                                <th hidden>month_<?php echo $k ?></th>
                                        <?php
                                            }
                                        ?>
                                        
                                    </tr>
                                </thead>
                                <style>
                                    .primary {
                                        text-align: right;
                                    }

                                    .title {
                                        text-align: left;
                                    }

                                    .nha-san-xuat {
                                        text-align: left;
                                    }

                                    .nuoc-san-xuat {
                                        text-align: left;
                                    }

                                    .thong_tin {
                                        text-align: left;
                                    }
                                    
                                    .nguon {
                                        width: 10%;
                                    }

                                    td:nth-child(8) a{
                                        transition: all .5s ease;
                                        color: green;
                                        font-weight: bold;
                                        text-align: left;
                                    }

                                    .nguon a:hover{
                                        color: #00CC00;
                                    }
                                    .nguona .thea {
                                        transition: all .5s ease;
                                        color: #0000BB;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguona .thea:hover {
                                        color: #3366FF;
                                    }
                                    .nguonb .thea {
                                        transition: all .5s ease;
                                        color:tomato;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonb .thea:hover {
                                        color:lightcoral;
                                    }
                                    .nguonc .thea {
                                        transition: all .5s ease;
                                        color:#17a2b8;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonc .thea:hover {
                                        color:#0000BB;
                                    }
                                    .nguond .thea {
                                        transition: all .5s ease;
                                        color:#1250dc;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguond .thea:hover {
                                        color:#acc0f3;
                                    }
                                    .recent-order tbody tr td:nth-child(2) a{
                                    cursor: pointer;
                                    color: rgb(221, 94, 94);
                                    transition: .5s all ease;
                                    text-align: left;
                                }
                                
                                .recent-order tbody tr td:nth-child(2):hover a{
                                    color: rgb(221, 50, 50);
                                    font-size: 14px;
                                }

                                 .nguon .thea1{
                                    transition: all .5s ease;
                                    color: green;
                                    font-weight: bold;
                                    text-align: left;
                                }
                                </style>
                                
                                <?php
                                if($result){
                                    $j=0;
                                    while($set = $result->fetch()){
                                        $j++
                                ?>
                            <tbody>
                                    <tr onclick="handleClick(event)" id="tbody" class="tr">
                                        <td><?php echo $j;?></td>
                                        <td class="title"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <?php 
                                        if($sorow==0){
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
                                        <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                        <?php } ?>
                                            
                                        <td class="primary" style="text-align: center; padding-left: 5px; color:coral;width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>

                                        <td class="primary" style="text-align: center; padding-left: 5px; color:coral; width: 10%;"><?php echo $set['ngaymoi']; ?></td>

                                        
                                        <?php
                                            if($set['giamoi']!=0&&$set['giacu']!=0){
                                                if( $set['giamoi']>$set['giacu']){
                                                $gialech=($set['giamoi']/$set['giacu']*100)-100;
                                                }
                                                else $gialech=100-($set['giamoi']/ $set['giacu']*100);
                                            }else {$gialech= 0;}
                                            $gialech=round($gialech,2);
                                            if ($set['giamoi']>$set['giacu'] && $set['giacu']!=0){
                                        ?>
                                        <td class="primary" style="text-align: right; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                        <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                            <td class="primary" style="text-align: right; color:red"><?php echo "-".$gialech."%" ?></td>
                                        <?php } else { ?>
                                            <td class="primary" style="text-align: right; color:blue"><?php echo $gialech."%" ?></td>
                                        <?php } ?>
                                        <?php
                                        }else{
                                            echo "";
                                        }
                                        ?>
                                        <?php 
                                            if($set['nguon'] == 'thuocsi.vn'){
                                        ?>
                                         <td class="nguon"><a href="<?php echo $set['link'];?>" class="thea1"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'chosithuoc.com'){
                                        ?>
                                        <td class="nguona"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'ankhang.com'){
                                        ?>
                                        <td class="nguonb"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'thuocsi.pharex.vn'){
                                                ?>
                                                <td class="nguonc"><a href="<?php echo $set['link'];?>" class="thea">pharex.vn</a></td>
                                                <?php
                                                }elseif($set['nguon'] == 'longchau.vn'){
                                                    ?>
                                                    <td class="nguond"><a href="<?php echo $set['link'];?>" class="thea">longchau.vn</a></td>
                                                    <?php  
                                            }else{
                                                echo "";
                                            }
                                            ?>

                                        

                                        <td style="align-items: center; text-align:center; margin: 0 auto; width: 12%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                                    
                                        <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
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
                            <div id="pagination" >
                            <a href="index.php?&trang=<?=(1)?>" id="start">Trang đầu</a>
                            <?php if($trangthu==1){ ?> 
                            <a href="index.php?&trang=<?=(1)?>" id="st" style="display:none" >Trước</a>
                            <?php }else{ ?> 
                                <a href="index.php?&trang=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="p".($i);
                            }
                            $next=1; 
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="index.php?&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="index.php?&trang=<?=($nextpage)?>" id="ne" style="display:none" ">Sau</a>
                            <?php }else{ ?>                     
                        <a href="index.php?&trang=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        <a href="index.php?&trang=<?=($trang)?>" id="end">Trang cuối</a>
                    </div>
                 
                    <script>
                     
                            function changeColor(element) {
                                element.style.color="red";                                
                            }
                            // Thêm một sự kiện lắng nghe cho liên kết "Previous"
                            const pr =document.getElementById("pr");
                            pr.addEventListener("click",function(){                                
                              <?php if($trangthu>1){
                                $trangthu--;
                              } ?>
                              changeColor();                              
                            });
                            <?php 
                            
                            for($i=0;$i<$trang;$i++){
                            ?>
                            const <?php echo $page[$i] ?> =document.getElementById(<?php echo '"'.$page[$i].'"' ?>);
                                <?php echo $page[$i] ?>.addEventListener("click",function(){
                                    <?php $trangthu=($i+1); ?> 
                                    changeColor(document.getElementById(<?php echo '"'.$page[$i].'"' ?>));                                   
                                })
                                 
                            <?php
                                
                            }?>
                            // Thêm một sự kiện cho liên kết "Next"
                            const next =document.getElementById("next");
                            next.addEventListener("click",function(){                                
                                <?php if($trangthu<$trang)
                                    $trangthu++;
                                ?>
                                changeColor(); 
                            }
                            );

                   
                     </script>
                        <script>
                        // document.querySelector("#ne").style.background = '#C0C0C0';
                        // document.querySelector("#ne").style.color = 'black';
                        document.querySelector("#p<?php echo $numpage?>").style.background = '#fff';
                        document.querySelector("#pa<?php echo $numpage?>").style.background = '#fff';
                    </script>
                </div>
               <style>
                    .quaylai {
                        display: none;
                        position: fixed;
                        font-size: 2rem;
                        text-align: right;
                        max-width: 97%;
                        color: #333;
                        cursor: pointer;
                        top: 50%;
                        right: 1.3%;
                        transition: .3s all ease;
                    }

                    .quaylai i {
                        transition: .3s all ease;
                        color: #fff;
                        font-size: 2.5rem;
                    }
                </style>
                <div class="quaylai">
                <i class="fas fa-chevron-circle-up" onclick="scrollUp()"></i><br>
                <i class="fas fa-chevron-circle-down" onclick="scrollDown()"></i>
                </div>
                <!-- <button class="quaylai" onclick="scrollUp()">Quay lại đầu trang</button> -->
                <div class="abc" style="margin-bottom: 1rem; height:1rem;"></div>

                <style>
                footer {
                    background-color: #719c9c;
                    color: #fff;
                    padding: 40px 0;
                    font-size: 14px;
                    font-family: sans-serif;
                }
                
                .container-footer {
                    max-width: 1200px;
                    color: #fff;
                    margin: 0 auto;
                }
                
                .copyright {
                    width: 100%;
                    text-align: center;
                    color: #fff;
                    font-weight: 700;
                }
            </style>
                <div class="footer-index">
                    <div class="footer-index-content">
                <footer>
                        <div class="container-footer">
                        
                            <div class="copyright">
                            © 2023 Công ty Cổ phần HB Pharma. All rights reserved.
                            </div>
                        </div>
                </footer>
                <script src="js/time.js"></script>
               
