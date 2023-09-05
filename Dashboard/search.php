
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

            <! END OF ASIDE>
<?php  include ('inc/deshboad.php'); ?>
 
      <?php $fm = new Format();
    $product=new product();
    $trangthu=1;
    $from=1;
    $to=1;
    
    if($_SERVER["REQUEST_METHOD"]== 'GET' && isset($_GET['submit'])){
        $search=$_GET['keyword'];
        
        $_SESSION['search']=$search;
        
    }
    $search=$_SESSION['search'];
    $demtrang = $product->count_search($search);
    $demd = $demtrang->fetch();
    $sotrang=$demd['count'];
    $trang=ceil($sotrang/10);
    $_SESSION['sotrangsearch']=$trang;

    if(isset($_GET['trang'])){
        $trangthu=$_GET['trang'];
        $from=$trangthu-4; if($from<3){$from=1;}
        $to=$trangthu+4; if($to>$trang){$to=$trang;}
        $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
        $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
    }else{        
        $from=$trangthu-4; if($trangthu<4){$from=1;}
        $to=$trangthu+4; if($to>$trang){$to=$trang;}
        $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
        $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
    }

   
    $product_search=$product->search($_SESSION['search'],$trangthu,10);
    
     

    
    $giabd=[];
    $tenbd=[];
    $nguonbd=[];
?>
                </div>
                <div class="recent-order">
                <style>
                        #pagination {
                            display: flex;
                            text-align: center;
                            justify-content: center;
                        }
                        #pagination a{
                            display: flex;
                            text-align: center;
                            padding: 5px 8px;
                            margin: 5px;
                            background:bisque;
                            border-radius: 3px;
                        }
                        #pagination a:hover{
                            color: #0000BB;
                            background: #fff;
                        }
                    </style>
                    <h2>TỪ KHÓA TÌM KIẾM: <?php if(isset($_SESSION['search'])){echo $_SESSION['search']; } elseif(isset($search)) {echo $search;}?> </h2>
                    <div id="pagination">
                            <a href="search.php?&word=<?=($search)?>&trang=<?=(1)?>" id="start">Trang đầu</a>
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&trang=<?=(1)?>" id="st" style="display:none" ">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&trang=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="pa".($i);
                            }
                            $next=1; 
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&trang=<?=($nextpage)?>" id="ne" style="display:none" ">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&trang=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        <a href="search.php?&word=<?=($search)?>&trang=<?=($trang)?>" id="end">Trang cuối</a>
                    </div>
                    <table>
                    <!-- <?php
                        $pro = new product();
                            $demcol = $pro->search($search);
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                     ?> -->
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
                                ?>
                                <th>Giá cũ</th>
                                <th>Thời gian</th>
                                <th>Giá mới</th>
                                <th>Thời gian</th>
                                <?php
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
                        text-align: left;
                        color: #333;
                        }

                            .recent-order tbody tr td:nth-child(2):hover a{
                                color: rgb(221, 50, 50);
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
                            .nguond .thea {
                                transition: all .5s ease;
                                color:#1250dc;
                                font-weight: bold;
                                text-align: left;
                            } 

                            .nguond .thea:hover {
                                color:#acc0f3;
                            }
                            .nguone .thea {
                                transition: all .5s ease;
                                color:#5dac46;
                                font-weight: bold;
                                text-align: left;
                            } 

                            .nguone .thea:hover {
                                color:#0f62f9;
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
                                     <tr onclick="handleClick(event)" id="tbody" class="tr">
                                        <td><?php echo $j;?></td>
                                        <td class="title" style="color: #333; font-weight: bold;"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
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
                                        <td class="primary" style="text-align: right; padding-left: 5px; color:coral">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td class="primary" style="text-align: right; padding-left: 5px; color:coral"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                        <?php } ?>
                                            
                                        <td class="primary" style="text-align: center; padding-left: 5px; color:#333;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td class="primary" style="text-align: right; padding-left: 5px; color:coral">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td class="primary" style="text-align: right; padding-left: 5px; color:coral"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>

                                        <td class="primary" style="text-align: center; padding-left: 5px; color:#333;"><?php echo $set['ngaymoi']; ?></td>

                                        
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
                                        <td class="primary" style="text-align: right; color:#00CC00; text-align:center;"><?php echo "+".$gialech."%" ?></td>
                                        <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                            <td class="primary" style="text-align: right; color:red; text-align:center;"><?php echo "-".$gialech."%" ?></td>
                                        <?php } else { ?>
                                            <td class="primary" style="text-align: right; color:blue; text-align:center;"><?php echo $gialech."%" ?></td>
                                        <?php } ?>
                                        <?php
                                        }else{
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
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                            <?php
                                            }else{
                                            ?>
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;"><?php 
                                            $priceString = (string) $set['giacu'];
    
                                            // Lấy số ký tự đầu tiên của giá trị
                                            $numberOfCharactersToMask = 2;
                                            $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                            
                                            // Tạo chuỗi dấu "*"
                                            $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                            $asterisksString = str_repeat('*', $numberOfAsterisks);
                                            
                                            // Hiển thị kết quả
                                            echo $maskedValue . $asterisksString; ?>đ</td>
                                            <?php } ?>
                                                
                                            <td class="primary" style="text-align: center; padding-left: 5px; color:coral;width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                            <?php
                                            }
                                            ?>
                                            <?php if($set['giamoi'] == 0){?>
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                            <?php
                                            }else{
                                            ?>
                                            <td class="primary" style="text-align: right; padding-left: 5px; width: 10%;"><?php 
                                            $priceString = (string) $set['giamoi'];
    
                                            // Lấy số ký tự đầu tiên của giá trị
                                            $numberOfCharactersToMask = 2;
                                            $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                            
                                            // Tạo chuỗi dấu "*"
                                            $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                            $asterisksString = str_repeat('*', $numberOfAsterisks);
                                            
                                            // Hiển thị kết quả
                                            echo $maskedValue . $asterisksString;?>đ</td>
                                            <?php } ?>
    
                                            <td class="primary" style="text-align: center; padding-left: 5px; color:coral; width: 10%;"><?php echo $set['ngaymoi']; ?></td>
                                            <?php
                                            
                                            }
                                            ?>
                                        <?php 
                                            if($set['nguon'] == 'thuocsi.vn'){
                                        ?>
                                         <td class="nguon"><a href="<?php echo $set['link'];?>" target="_blank" class="thea1"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'chosithuoc.com'){
                                        ?>
                                        <td class="nguona"><a href="<?php echo $set['link'];?>" target="_blank" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'ankhang.com'){
                                        ?>
                                        <td class="nguonb"><a href="<?php echo $set['link'];?>" target="_blank" class="thea"><?php echo $set['nguon'];?></a></td>
                                        <?php 
                                            }elseif($set['nguon'] == 'thuocsi.pharex.vn'){
                                                ?>
                                                <td class="nguonc"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">pharex.vn</a></td>
                                                <?php 
                                            }elseif($set['nguon'] == 'longchau.vn'){
                                                ?>
                                                <td class="nguond"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">longchau.vn</a></td>
                                                <?php 
                                            }elseif($set['nguon'] == 'pharmacity.vn'){
                                                ?>
                                                <td class="nguone"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">pharmacity.vn</a></td>
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
                            <a href="search.php?&word=<?=($search)?>&trang=<?=(1)?>" id="start">Trang đầu</a>
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&trang=<?=(1)?>" id="st" style="display:none" ">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&trang=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="p".($i);
                            }
                            $next=1; 
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&trang=<?=($nextpage)?>" id="ne" style="display:none" ">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&trang=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        <a href="search.php?&word=<?=($search)?>&trang=<?=($trang)?>" id="end">Trang cuối</a>
                    </div>
                    <!-- <a href="#">Show All</a> -->
                </div>
                <script>
                        // document.querySelector("#ne").style.background = '#C0C0C0';
                        // document.querySelector("#ne").style.color = 'black';
                        document.querySelector("#p<?php echo $numpage?>").style.background = '#fff';
                        document.querySelector("#pa<?php echo $numpage?>").style.background = '#fff';
                    </script>
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
                        margin-bottom: 5rem;
                        width: 88%;
                        margin: 0 5rem;
                        background-color: #fff;
                        border-radius: 2rem;
                        margin-top: 2rem;
                    }    
                    html{
                        margin-bottom: 5rem;
                    }

                    .div {
                        margin-top: 2rem;
                        height: 1rem;
                    }
                    
                </style>
            <?php
                if($checkLoginAdmin == 0){
            
            ?>
                <div class="recent-order sosanh"  style="padding-top:2.5rem;">
                    <h2 style="padding-top:1rem;">BIỂU ĐỒ SO SÁNH CHO TỪ KHÓA TÌM KIẾM: <?php if(isset($search)){echo $search; }?> </h2> 
                    <canvas id="myChart"  style="height: 300px; width: 88%; margin-bottom: 3rem;"></canvas>
                      
                        
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
            <div class="div">

            </div>
         

            </div>   <script src="js/time.js"></script>
            <?php include_once('inc/footer.php');
               
