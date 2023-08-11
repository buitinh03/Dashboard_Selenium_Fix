<?php include "inc/header.php" ?>
            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
                </div>
               <style>
                   .recent-order tbody tr td:nth-child(8) a{
                        /* font-weight: bold; */
                        transition: 1s all ease;
                    }

                    .recent-order tbody tr td:nth-child(8) a:hover{
                        color: red;
                        font-size: 14px;
                    }

                    .recent-order tbody tr td:nth-child(8){
                        color: rgb(221, 94, 94);
                    }

                    .stt {
                        text-align: right;
                    }

                    .id {
                        text-align: right;
                    }

                    .warning {
                        text-align: left;
                    }

                    .primary {
                        text-align: right;
                    }

                    .nha-san-xuat {
                        text-align: left;
                    }

                    .nuoc-san-xuat {
                        text-align: left;
                    }

               </style>
                <div class="recent-order">
                    <h2>SẢN PHẨM</h2>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Nhà SX</th>
                                <th>Nước SX</th>
                                <th>Ảnh</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <?php 
                        $pro = new product();
                        $result = $pro ->getList();
                        if($result){
                            $j=0;
                            while($set = $result->fetch()){
                                $j++
                        ?>
                        <tbody>
                        
                            <tr>
                                <td class="stt"><?php echo $j;?></td>
                                <td class="id"><?php echo $set['productid']?></td>
                                <td class="warning"><?php echo $set['title']?></td>                         
                                <td class="primary"><?php echo number_format($set['price'])?><sup>đ</sup></td>
                                <td class="nha-san-xuat"><?php echo $set['nhasanxuat'] ?></td>
                                <td class="nuoc-san-xuat"><?php echo $set['nuocsanxuat']?></td>
                                <td><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td><a href="detail.php?id=<?php echo $set['photo'];?>&price=<?php echo $set['price']?>">Chi tiết</a></td>
                           
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