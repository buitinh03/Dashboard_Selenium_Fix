<?php include_once('inc/header.php');
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
 <h2>SẢN PHẨM - <span style="color: green;"><i class="fa fa-caret-down dropdown__caret"></i><a href="https://thuocsi.vn/products" class="a" >Thuocsi.vn</a></span> - <span style="color: blue;"><i class="fa fa-caret-down dropdown__caret"></i><a href="https://chosithuoc.com/thuoc-xuong-khop-trang-1/" class="a" style="color: blue;">Chosithuoc.com</a></span></h2>
                
                <style>
                        #pagination {
                            display: flex;
                        }
                    </style>
                    <?php
                         $tongsanpham =  $pd->tongsanpham();
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){                   
                            $tong= $result['quantity'];
                         }
                         if($tong%50==0){$trang=$tong/50;}
                         else{$trang=$tong/50+1;}
                        }
                        ?>  
                    <div id="pagination">
                        <a href="#" id="pr">Previous</a>
                        <?php 
                        $page=array();                        
                        for($i=0;$i<$trang;$i++){
                            $page[$i]="p".($i+1);
                        }
                        $next=1; 
                        for($i=0;$i<$trang;$i++){
                            if($i<$next+9){                           
                            ?>
                            <a href="#" id=<?php echo "$page[$i]" ?>><?php echo ($i+1) ?></a>
                            <?php
                        }} ?>                        
                        <a href="#" id="next">Next</a>
                    </div>
                    <table id="mytable">
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
                                <?php
                                    for($k=1;$k<=12;$k++){
                                        ?>
                                        <th hidden>month_<?php echo $k ?></th>
                                <?php
                                    }
                                 ?>
                                
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
                                text-align: left;
                            }

                            .nguon a:hover{
                                color: #00CC00;
                            }
                            .nguona .thea {
                                transition: all .5s ease;
                                color: #0000BB;
                                font-weight: bold;
                                text-align: left;
                            } 

                            .nguona .thea:hover {
                                color: #3366FF;
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
                            <tr onclick="handleClick(event)" id="tbody" class="tr">
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

                                
                                <?php
                                    if($set['giamoi']!=0&&$set['giacu']!=0){
                                        if( $set['giamoi']>$set['giacu']){
                                           $gialech=($set['giamoi']/$set['giacu']*100)-100;
                                         }
                                        else $gialech=100-($set['giamoi']/ $set['giacu']*100);
                                    }else {$gialech= 0;}
                                    $gialech=round($gialech,2);
                                    if ($set['giamoi']>$set['giacu']&&$set['giacu']!=0){
                                ?>
                                <td class="primary" style="text-align: right; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                    <td class="primary" style="text-align: right; color:red"><?php echo "-".$gialech."%" ?></td>
                                <?php } else { ?>
                                    <td class="primary" style="text-align: right; color:blue"><?php echo $gialech."%" ?></td>
                                <?php } ?>

                                <?php 
                                    if($set['nguon'] == 'thuocsi.vn'){
                                ?>
                                <td class="nguon"><a style='text-align:right' href="<?php echo $set['link'];?>"><?php echo $set['nguon'];?></a></td>
                                <?php 
                                    }elseif($set['nguon'] == 'chosithuoc.com'){
                                ?>
                                 <td class="nguona"><a style='text-align:right' href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                 <?php 
                                    }else{
                                        ?>
                                        <td class="nguona"><a style='text-align:right; color:lightcoral' href="<?php echo $set['link'];?>" class="thea"><?php echo "Ankhang.com";?></a></td>
                                        <?php
                                    }
                                    ?>

                                

                                <td style="align-items: center; text-align:center; margin: 0 auto; width: 12%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
                                <?php
                                    for($k=1;$k<=12;$k++){
                                        ?>
                                        <td hidden><?php echo $set['month_'.$k] ?></td>
                                <?php
                                    }
                                 ?>
                            </tr>
                            <?php 
                                      }
                                 }
                            ?>
                       
                        </tbody>
                    </table>
                    
                 
                    <script>
                        
                        $(function() {
                            // Lấy phần chia trang và bảng
                            const pagination = $("#pagination");
                            const table = $("#mytable");                       
                            
                            // Đếm số dòng trong bảng
                            const rowCount = table.find(".tr").length;
                            // Đặt trang hiện tại thành 1
                            var currentPage = 1;

                            // Thêm một sự kiện lắng nghe cho liên kết "Previous"
                            const pr =document.getElementById("pr");
                            pr.addEventListener("click",function(){
                                if (currentPage > 1) {
                                currentPage--;
                                showPage(currentPage);
                            }
                            });
                                <?php 
                            $page=array();                        
                            for($i=0;$i<$trang;$i++){
                                $page[$i]="p".($i+1);
                            }
                            for($i=0;$i<$trang;$i++){
                            ?>
                            const <?php echo $page[$i] ?> =document.getElementById(<?php echo '"'.$page[$i].'"' ?>);
                                <?php echo $page[$i] ?>.addEventListener("click",function(){
                                    currentPage=<?php echo $i+1 ?>;
                                    // <?php $next=$i+1 ?>                                    
                                    showPage(currentPage);  })
                            <?php
                                
                            }?>
                            // Thêm một sự kiện lắng nghe cho liên kết "Next"
                            const next =document.getElementById("next");
                            next.addEventListener("click",function(){
                                
                                currentPage++;
                                showPage(currentPage);
                            }
                            );

                            // Hiển thị trang hiện tại
                            showPage(currentPage);

                            // Định nghĩa chức năng để hiển thị một trang
                            function showPage(page) {
                            // Ẩn tất cả các dòng trong bảng
                            table.find(".tr").hide();
                            // Lấy hàng tiêu đề
                            // const headerRow = table.rows[0];                            
                            // // Hiển thị hàng tiêu đề
                            // headerRow.style.display = "block";

                            // Hiển thị các dòng cho trang hiện tại

                            for (var i = (page - 1) * 50; i <page * 50 && i < rowCount; i++) {
                                table.find(".tr").eq(i).show();
                            }

                            // Cập nhật các liên kết chia trang
                            pagination.find("a.page").each(function() {
                                $(this).removeClass("active");
                            });

                            // Đặt liên kết hoạt động cho trang hiện tại
                            pagination.find("a.page").eq(page - 1).addClass("active");
                            }
                        });
                    </script>
                    
                </div>
            </main>
         
    <?php include_once('inc/footer.php') ?>
