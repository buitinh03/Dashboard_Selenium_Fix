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
    $giabd=[];
    $tenbd=[];
    $nguonbd=[];
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
                             <?php
                            if($checkLoginAdmin == 0){

                            ?>    
                                <th>Giá cũ</th>
                                <th>Thời gian</th>
                                <th>Giá mới</th>
                                <th>Thời gian</th>
                                <th>Giá lệch</th>
                            <?php
                            }else {
                                echo "";
                            }
                            ?>
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

                             td:nth-child(7) a{
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
                           .nguon .thea1{
                                transition: all .5s ease;
                                color: green;
                                font-weight: bold;
                                text-align: left;
                            }
                           .nguonb .thea {
                            transition: all .5s ease;
                            color:#FFCC33;
                            font-weight: bold;
                            text-align: left;
                        } 

                        .nguonb .thea:hover {
                            color: #00DD00;
                        }
                        
                            .recent-order tbody tr td:nth-child(2) a{
                            cursor: pointer;
                            color: rgb(221, 94, 94);
                            transition: .5s all ease;
                            text-align: left;
                            }

                            .recent-order tbody tr td:nth-child(2):hover a{
                                color: rgb(221, 50, 50);
                                font-size: 13px;
                            }
                            .nguonc .thea {
                                        transition: all .5s ease;
                                        color:#17a2b8;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonc .thea:hover {
                                        color:#0000BB;
                                    }
                        </style>
                        <?php 
                        $format = new Format();
                        if(!empty($product_search) ){
                            $j=0;
                            while($set = $product_search->fetch()){
                                $giabd[$j]=$set['giamoi'];
                                $tenbd[$j]=$set['title'];
                                $nguonbd[$j]=$set['nguon'];
                                $j++
                        ?>
                            <tbody>
                            <tr >
                                <td><?php echo $j;?></td>
                                <td class="title"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $format->textShorten($set['title'],30) ?></a></td>
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
                                <?php if($set['giacu'] == 0){?>
                                        <td class="primary" style="text-align: right;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td class="primary" style="text-align: right;"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                        <?php } ?>
                                <td class="primary" style="text-align: center;"><?php echo $set['ngaycu']; ?></td>
                                <?php
                                }
                                ?>
                                  <?php if($set['giamoi'] == 0){?>
                                        <td class="primary" style="text-align: right;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td class="primary" style="text-align: right;"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>
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
                                <td class="nguon"><a href="<?php echo $set['link'];?>" class="thea1"><?php echo $set['nguon'];?></a></td>
                                <?php 
                                    }elseif($set['nguon'] == 'chosithuoc.com'){
                                ?>
                                 <td class="nguona"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                    <?php 
                                            }elseif($set['nguon'] == 'ankhang.com'){
                                        ?>
                                        <td class="nguonb"><a href="<?php echo $set['link'];?>" class="thea"><?php echo $set['nguon'];?></a></td>
                                 <?php 
                                 }elseif($set['nguon'] == 'thuocsi.pharex.vn'){
                                    ?>
                                    <td class="nguonc"><a href="<?php echo $set['link'];?>" class="thea">pharex.vn</a></td>
                                    <?php 
                                    }else{
                                        echo "";
                                    }
                                    ?>
                                <td style="align-items: center; text-align:center; margin: 0 auto; width: 12%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:30%; text-align:center; margin: 0 auto;"></td>
                             
                                <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
                            </tr>
                            <?php 
                                      }
                                 }
                            ?>
                       
                       
                        </tbody>
                    </table>
                    <!-- <a href="#">Show All</a> -->
                </div>
                <style>
                    main .recent-order canvas{
                    background: var(--color-white);
                    width: 100%;
                    border-radius:var(--card-border-radius) ;
                    padding :var(--card-padding);
                    text-align: center;
                    box-shadow: var(--box-shadow);
                    transition: all 300ms ease;
                    border: #0b0c0c 2px;
                    }

                    main .recent-order canvas:hover{
                    box-shadow: none;
                    }
                    .sosanh {
                        margin-bottom: 3em;
                    }        
                </style>
            <?php
                if($checkLoginAdmin == 0){
            
            ?>
                <div class="recent-order sosanh">
                    <h2>BIỂU ĐỒ SO SÁNH CHO TỪ KHÓA TÌM KIẾM: <?php if(isset($search)){echo $search; }?> </h2> 
                    <canvas id="myChart"  style="height: 300px; width: 100%;"></canvas>
                      
                        
                        <script>
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                            labels: [],
                                            datasets: []
                                        },
                                        options: {
                                            labels: {
                                                style: {
                                                    width:'auto',
                                                    overflow:'hidden',
                                                    textOverflow: 'ellipsis'
                                                }
                                            }
                                        }
                                    });
                            
                            function handleClick() {
                                var data = [];
                                var lb=[];
                                var lab=[];
                                <?php
                                for($y=0;$y<sizeof($giabd);$y++){
                                ?>
                                data[<?php echo $y?>]=parseInt(<?php echo $giabd[$y] ?>);
                                lb[<?php echo $y?>]='<?php echo $tenbd[$y] ?>'
                                lab[<?php echo $y?>]='<?php echo $nguonbd[$y] ?>'
                                <?php
                            
                                    };
                                 ?>
                                var dataset = {
                                    label:'Sản phẩm',
                                    data: data,
                                    backgroundColor: 'blue'
                                };
                    
                                myChart.data.labels = lb;
                                myChart.data.datasets = [dataset];
                                myChart.update();
                            }
                            
                            window.onload=handleClick;
                            var chart =document.getElementById('myChart');
                            chart.labels.addEventListener('mouseover',function(){
                                this.style.display = 'block';
                            });
                            chart.labels.addEventListener('mouseout',function(){
                                this.style.display = 'none';
                            });
                        </script>
                </div>
                    <?php
                }else {
                    echo "";
                }
                ?>
            </main>
            <! END OF MAIN>
        <?php include_once('inc/footer.php') ?>
