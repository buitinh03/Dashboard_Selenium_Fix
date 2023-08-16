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
                            
                            .nguon {
                                width: 10%;
                            }

                            td:nth-child(8) a{
                                transition: all .5s ease;
                                color: green;
                                font-weight: bold;
                            }

                            .nguon a:hover{
                                color: #00CC00;
                            }
                         
                        </style>
                        <?php 
                        $format = new Format();
                        if(!empty($product_search) ){
                            $j=0;
                            while($set = $product_search->fetch()){
                                $j++
                        ?>
                            <tbody>
                            <tr onclick="handleClick(event)">
                                <td><?php echo $j;?></td>
                                <td class="title"><?php echo $format->textShorten($set['title'],30) ?></td>
                                
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
                                <td class="primary" style="text-align: center;x"><?php echo $set['ngaymoi']; ?></td>
                                <?php if($set['nguon']=="thuocsi.vn") {?>
                                <td class="nguon"><a href="<?php echo $set['link'];?>"><?php echo $set['nguon']?></a></td>
                                <?php } elseif($set['nguon']=="chosithuoc.com"){ ?>
                                    <td class="nguon"><a href="<?php echo $set['link'];?>" style="color:#6699FF"><?php echo $set['nguon']?></a></td>
                                <?php } ?>
                                <td style="align-items: center; text-align:center; margin: 0 auto; width: 12%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
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
