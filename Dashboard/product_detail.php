<?php 
include_once('inc/header.php');
// include_once('inc/deshboad.php');
include_once('connect.php');
include_once('format/format.php');
    $product = new product();
?>


<?php
    if(!isset($_GET['id']) || $_GET['id'] == NULL){
        echo "<script>window.location='index.php'</script>";
    }else{
        $id = $_GET['id'];
        $price = $_GET['price'];
        $link = $_GET['link'];
    }
    $q=0;
?>
<section class="product-gallery-one">

<?php
    $detailPro = $product->details_product_2($id, $link);   
    $format = new Format();
    $pro = new product();                            
    $month=array();
    for($thu=0;$thu<12;$thu++){
        $month[$thu]="month_".($thu+1);
    }                            
                           
    if($detailPro){
        while($result = $detailPro->fetch()){
    ?>
    <div class="nguon-trang">
        <h1><span><?php echo $result['nguon'] ?></span></h1>
    </div><br>
    <div class="container1">
<!-- <div class="product"> -->
 
    <div class="product-image">
       <img src="<?php echo $result['photo'] ?>" alt="">
        
    </div>

    <div class="product-details">
 
        <h1><?php echo $result['title'] ?></h1>

        

        <h2>Thời gian:</h2>
    
        <p><?php echo $result['ngaymoi'] ?></p>

        <div class="features">
            <h3>Đặc tính sản phẩm:</h3>
            <ul>
          
                <li><span>Nhà SX:</span><p><?php echo $result['nha_san_xuat'] ?></p></li>
                <li><span>Nước SX:</span><p><?php echo $result['nuoc_san_xuat'] ?></p></li>
                <!-- <li><span>Còn:</span><p><?php echo $result['productQuantity'] ?> cái</p></li> -->
               
            </ul>
        </div>

        <p class="price">Giá:<span ><?php echo number_format($result['giamoi']); ?><sup>đ</sup></span> </p>
      

    </div>
    
    </div> 
    <!-- </div> -->
        <div class="product_thongtin">
            <h2>Thông tin sản phẩm</h2>
            <p><?php echo $result['thong_tin_san_pham'] ?> </p>
            <div class="product_hamluong">
                <h2>Thành phần - Hàm lượng</h2>
                <p><?php echo $result['hamluong_thanhphan'] ?></p>
            </div>
            <div class="product_link">
                <h2>Sản phẩm</h2>
                <p>Để tìm hiểu chi tiết hơn về sản phẩm vui lòng <a href="<?php echo $result['link'] ?>"><ins>bấm vào đây !</ins></a></p>
            </div>
             <?php
                if($checkLoginAdmin == 0){
                ?>
            <div class="container-cat">
                <div class="warranty-policy">
                    <div class="warranty-policy-h1">
                        <h1>BẢNG SO SÁNH GIÁ QUA CÁC THÁNG</h1>
                    </div>
                    <div class="warranty-policy-content">
                        <table>
                            <thead>
                            <tr>
                                <th>Tháng 1</th>
                                <th>Tháng 2</th>
                                <th>Tháng 3</th>
                                <th>Tháng 4</th>
                                <th>Tháng 5</th>
                                <th>Tháng 6</th>
                                <th>Tháng 7</th>
                                <th>Tháng 8</th>
                                <th>Tháng 9</th>
                                <th>Tháng 10</th>
                                <th>Tháng 11</th>
                                <th>Tháng 12</th>

                            </tr>
                            </thead>
                         <tbody>
                            
                                
                         <tr>
                                <?php
                                for($j=0;$j<12;$j++){
                                    if($result[$month[$j]]!=""){
                                        ?>
                                         <td class="primary" style="text-align: right; width: 8%;"><?php echo number_format( $result[$month[$j]]); ?><sup>đ</sup></td>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <td class="primary" style="text-align:center; width: 8%;">-</td>
                                        <?php
                                    }
                                }
                                ?>
                                
                        </tr>
                            <?php 
                                      
                                 
                            ?>
                         </tbody>
                           
                        </table>
                       
                    </div>
                </div>
                        
            </div>
            <!-- <div class="container-cat">
                <div class="warranty-policy">
                    <div class="warranty-policy-h1">
                        <h1>BIỂU ĐỒ SO SÁNH GIÁ QUA CÁC LƯỢT CÀO TRONG THÁNG</h1>
                    </div>
                    <div class="warranty-policy-content">
                    <canvas id="myChart"   style="display:block; height: 170px; width: 100%; margin-right:-100px;" ></canvas>
                        
                        
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                    data: {
                                labels: [],
                                datasets: []
                            },
                            options: {}
                        });

                        function handleClick() {
                            var data = [];
                            
                            <?php
                            for($r=0;$r<12;$r++){
                                if($result['month_'.($r+1)]!=''){
                            ?>
                            data[<?php echo $r?>]=parseInt('<?php echo $result['month_'.($r+1)]?>');
                            <?php
                                }else {
                            ?>
                            data[<?php echo $r?>]=parseInt('0');
                            <?php        
                                }
                            }
                             ?>
                            var dataset = {
                                label:'<?php echo $result['title'] ?>',
                                data: data,
                                backgroundColor: 'blue'
                            };
                            var h=1;
                            var lb=[];
                            for (var i = 0; i <12; i++){
                                lb.push("Tháng "+h);
                                h++
                            }
                            
                            myChart.data.labels = lb;
                            myChart.data.datasets = [dataset];
                            myChart.update();
                        }
                        window.onload=handleClick;
                    </script>
                    </div>
                </div>
                 -->
            <div class="container-cat">
                <div class="warranty-policy">
                    <div class="warranty-policy-h1">
                        <h1>BIỂU ĐỒ SO SÁNH GIÁ QUA CÁC THÁNG</h1>
                    </div>
                    <div class="warranty-policy-content">
                    <canvas id="myChart"  style="height: 200px; width: 120%; margin-right:-100px;"></canvas>
                        
                        
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                    data: {
                                labels: [],
                                datasets: []
                            },
                            options: {}
                        });

                        function handleClick() {
                            var data = [];
                            
                            <?php
                            for($r=0;$r<12;$r++){
                                if($result['month_'.($r+1)]!=''){
                            ?>
                            data[<?php echo $r?>]=parseInt('<?php echo $result['month_'.($r+1)]?>');
                            <?php
                                }else {
                            ?>
                            data[<?php echo $r?>]=parseInt('0');
                            <?php        
                                }
                            }
                             ?>
                            var dataset = {
                                label:'<?php echo $result['title'] ?>',
                                data: data,
                                backgroundColor: 'blue'
                            };
                            var h=1;
                            var lb=[];
                            for (var i = 0; i <12; i++){
                                lb.push("Tháng "+h);
                                h++
                            }
                            
                            myChart.data.labels = lb;
                            myChart.data.datasets = [dataset];
                            myChart.update();
                        }
                        window.onload=handleClick;
                    </script>
                    </div>
                </div>
                        
            </div>
             <?php
                }else{
                    echo "";
                }
            ?>
          </div>

          <?php
                            }
                        }
                        ?>

      
    
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
          
         

