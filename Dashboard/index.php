<?php include "inc/header.php";
    include_once('format/format.php');

?>
            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
                </div>
                <style>
                    main .recent-order .a{
                        text-align: start;
                        display:contents;
                        color: green;
                    }
                </style>
                <div class="recent-order">
                <h2>SẢN PHẨM - <span style="color: green;"><a href="https://thuocsi.vn/products" class="a" >Thuocsi.vn</a></span></h2>
                <style>
                    main .recent-order table{
                        
                        border: 2px;
                    }
                </style>
                    <table border="2">
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
                                <th>Giá lệch</th>
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
                                <td class="primary" style="text-align: center;"><?php echo $set['ngaymoi']; ?></td>
                                <?php
                                    if($set['giamoi']!=0&&$set['giacu']!=0){
                                        if( $set['giamoi']>$set['giacu']){
                                           $gialech=($set['giamoi']/$set['giacu']*100)-100;
                                         }
                                        else $gialech=100-($set['giamoi']/ $set['giacu']*100);
                                    }else {$gialech= 0;}
                                    $gialech=round($gialech,2);
                                    if ($set['giamoi']>$set['giacu']){
                                ?>
                                <td class="primary" style="text-align: right; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                    <td class="primary" style="text-align: right; color:red"><?php echo "-".$gialech."%" ?></td>
                                <?php } else { ?>
                                    <td class="primary" style="text-align: right; color:blue"><?php echo $gialech."%" ?></td>
                                <?php } ?>
                                <td class="nguon"><a href="<?php echo $set['link'];?>"></a><?php echo $set['nguon']?></td>
                                <td style="align-items: center; text-align:center; margin: 0 auto; width: 12%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
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
