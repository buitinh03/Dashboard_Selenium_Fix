<?php include "inc/header.php";
    include_once('format/format.php');

?>
            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
                </div>
                <div class="recent-order">
                    <h2>SẢN PHẨM</h2>
                    
                    <table>
                    <?php
                        $pro = new product();
                            $demcol = $pro->testcol('giacu');
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                     ?>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>SL bán</th>
                                <th>Giá cũ</th>
                                <th>Thời gian</th>
                                <th>Giá mới</th>
                                <th>Thời gian</th>
                                <th>Nguồn</th>
                                <th>Ảnh</th>
                                <th>Chức năng</th>
                                
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

                         
                        </style>
                        
                        <?php 
                        $format = new Format();
                        $pro = new product();
                        $result = $pro ->getListproduct();
             
                        if($result){
                            $j=0;
                            while($set = $result->fetch()){
                                $j++
                        ?>
                        <tbody>
                            <tr onclick="handleClick(event)">
                                <td><?php echo $j;?></td>
                                <td class="title"><?php echo $set['title']?></td>
                                <td class="warning" style="text-align: right;"><?php echo $set['sales_in_last_24_hours'] ?></td>
                                <?php 
                                if($sorow==0){
                                ?>
                                <td class="primary" style="text-align: center;">-</td>
                                <td class="primary" style="text-align: center;">-</td>
                                <?php   
                                }else{
                                ?>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: center;"><?php echo $set['ngaycu']; ?></td>
                                <?php
                                }
                                ?>
                                <td class="primary" style="text-align: right;"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                <td class="primary" style="text-align: center;"><?php echo $set['ngaymoi']; ?></td>
                                <td class="title">thuocsi.vn</td>
                                <td style="align-items: center; text-align:center; margin: 0 auto;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>

                               
                               
                            </tr>
                            <?php 
                                      }
                                 }
                            ?>
                       
                        </tbody>
                    </table>
                    <a href="#">Show All</a>
                </div>
            </main>
         
    <?php include_once('inc/footer.php') ?>
