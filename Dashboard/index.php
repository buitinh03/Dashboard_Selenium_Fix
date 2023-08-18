<?php include_once('inc/header.php');
    include_once('format/format.php');

?>
            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
                <?php 
                $numpage=1;
                if(isset($_GET['trang'])){
                    $numpage=$_GET['trang'];
                }
                 ?>
                </div>
                
                <style>
                    main .recent-order .a{
                        text-align: start;
                        display:contents;
                        color: green;
                    }
                </style>
                <div class="recent-order">
 <h2>SẢN PHẨM - <span style="color: green;"><i class="fa fa-caret-down dropdown__caret"></i><a href="https://thuocsi.vn/products" class="a" >Thuocsi.vn</a></span> - <span style="color: blue;"><i class="fa fa-caret-down dropdown__caret"></i><a href="https://www.nhathuocankhang.com/" class="a" style="color: blue;">Chosithuoc.com</a></span></h2>
                
                <style>
                        #pagination {
                            display: flex;
                        }
                        #pagination a{
                            display: flex;
                            text-align: center;
                            padding: 5px 10px;
                            margin: 5px;
                            background:bisque;
                            
                        }
                        #pagination a:hover{
                            color: #0000BB;
                            background: #00CC00;
                        }
                    </style>
                    <?php
                    $sotrang=1;
                         $tongsanpham =  $pd->tongsanpham();
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){                   
                            $tong= $result['quantity'];
                         }
                         if($tong%9==0){$trang=$tong/9;}
                         else{$trang=$tong/9+1;}
                        }
                        ?>  
                    
                    <?php
                    
                        $pro = new product();
                            $demcol = $pro->testcol('giacu');
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                        ?>
                        <div id="pagination">
                            <a href="index.php?&trang=<?=1?>" id="pr">Trước</a>
                            <?php 
                            
                            $page=array();                        
                            for($i=0;$i<15;$i++){
                                $page[$i]="p".($i+1);
                            }
                            $next=1; 
                            for($i=0;$i<15;$i++){
                                                     
                            ?>
                            <a href="index.php?&trang=<?=($i+1)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i+1) ?></a>
                            <?php
                            $trangthu=($i+1);
                        } ?>                        
                        <a href="index.php?&trang=<?=20?>" id="next">Sau</a>
                    </div>
                            <table id="mytable">                    
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <th>Giá cũ</th>
                                        <th>Thời gian</th>
                                        <th>Giá mới</th>
                                        <th>Thời gian</th>
                                        <th>Giá lệch</th>
                                        <?php
                                        }else{
                                            echo "";
                                        }
                                        ?>
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
                                    .nguonb .thea {
                                        transition: all .5s ease;
                                        color: #FFCCCC;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonb .thea:hover {
                                        color: #00FF00;
                                    }
                                </style>
                                
                                <?php 
                                $format = new Format();
                                $pro = new product();
                                $trangthu=1;
                                
                                if(isset($_GET['trang'])){
                                    $trangthu=$_GET['trang'];
                                }
                                $result = $pro ->getListproduct($trangthu,100);
                    
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
                                        if($checkLoginAdmin == 0){
                                        ?>
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
                                            if ($set['giamoi']>$set['giacu'] && $set['giacu']!=0){
                                        ?>
                                        <td class="primary" style="text-align: right; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                        <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                            <td class="primary" style="text-align: right; color:red"><?php echo "-".$gialech."%" ?></td>
                                        <?php } else { ?>
                                            <td class="primary" style="text-align: right; color:blue"><?php echo $gialech."%" ?></td>
                                        <?php } ?>
                                        <?php
                                        }else{
                                            echo "";
                                        }
                                        ?>
                                        <?php 
                                            if($set['nguon'] == 'thuocsi.vn'){
                                        ?>
                                        <td class="nguon"><a href="<?php echo $set['link'];?>"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'chosithuoc.com'){
                                        ?>
                                        <td class="nguona"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'nhathuocankhang.com'){
                                        ?>
                                        <td class="nguonb"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }else{
                                                echo "";
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
                            <div id="pagination">
                            <a href="#" id="pr">Trước</a>
                            <?php 
                            
                            $page=array();                        
                            for($i=0;$i<15;$i++){
                                $page[$i]="pa".($i+1);
                            }
                            $next=1; 
                            for($i=0;$i<15;$i++){
                                                     
                            ?>
                            <a href="index.php?&trang=<?=($i+1)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i+1) ?></a>
                            <?php
                            $trangthu=($i+1);
                        } ?>                        
                        <a href="#" id="next">Sau</a>
                    </div>
                 
                    <script>
                        
                    //     $(function() {
                    //         // Lấy phần chia trang và bảng
                    //         const pagination = $("#pagination");
                    //         const table = $("#mytable");                       
                            
                    //         // Đếm số dòng trong bảng
                    //         const rowCount = table.find(".tr").length;
                    //         // Đặt trang hiện tại thành 1
                    //         var currentPage = 1;
                            function changeColor(element) {
                                element.style.color="red";                                
                            }
                            // Thêm một sự kiện lắng nghe cho liên kết "Previous"
                            const pr =document.getElementById("pr");
                            pr.addEventListener("click",function(){                                
                              <?php if($trangthu>1){
                                $trangthu--;
                              } ?>
                              changeColor();                              
                            });
                            <?php 
                            
                            for($i=0;$i<$trang;$i++){
                            ?>
                            const <?php echo $page[$i] ?> =document.getElementById(<?php echo '"'.$page[$i].'"' ?>);
                                <?php echo $page[$i] ?>.addEventListener("click",function(){
                                    <?php $trangthu=($i+1); ?> 
                                    changeColor(document.getElementById(<?php echo '"'.$page[$i].'"' ?>));                                   
                                })
                                 
                            <?php
                                
                            }?>
                            // Thêm một sự kiện cho liên kết "Next"
                            const next =document.getElementById("next");
                            next.addEventListener("click",function(){                                
                                <?php if($trangthu<$trang)
                                    $trangthu++;
                                ?>
                                changeColor(); 
                            }
                            );

                    //         // Hiển thị trang hiện tại
                    //         showPage(currentPage);

                    //         // Định nghĩa chức năng để hiển thị một trang
                    //         function showPage(page) {
                    //         // Ẩn tất cả các dòng trong bảng
                    //         table.find(".tr").hide();
                    //         // const xhr = new XMLHttpRequest();
                    //         // xhr.open("GET", "/load_data.php");
                    //         // xhr.onload = function() {
                    //         // if (xhr.status === 200) {
                    //         //     // The data was loaded successfully
                    //         //     const data = JSON.parse(xhr.responseText);
                    //         //     // Do something with the data
                    //         // } else {
                    //         //     // The data was not loaded successfully
                    //         //     alert("Error loading data: " + xhr.status);
                    //         // }
                    //         // };
                    //         // xhr.send();
                    //         // Hiển thị các dòng cho trang hiện tại

                    //         for (var i = (page - 1) * 9; i <page * 9 && i < rowCount; i++) {
                    //             table.find(".tr").eq(i).show();
                    //         }

                    //         // Cập nhật các liên kết chia trang
                    //         pagination.find("a.page").each(function() {
                    //             $(this).removeClass("active");
                    //         });

                    // //         // Đặt liên kết hoạt động cho trang hiện tại
                    //         pagination.find("a.page").eq(page - 1).addClass("active");
                            
                    //     });
                    // </script>
                        <script>
                        document.querySelector("#p<?php echo $numpage?>").style.background = '#fff';
                        document.querySelector("#pa<?php echo $numpage?>").style.background = '#fff';
                    </script>
                </div>
            </main>
         
    <?php include_once('inc/footer.php') ?>
