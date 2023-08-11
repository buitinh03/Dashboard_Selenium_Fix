<?php 
include_once('inc/header.php');
// include_once('inc/deshboad.php');
include_once('connect.php');

    $product = new product();
?>


<?php
    if(!isset($_GET['id']) || $_GET['id'] == NULL){
        echo "<script>window.location='index.php'</script>";
    }else{
        $id = $_GET['id'];
        $price = $_GET['price'];
    }

?>
<section class="product-gallery-one">
<div class="container">

<div class="product">
    <?php
    $detailPro = $product->details_product_2($id);
    if($detailPro){
        while($result = $detailPro->fetch()){
    ?>
    <div class="product-image">
       <img src="<?php echo $result['photo'] ?>" alt="">
        
    </div>

    <div class="product-details">
 
        <h1><?php echo $result['title'] ?></h1>

        <p>Đã bán: <?php echo $result['sales_in_last_24_hours'] ?></p>

        <h2>Thời gian:</h2>
    
        <p><?php echo $result['ngay'] ?></p>

        <div class="features">
            <h3>Đặc tính sản phẩm:</h3>
            <ul>
          
                <li><span>Nhà SX:</span><p><?php echo $result['nha_san_xuat'] ?></p></li>
                <li><span>Nước SX:</span><p><?php echo $result['nuoc_san_xuat'] ?></p></li>
                <!-- <li><span>Còn:</span><p><?php echo $result['productQuantity'] ?> cái</p></li> -->
               
            </ul>
        </div>

        <p class="price">Giá:
        <?php
         if($price == $result['price']){
            ?>
             <span ><?php echo number_format($result['price']); ?><sup>đ</sup> (giá cũ)</span>
             <?php 
            }elseif($price > $result['price']){
                ?>
            <span style="color: green;"><?php echo number_format($result['price']); ?><sup>đ</sup> (giảm)</span>
            <?php 
            } else{
                ?>
            <span style="color: red;"><?php echo number_format($result['price']); ?><sup>đ</sup> (tăng)</span>
            <?php 
            } 
            ?>
             
        </p>
      

    </div>
     
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
            <div class="container-cat">
                <div class="warranty-policy">
                    <div class="warranty-policy-h1">
                        <h1>BẢNG SO SÁNH GIÁ QUA CÁC THÁNG</h1>
                    </div>
                    <div class="warranty-policy-content">
                        <!-- <span>12 tháng gần nhất</span> -->
                            <?php
                                $thang=array();
                                
                                for($j=0;$j<12;$j++){
                                    $thang[$j]="month_".($j+1);
                                }
                            ?>
                            
                            <?php
                            $dam=0;
                            for($i=11;$i>=0;$i--){  
                                if($result[$thang[$i]]!= "") {
                                    $dam++;
                                } 
                                
                                if($result[$thang[$i]]!= ""&&$result[$thang[$i+1]]!= ""){
                                    
                           
                            if($result[$thang[$i]]==$result[$thang[$i+1]]){
                            ?>
                            <span class="spans"><?php echo "Tháng ".($dam); ?>
                            <li ><p style="color: black;"><span>+ </span><?php echo number_format($result[$thang[$i]]); ?><sup>đ</sup> <?php echo "(Giá không đổi(0%)  So với tháng ".($dam-1).")"?></p></li>
                            </span>
                            <?php 
                            }elseif($result[$thang[$i]]>$result[$thang[$i+1]]){
                            ?>
                            <?php  $phantram = $result[$thang[$i]] / $result[$thang[($i+1)]] * 100; $ket = $phantram - 100; $ketqua = round($ket * 100) / 100; ?>
                            <span class="spans"><?php echo "Tháng ".($dam); ?>
                            <li ><p style="color: red;"><span>+ </span><?php echo number_format($result[$thang[$i]]); ?><sup>đ</sup> <?php echo "(Giá tăng ".$ketqua." %  So với tháng ".($dam-1).")";?></p></li>
                            </span>
                            <?php 
                            }elseif($result[$thang[$i]]<$result[$thang[$i+1]]){
                            ?>
                            <?php $phantram = $result[$thang[$i+1]] / $result[$thang[($i)]] * 100; $ket = 100-$phantram; $ketqua = round($ket * 100) / 100; ?>
                            <span class="spans"><?php echo "Tháng ".($dam); ?>
                            <li ><p style="color: green;"><span>+ </span><?php echo number_format($result[$thang[$i]]); ?><sup>đ</sup> <?php echo "(Giá giảm ".$ketqua." % So với tháng ".($dam-1).")"?></p></li>
                            </span>
                            <?php }}
                            if($result[$thang[$i]]!= ""&&$result[$thang[$i+1]]== ""){
                            ?>
                                <span class="spans"><?php echo "Tháng ".($dam); ?>
                                <li ><p style="color: black;"><span>+ </span><?php echo number_format($result[$thang[$i]]); ?><sup>đ</sup><?php echo "(giá tháng".($dam).")"; ?></p></li>
                                </span>
                            <?php 
                            }
                            if($result[$thang[11]]!= ""){
                            ?>
                                <span class="spans"><?php echo "Tháng ".($dam); ?>
                                <li ><p style="color: black;"><span>+ </span><?php echo number_format($result[$thang[$i]]); ?><sup>đ</sup><?php echo "(giá tháng".($dam).")"; ?></p></li>
                                </span>
                            <?php 
            
                            }
                            
                        }   ?>    
                    </div>
                </div>
                        
            </div>
          </div>

          <?php
                            }
                        }
                        ?>

      
    </div>
 

          
         

