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
    
        <p><?php echo $result['ngaymoi'] ?></p>

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
         if($price == $result['giamoi']){
            ?>
             <span ><?php echo number_format($result['giamoi']); ?><sup>đ</sup> (giá cũ)</span>
             <?php 
            }elseif($price > $result['giamoi']){
                ?>
            <span style="color: green;"><?php echo number_format($result['giamoi']); ?><sup>đ</sup> (giảm)</span>
            <?php 
            } else{
                ?>
            <span style="color: red;"><?php echo number_format($result['giamoi']); ?><sup>đ</sup> (tăng)</span>
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
                            <?php  
                            $format = new Format();
                            $pro = new product();
                            $result = $pro ->getListproduct();
             
                            if($result){
                            
                            while($set = $result->fetch()){ ?>
                         <tr>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_1']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_2']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_3']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_4']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_5']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_6']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_7']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_8']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_9']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_10']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_11']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['month_12']); ?><sup>đ</sup></td>
                                
                        </tr>
                            <?php 
                                      }
                                 }
                            ?>
                         </tbody>
                           
                        </table>
                       
                    </div>
                </div>
                        
            </div>
          </div>

          <?php
                            }
                        }
                        ?>

      
    </div>
 

          
         

