<?php include_once('../connect.php');
    include_once('format/format.php');
?>
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
                    <form action="search.php" method="post" class="search-box">
                                <input type="text" name="keyword" placeholder="Nhập sản phẩm cần tìm..." required >
                                <button type="submit" name="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div>
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
                                                window.location.href='index.php';
                                                </script>";
                                                }else echo "<script>
                                                    swal({
                                                        title: 'Thông báo',
                                                        text: 'Quá trình cào giá đã hoàn tất',
                                                        icon: 'success',
                                                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                                                        buttons: false,  // Ẩn nút Close
                                                        });
                                                    window.location.href='index.php';
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
                                                    window.location.href='index.php';
                                                </script>";
                                            }
                                            
                                        }
                                        
                                    
                                        // else echo 'Không chayk';
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
                    <!-- <form action="http://127.0.0.1:5000/run-python" method="post">
                        <input type="text" name="numstart" placeholder="Nhập trang bắt đầu" required oninvalid="setCustomValidity('Vui lòng điền trang bắt đầu')">
                        <input type="text" name="numend" placeholder="Nhập trang trang kết thúc" required oninvalid="setCustomValidity('Vui lòng điền trang kết thúc')">
                        <button id="runButton">Chạy</button>

                    </form> -->
                    
                    <!-- <script>
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
                        // Xử lý kết quả ở đây
                           
                        }
                        
                    }; 
                                 
                    };
                    function b(){
                        // console.log("tắt");
                        // alert('Phiên cào giá trang web thuocsi.vn đang chạy. Vui lòng chờ trong giây lát');  
                        // document.querySelector(alert).style.display ="none"
                        swal({
                        title: "Thông báo",
                        text: "Quá trình cào giá đang diễn ra, vui lòng chờ ...",
                        icon: "success",
                        timer: 3000,  // Thời gian tự động đóng (3 giây)
                        buttons: false,  // Ẩn nút Close
                        });
                        localStorage.setItem('eventName', 'true');

                        
                    }
                    
                    </script> -->
                    <!-- <button id="caogia-button" onclick="sendCaoGiaRequest()">
                        <div class="item add-product">
                            <span class="material-icons-sharp">add</span>
                            <h3>Cào giá</h3>
                            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                            
                            
                        </div>
                    </button>    -->
                </div>
                <!-- <script>
                    function sendCaoGiaRequest() {
                        axios.post('/caogia')
                        .then(function(response) {
                            // Xử lý kết quả cào giá ở đây
                            console.log(response.data);
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                    }
                </script> -->
            </div>
       </div> 
       <!-- <script src="./orders.js"></script> -->
       <script src="js/index.js"></script>
  
       <script src="js/time.js"></script>
    </body>
</html>
