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

       <p class="price">Giá:  <span ><?php if($result['giamoi'] == "" ){ ?>

       Liên hệ</span> </p>
       <?php }else{ ?>
        <?php echo number_format($result['giamoi']); ?><sup>đ</sup></span> </p>
        
        <?php }?>
        

    </div></div> 
    <div class="product_hamluong">
                <h2>Thành phần - Hàm lượng</h2>
                <?php $hltp= $result['hamluong_thanhphan'] ;
          
                    if($result['nguon']=='thuocsi.vn'||$result['nguon']=='thuocsi.pharex.vn'){
                        $hltp=substr($hltp,2,-2);

                    }
                ?>
                <p><?php                 
                    echo $hltp;                
                ?></p>
            </div>
    
    
    <!-- </div> -->
        <div class="product_thongtin">
            <h2>Thông tin sản phẩm</h2>
            <p><?php echo $result['thong_tin_san_pham'] ?> </p>
            
            <div class="product_link">
                <h2>Sản phẩm</h2>
                <p>Để tìm hiểu chi tiết hơn về sản phẩm vui lòng <a href="<?php echo $result['link'] ?>" target="_blank"><ins>bấm vào đây !</ins></a></p>
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
                    <canvas id="myChart"  style="height: 200px; width: 120%; margin-right: -100px;"></canvas>
                        
                        
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
    <?php
    $detailPro = $product->details_product_2($id, $link);
        while($result = $detailPro->fetch()){
            if(isset($_GET['luotsp'])){
                $demluotsp=$_GET['luotsp'];
            }else {
                $demluotsp= 1;
            }
            if($result["masp"]!=''){
                $somach=$pro->countmach($result['masp']);
                $ssomach=$somach->fetch();
                $demsomach=$ssomach['demmach'];
                $spcungmach=$pro->selectch($result["masp"],4,$demluotsp);
                
    ?>
    <div class='sanphamlienquan'>

            <div class="warranty-policy-h1">
                <h1>SẢN PHẨM LIÊN QUAN: <?php echo $result['masp'] ?> <a href="search_xemthem.php?masp=<?php echo $result['masp']?>"style="border-radius: 1rem; padding: .1rem .5rem;   background-color:#fff; color: #FF9966; cursor:pointer; margin:0 auto;">Tất cả SP <i class="fa fa-angle-right"></i></a></h1>
            </div>
            
            <div class='danhsach'><div class="chuyensp">
                <?php if($demluotsp>1){ ?>
                
                <span><a href="product_detail.php?id=<?php echo $result['photo'];?>&link=<?php echo $result['link'];?>&price=<?php echo $result['giamoi']?>&luotsp=<?php echo ($demluotsp + -1);?>"><</a></span>
                
    <?php } 
    ?></div>
    <div class="contai">
    <?php while($spcungda=$spcungmach->fetch()){
        ?>

        <div class='box'>
        <div class="image"><a href="product_detail.php?id=<?php echo $spcungda['photo'];?>&link=<?php echo $spcungda['link'];?>&price=<?php echo $spcungda['giamoi']?>"><img src="<?php echo $spcungda['photo'] ?>" alt="" srcset=""></a></div>
                <p><a href="product_detail.php?id=<?php echo $spcungda['photo'];?>&link=<?php echo $spcungda['link'];?>&price=<?php echo $spcungda['giamoi']?>"><?php echo $format->textShorten($spcungda['title'],50) ?></a></p>
                <span><?php echo number_format( $spcungda['giamoi']); ?><sup>đ</sup></span>
            </div>
        
    
            
            <!-- <div class='box'>
                <img src="images/profile-1.jpg" alt="" srcset="">
                <p>panadol Extra</p>
                <span>122.088đ</span>
            </div>
            <div class='box'>
                <img src="images/profile-1.jpg" alt="" srcset="">
                <p>panadol Extra</p>
                <span>122.088đ</span>
            </div>
            <div class='box'>
                <img src="images/profile-1.jpg" alt="" srcset="">
                <p>panadol Extra</p>
                <span>122.088đ</span>
            </div> -->
<?php
    }?></div>      
    <div class="chuyensp"><?php
    if($demluotsp<($demsomach/4)){ ?> 
                    <span><a href="product_detail.php?id=<?php echo $result['photo'];?>&link=<?php echo $result['link'];?>&price=<?php echo $result['giamoi']?>&luotsp=<?php echo ($demluotsp + 1);?>">></a></span>
                
                <?php } ?></div>
    </div>
    </div>
    <?php        }}
    ?>
    <style>
           .sanphamlienquan{
            width: 110%;
            margin-bottom: 2rem;
        }
        .sanphamlienquan .danhsach .chuyensp span{
            align-items: center;
            height: 100%;
            
        }
        .sanphamlienquan .danhsach .contai .box:hover a {
            transform: translateY(-5px);
            transition: 1s all ease;
            color: gold;
        }

        .sanphamlienquan .danhsach .chuyensp span a{
            font-size: 25px;
            color:chocolate;

        }
        .sanphamlienquan .danhsach .chuyensp span a:hover{
            font-size: 30px;

        }
        .sanphamlienquan .danhsach{
            display: grid;
            grid-template-columns: 2rem auto 2rem;
            align-items: center;
        }
        .sanphamlienquan .danhsach .contai{
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sanphamlienquan .danhsach .contai .box{
            margin: 1rem;
            width: 21%;
            height: 21rem;
            background-color: #fff;
            border: 1px solid black;
            border-radius: 10px;
            
        }
        .sanphamlienquan .danhsach .box .image a{
            width: 100%;
            height: 13.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5%;
            transition:  .5s all ease;
        }
        .sanphamlienquan .danhsach .box img{
            width: 80%;
            border-radius: 5px;
            transition:  .5s all ease;
        }
        .sanphamlienquan .danhsach .box .image a img:hover{
            margin-top: 3%;
            margin-bottom: 13%;
            transition:  .5s all ease;
            transform: translateY(3px);
        }
        .sanphamlienquan .danhsach .box p a{
            color: #7380ec;
            font-size: 16px;
        }
        .sanphamlienquan .danhsach .box p{
            width: 80%;
            margin: 0 10% 1%;
            color: #7380ec;
            font-size: 16px;
        }
        .sanphamlienquan .danhsach .box p a:hover{
            color: gold;
        }
        .sanphamlienquan .danhsach .box span{
            width: 80%;
            margin: 0 10% 10%;
            color:crimson;
            font-size: 18px;
            display: flex;
            justify-content: right;
        }
    </style>
    
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
          
         

