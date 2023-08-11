<?php include_once('./connect.php');
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
                        <!-- <div class="info">
                            <p>Hey,<b> Vizt</b></p>
                            <small class="text-muted">Admin</small>
                        </div> -->
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
            width: 200px;
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
                    <div class="item online">
                        <div class="icon">
                         <span class="material-icons-sharp"><img src="images/top1.jpg" alt=""></span>
                     </div>
                
                        <div class="right">
                        <?php
                        $muanhieunhat = $pd-> buy_the_most();
                         if($muanhieunhat){
                            while($result = $muanhieunhat->fetch(PDO::FETCH_ASSOC)){

                         ?>
                         <div class="info">
                                <h3><a href="product_detail.php?id=<?php echo $result['photo']?>&price=<?php echo $result['price']?>">Mua nhiều nhất</a></h3>
                             <small class="text-muted"><?php echo $fm->textShorten($result['title'], 23) ?></small>
                         </div>
                        <?php
                        $phantramnhieunhat = $pd->phantramnhieunhat();
                        if($phantramnhieunhat){
                            while($row = $phantramnhieunhat->fetch(PDO::FETCH_ASSOC)){

                        ?>
                        <h5 class="success">+<?php $ket = $result['sales_in_last_24_hours'] / $row['phantramnhieunhat'] *100; $ketqua = round($ket * 100) / 100; echo $ketqua; ?>%</h5>
                        <?php
                            }
                        }
                        ?>
                       
                          <h3><?php echo $result['sales_in_last_24_hours']?>Sp</h3>
                          <?php
                                
                            }
                        }
                        ?>
                        </div>
                    </div> 
                    <div class="item offline">
                        <div class="icon">
                         <span class="material-icons-sharp"><img src="images/top2.jpg" alt=""></span>
                     </div>
                        <div class="right">
                        <?php
                        $buy_the_two = $pd-> buy_the_two();
                        if($buy_the_two){
                            while($result = $buy_the_two->fetch(PDO::FETCH_ASSOC)){

                        ?>
                         <div class="info">
                                <h3><a href="product_detail.php?id=<?php echo $result['photo']?>&price=<?php echo $result['price']?>">Mua nhiều nhì</a></h3>
                             <small class="text-muted"><?php echo $fm->textShorten($result['title'], 23) ?></small>
                         </div>
                      <?php
                        $phantramnhieunhi = $pd->phantramnhieunhi();
                        if($phantramnhieunhi){
                            while($row = $phantramnhieunhi->fetch(PDO::FETCH_ASSOC)){

                         ?>
                        <h5 class="danger">+<?php $ket = $result['sales_in_last_24_hours'] / $row['phantramnhieunhi'] *100; $ketqua = round($ket * 100) / 100; echo $ketqua; ?>%</h5>
                     <?php
                            }
                        }
                        ?>
                     
                         <h3><?php echo $result['sales_in_last_24_hours']?>Sp</h3>
                         <?php
                             }
                        }
                        ?>
                        </div>
                    </div>
                    <div class="item customers">
                        <div class="icon">
                         <span class="material-icons-sharp"><img src="images/top3b.jpg" alt=""></span>
                     </div>
                        <div class="right">
                        <?php
                        $muanhieunhi = $pd-> buy_the_three();
                         if($muanhieunhi){
                            while($result = $muanhieunhi->fetch(PDO::FETCH_ASSOC)){

                         ?>
                         <div class="info">
                                <h3><a href="product_detail.php?id=<?php echo $result['photo']?>&price=<?php echo $result['price']?>">Mua nhiều ba</a></h3>
                             <small class="text-muted"><?php echo $fm->textShorten($result['title'], 23) ?></small>
                         </div>
                         <?php
                        $phantramnhieuba = $pd->phantramnhieuba();
                        if($phantramnhieuba){
                            while($row = $phantramnhieuba->fetch(PDO::FETCH_ASSOC)){

                         ?>
                        <h5 class="success">+<?php $ket = $result['sales_in_last_24_hours'] / $row['phantramnhieuba'] *100; $ketqua = round($ket * 100) / 100; echo $ketqua; ?>%</h5>
                     <?php
                            }
                        }
                        ?>
                      
                         <h3><?php echo $result['sales_in_last_24_hours']?>Sp</h3>
                         <?php
                        
                            }
                        }
                        ?>
                        </div>
                    </div> 
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

                            .adress-form-content form input, select {
                                display: block;
                                height: 40px;
                                width: 100%;
                                margin-top: 20px;
                                border: 1px solid #ddd;
                                padding: 6px;
                                border-radius: 5px;
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
                        <li id="adress-form"><a href="#"><h3>Tiếp tục Cào</h3></a></li>
                        <div class="adress-form">
                            <div class="adress-form-content">
                                <h2>Cào Dữ Liệu Website <span id="adress-close">X Đóng</span></h2><br>
                                <form action="http://127.0.0.1:5000/run-python" method="post">
                                   <p>Nhập số trang bắt đầu và trang kết thúc để tiến hành cào</p>
                                        <input type="number" placeholder="Trang bắt đầu" min="0" name="numstart" id="" required oninvalid="setCustomValidity('Vui lòng điền trang bắt đầu')">
                                        <input type="number" placeholder="Trang kết thúc" min="1" name="numend" id="" required oninvalid="setCustomValidity('Vui lòng điền trang kết thúc')">
                                        <button type="submit" name="button" id="runButton">Xác nhận</button>
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
                    <!-- <form action="http://127.0.0.1:5000/run-python" method="post">
                        <input type="text" name="numstart" placeholder="Nhập trang bắt đầu" required oninvalid="setCustomValidity('Vui lòng điền trang bắt đầu')">
                        <input type="text" name="numend" placeholder="Nhập trang trang kết thúc" required oninvalid="setCustomValidity('Vui lòng điền trang kết thúc')">
                        <button id="runButton">Chạy</button>

                    </form> -->
                    
                    <script>
                    document.getElementById("runButton").addEventListener("click", function(){
                    // Thực hiện một yêu cầu HTTP (AJAX) để chạy file Python
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "/run-python", true); // Đổi "/run-python" thành URL tương ứng với file Python của bạn
                    xhr.send();
                    // alert('Phiên cào giá trang web thuocsi.vn đang chạy. Vui lòng chờ trong giây lát')
                    // Xử lý kết quả từ server (nếu cần thiết)
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        // Xử lý kết quả ở đây
                        
                        }
                    };
                    
                    });
                    
                    </script>
                    <!-- <button id="caogia-button" onclick="sendCaoGiaRequest()">
                        <div class="item add-product">
                            <span class="material-icons-sharp">add</span>
                            <h3>Cào giá</h3>
                            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                            
                            
                        </div>
                    </button>    -->
                </div>
                <script>
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
                </script>
            </div>
       </div> 
       <!-- <script src="./orders.js"></script> -->
       <script src="js/index.js"></script>
  
       <script src="js/time.js"></script>
    </body>
</html>
