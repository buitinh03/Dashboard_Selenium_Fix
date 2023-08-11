<?php 
include_once('inc/header.php');

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
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $product_stock = $_POST['product_stock'];
        $quantity = $_POST['quantity'];
        $addtoCart = $card->add_to_card($id, $product_stock ,$quantity);
        
    }

?>
<link rel="stylesheet" href="css/product_detail.css">
<section class="product-gallery-one">
<div class="container">

<div class="product">
    <?php
    $detailPro = $product->details_product($id);
    if($detailPro){
        $i =0;
        while($result = $detailPro->fetch()){
            $i++;
    ?>
    <div class="product-image">
       <img src="<?php echo $result['photo'] ?>" alt="">
        
    </div>

    <div class="product-details">
    <?php
    // if(isset($price)){
    //     echo $price;
    // }
    ?>
        <h1><?php echo $result['title'] ?></h1>

        <p>Mã sản phẩm: <?php echo $result['productid'] ?></p>

        <h2>Thời gian:</h2>
    
        <p style="color: black; margin-bottom: 3px;">Tháng: <span style="color: black; font-size: 18px;"><?php echo $i; ?></span></p>

        <div class="features">
            <h3>Đặc tính sản phẩm:</h3>
            <ul>
          
                <li><span>Nhà SX:</span><p><?php echo $result['nhasanxuat'] ?></p></li>
                <li><span>Nước SX:</span><p><?php echo $result['nuocsanxuat'] ?></p></li>
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
        <!-- <div class="form">
        <form action="" method="post" style="margin-top: 10px;">
            <label for="number" style="margin: 10px 0; font-size: 20px; ">Số lượng mua:</label>
            <input type="hidden" name="product_stock" id="" value="<?php echo $result['productQuantity'] ?>" style="font-size: 20px; width: 100px; padding: 1px 0;">
            <input type="number" name="quantity" id="number" value="1" min="1" class="number-one">
            <?php
              
                if($login_Check == false){
                    echo '';
                }else {
                    echo '  <li><a href="profile.php">Thông tin cá nhân</a></li>';
                }
                ?>
        
        </form>
        </div> -->

    </div>
            <?php
            }
        }
        ?>

</div>

</div>
