<?php include "inc/header.php" ?>
            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
<?php  include_once('format/format.php'); ?>
<?php 

    $fm = new Format();
    $product=new product();

    if($_SERVER["REQUEST_METHOD"]== 'POST' && isset($_POST['submit'])){
        $search=$_POST['keyword'];
        $product_search=$product->search($search);
    }

?>
                </div>
                <div class="recent-order">
                    
                    <h2>TỪ KHÓA TÌM KIẾM: <?php if(isset($search)){echo $search; }?> </h2>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Nhà SX</th>
                                <th>Nước SX</th>
                                <th>Thông tin</th>
                                <th>SL bán</th>
                                <th>Giá</th>
                                <th>Ảnh</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <?php 
                      
                        if(!empty($product_search) ){
                            $j=0;
                            while($set = $product_search->fetch()){
                                $j++
                        ?>
                            <tbody>
                            <tr>
                                <td><?php echo $j;?></td>
                                <td><?php echo $set['title']?></td>
                                <td><?php echo $set['nha_san_xuat'] ?></td>
                                <td><?php echo $set['nuoc_san_xuat']?></td>
                                <td><?php echo $fm->textShorten($set['thong_tin_san_pham'], 50)?></td>
                                <td class="warning"><?php echo $set['sales_in_last_24_hours']?></td>
                                <?php if($set['month_2'] == ""){
                                    ?>
                                <td class="primary"><?php echo number_format($set['month_1'])?><sup>đ</sup></td>
                                <?php
                                } elseif($set['month_3'] == ""){
                                ?>
                                 <td class="primary"><?php echo number_format($set['month_2'])?><sup>đ</sup></td>
                                 <?php 
                                }elseif($set['month_4'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_3'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_5'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_4'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_6'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_5'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_7'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_6'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_8'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_7'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_9'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_8'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_10'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_9'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_11'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_10'])?><sup>đ</sup></td>
                                    <?php 
                                }elseif($set['month_12'] == ""){
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_11'])?><sup>đ</sup></td>
                                    <?php 
                                }else{
                                ?>
                                    <td class="primary"><?php echo number_format($set['month_12'])?><sup>đ</sup></td>
                                    <?php 
                                }
                                ?>
                            
                                <td style="align-items: center; text-align:center; margin: 0 auto;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td><a href="product_detail.php?id=<?php echo $set['photo'];?>&price=<?php echo $set['price']?>">Chi tiết</a></td>
                                <!-- <td><a href="#">Sửa</a><a href="#">Xoá</a></td> -->
                                <!-- <td class="warning">Pending</td>
                                <td class="primary">Details</td> -->
                            </tr>
                            <?php 
                                      }
                                 }
                            ?>
                       
                        </tbody>
                    </table>
                    <!-- <a href="#">Show All</a> -->
                </div>
            </main>
            <! END OF MAIN>
        <?php include_once('inc/footer.php') ?>