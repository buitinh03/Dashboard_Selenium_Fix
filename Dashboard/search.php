
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

    if(isset($_GET['page'])){
        $trangthu=$_GET['page'];
        $from=$trangthu-4; if($from<3){$from=2;}
        $to=$trangthu+4; if($to>$trang){$to=$trang-1;}
        $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
        $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
    }else{        
        $from=$trangthu-4; if($trangthu<4){$from=2;}
        $to=$trangthu+4; if($to>$trang){$to=$trang-1;}
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
                    <h2>TỪ KHÓA TÌM KIẾM: <?php
                                        if($checkLoginAdmin == 0){
                                        ?><li id="adress-form1" ><a href="#"><h3 style="margin-left: .5rem;font-size: 1.2rem;font-weight: bold;color: #7380ec;background: bisque;padding: 5px;margin-right: .5rem;margin-top: -.5rem;border-radius: 5px;">Cập nhật</h3></a></li><?php }?>
                         <?php if(isset($_SESSION['search'])){echo $_SESSION['search']; } elseif(isset($search)) {echo $search;}?> </h2>
                    
                    
                        <div class="adress-form1">
                            <div class="adress-form-content">
                                <h2>Cào Dữ Liệu Website <span id="adress-close1">X Đóng</span></h2>

                                    <form action="#" method="post">
                                   <p style="font-weight: bolder;">Bạn có muốn thực hiện cào giá theo từ khóa: </p>
                                   <h5><?php echo $search ?></h5>

                                   <button type="submit" name="Capnhattimkiem" id="runButton1">Xác nhận</button><br><br>
                                    <label for="" style="font-size: 1rem;">Quá trình cào dữ liệu có thể mất khá nhiều thời gian, vui lòng chờ !</label>
                                    
                        <?php
                            if($_SERVER['REQUEST_METHOD']=='POST'){
                                if(isset($_POST['Capnhattimkiem'])){
                                    ini_set('max_execution_time', (3600*24*7));
                                    ignore_user_abort(true);
                                    $pro = new product();
                                    $duongdanf=require('db_config.php');
                                    $sc=$pro->search_capnhat($search,'thuocsi.vn');
                                    // while($la=$sc->fetch()){
                                    //     system('python ../backend/product_link/thuocsi_link.py '.$la['link'].'');
                                    // }
                                    // // $sc=$pro->search_capnhat($search,'"chosithuoc.com"');
                                    // // while($la=$sc->fetch()){
                                    // //     system('python ../backend/product_link/longchau_link.py '.$la['link'].'');
                                    // // }
                                    // $sc1=$pro->search_capnhat($search,'pharmacity.vn');
                                    // while($la1=$sc1->fetch()){
                                    //     system('python ../backend/product_link/pharmacity_link.py '.$la1['link'].'');
                                    // }
                                    // $sc2=$pro->search_capnhat($search,'thuocsi.pharex.vn');
                                    // while($la2=$sc2->fetch()){
                                    //     system('python ../backend/product_link/pharex_link.py '.$la2['link'].'');
                                    // }
                                    // $sc3=$pro->search_capnhat($search,'medigoapp.com');
                                    // while($la3=$sc3->fetch()){
                                    //     system('python ../backend/product_link/medigoapp_link.py '.$la3['link'].'');
                                    // }
                                    // $sc4=$pro->search_capnhat($search,'ankhang.com');
                                    // while($la4=$sc4->fetch()){
                                    //     system('python ../backend/product_link/ankhang_link.py '.$la4['link'].'');
                                    // }
                                    // $sc5=$pro->search_capnhat($search,'longchau.vn');
                                    // while($la5=$sc5->fetch()){
                                    //     system('python ../backend/product_link/longchau_link.py '.$la5['link'].'');
                                    // }
                                    $tam;
                                    $qww='';
                                    $qww1='';
                                    $qww2='';
                                    $qww3='';
                                    $qww4='';
                                    $qww5='';
                                    $qww6= '';
                                    $qwwd=0;
                                    $qwwd1=0;
                                    $qwwd2=0;
                                    $qwwd3=0;
                                    $qwwd4=0;
                                    $qwwd5=0;
                                    $qwwd6=0;
                                    $po=1;
                                     while($la=$sc->fetch()){
                                       $tam=$la['link']; 
                                       $qww=$qww.' '.$tam ;
                                       $qwwd=$qwwd+1;
                                    }
                                    
                                    
                                    // $sc=$pro->search_capnhat($search,'"chosithuoc.com"');
                                    // while($la=$sc->fetch()){
                                    //     system('python ../backend/product_link/longchau_link.py '.$la['link'].'');
                                    // }
                                    $sc1=$pro->search_capnhat($search,'pharmacity.vn');
                                    while($la1=$sc1->fetch()){
                                        $tam=$la1['link']; 
                                        $qww1=$qww1.' '.$tam ;
                                        $qwwd1=$qwwd1+1;
                                    }
                                    $sc2=$pro->search_capnhat($search,'thuocsi.pharex.vn');
                                    while($la2=$sc2->fetch()){
                                        $tam=$la2['link']; 
                                       $qww2=$qww2.' '.$tam ;
                                       $qwwd2=$qwwd2+1;
                                    }
                                    $sc3=$pro->search_capnhat($search,'medigoapp.com');
                                    while($la3=$sc3->fetch()){
                                        $tam=$la3['link']; 
                                       $qww3=$qww3.' '.$tam ; 
                                       $qwwd3=$qwwd3+1;
                                    }
                                    $sc4=$pro->search_capnhat($search,'ankhang.com');
                                    while($la4=$sc4->fetch()){
                                        $tam=$la4['link']; 
                                        $qww4=$qww4.' '.$tam ;
                                        $qwwd4=$qwwd4+1;
                                    }
                                    $sc5=$pro->search_capnhat($search,'longchau.vn');
                                    while($la5=$sc5->fetch()){
                                        $tam=$la5['link']; 
                                       $qww5=$qww5.' '.$tam ;
                                       $qwwd5=$qwwd5+1;
                                    }
                                    $sc6=$pro->search_capnhat($search,'chosithuoc.com');
                                    while($la6=$sc6->fetch()){
                                        $tam=$la6['link']; 
                                       $qww6=$qww6.' '.$tam ;
                                       $qwwd6=$qwwd6+1;
                                    }if($qwwd>0){
                                        system('python '.$duongdanf['xpathcaogiathuocsi_link'] .$qww);
                                    }
                                    if($qwwd1>0){
                                        system('python '.$duongdanf['xpathcaogiapharma_link'] .$qww1);
                                        
                                    }
                                    if($qwwd2>0){
                                        system('python '.$duongdanf['xpathcaogiapharex_link'] .$qww2);
                                        
                                    }
                                    if($qwwd3>0){
                                        system('python '.$duongdanf['xpathcaogiamedigo_link'] .$qww3);
                                       
                                    }
                                    if($qwwd4>0){
                                        system('python '.$duongdanf['xpathcaogiaankhang_link'] .$qww4);
                                        
                                    }
                                    if($qwwd5>0){
                                        system('python '.$duongdanf['xpathcaogialongchau_link'] .$qww5);
                                        
                                    }
                                    if($qwwd6>0){
                                        system('python '.$duongdanf['xpathcaogiachosithuoc_link'] .$qww6);
                                        
                                    }
                                    ?>
                                    <script>window.location.href='search.php';</script>
                                    <?php
                                }
                            }
                         ?>
                    </form>
                            </div>
                        </div>
                        <style>
                            .adress-form1 .adress-form-content h2 {
                            margin-left: 0;
                            margin-top: -.5rem;
                            justify-content: center;
                            }
                            .adress-form1 .adress-form-content h5{
                                padding: 5px;
                                font-size: 16px;
                                color: #fd7e14;
                            }
                            .adress-form1 {
                                position: fixed;
                                width: 100vw;
                                height: 100vh;
                                background-color: rgba(0, 0, 0, 0.3);
                                top: 0;
                                left: 0;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                text-align: center;
                                color: #333;
                                display: none;
                                z-index: 999;
                                }
                                .adress-form1 .adress-form-content{
                                    font-size: 16px;
                                    padding: 12px 0;
                                    border-bottom: 1px solid #333;
                                    position: relative;
                                    color: #333;
                                    margin-top: 10px;
                                    margin-bottom: 0.8rem;
                                    height: auto;
                                }
                                .adress-form1 .adress-form-content p{
                                    font-size: 15px;
                                }
                        </style>
                        <script>
                            // Click vào Button Địa chỉ
                            const adressbtn1 = document.querySelector('#adress-form1')
                            // Click vào nút đóng ở phần địa chỉ giao hàng
                            const adressclose1 = document.querySelector('#adress-close1')

                            // const rightbtn = document.querySelector('.fa-chevron-right')
                            // console.log(rightbtn)
                            adressbtn1.addEventListener("click", function(){
                                document.querySelector('.adress-form1').style.display = "flex"
                            })

                            adressclose1.addEventListener("click", function(){
                                document.querySelector('.adress-form1').style.display = "none"
                            })

                        </script>
                    <?php if($trang>1){
                    ?>
                    <div id="pagination">
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&page=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="start">1</a>

                            <?php
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="pa".($i);
                            }
                            $next=1; 
                            if(($from-1)>1){
                                ?>
                            <a href="#">...</a>
                            
                            <?php    
                            }
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($trang)?>" id="end"><?php echo $trang?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                       
                    </div>
                    <?php } ?>
                    <table>
                    <!-- <?php
                        $pro = new product();
                            $demcol = $pro->search($search);
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                     ?> -->
                        <thead style="color:#FF8247;">
                                    <tr>
                                        <th>STT</th>
                                        <th>TÊN SẢN PHẨM</th>
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <th>GIÁ CŨ</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ MỚI</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ LỆCH</th>
                                        <?php
                                        }else{
                                        ?>
                                        <th>GIÁ CŨ</th>
                                        <th>THỜI GIAN</th>
                                        <th>GIÁ MỚI</th>
                                        <th>THỜI GIAN</th>
                                        <?php
                                        }
                                        ?>
                                        <th>NGUỒN</th>
                                        <th>ẢNH</th>
                                        <th>CHỨC NĂNG</th>
                                        <?php
                                            for($k=1;$k<=12;$k++){
                                                ?>
                                                <th hidden>MONTH_<?php echo $k ?></th>
                                        <?php
                                            }
                                        ?>
                                        <th>MÃ CHUYỂN HÓA</th>
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
                            .nguonf .thea {
                                        transition: all .5s ease;
                                        color:#F60B8A;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonf .thea:hover {
                                        color:#fd7e14;
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
                                    <tr onclick="handleClick(event)" id="tbody" class="tr" style="font-size: 1rem;">
                                        <td><?php echo $j;?></td>
                                        <td class="title"><a style="color: #333; font-weight:bold;" href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <?php 
                                        if(is_null($set['giacu'])){
                                        ?>
                                        <td  style="text-align: center;">-</td>
                                        <td  style="text-align: center;">-</td>
                                        <?php   
                                        }else{
                                        ?>
                                        <?php if($set['giacu'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                        <?php
                                        }elseif($set['giacu'] == ''){
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson">-</td>
                                        <?php } else {
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson"><?php echo number_format( $set['giacu']); ?><sup>đ</sup></td>
                                        <?php } ?>
                                            
                                        <td  style="text-align: center; padding-left: 5px; width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                        <?php
                                        }elseif($set['giamoi'] == ''){
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson">-</td>
                                        <?php } else {
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>

                                        <td  style="text-align: center; padding-left: 5px;  width: 10%;"><?php echo $set['ngaymoi']; ?></td>

                                        
                                        <?php
                                            if($set['giamoi']!=0&&$set['giamoi']!=''&&$set['giacu']!=0&&$set['giacu']!=''){
                                                if( $set['giamoi']>$set['giacu']){
                                                $gialech=($set['giamoi']/$set['giacu']*100)-100;
                                                }
                                                else $gialech=100-($set['giamoi']/ $set['giacu']*100);
                                            }else {$gialech= 0;}
                                            $gialech=round($gialech,2);
                                            if ($set['giamoi']>$set['giacu'] && $set['giacu']!=0){
                                        ?>
                                        <td class="primary" style="text-align: center; width: 7%; color:#00CC00"><?php echo "+".$gialech."%" ?></td>
                                        <?php } elseif($set['giamoi']<$set['giacu']){ ?>
                                            <td class="primary" style="text-align: center; width: 7%; color:red"><?php echo "-".$gialech."%" ?></td>
                                        <?php } else { ?>
                                            <td  style="text-align: center; width: 7%;"><?php echo $gialech."%" ?></td>
                                        <?php } ?>
                                        <?php
                                        }else{
                                            ?>
                                                <?php 
                                            if(is_null($set['giacu'])){
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
                                            $numberOfCharactersToMask = 1;
                                            $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                            $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                            $asterisksString = str_repeat('*', $numberOfAsterisks);
                                            echo $maskedValue . $asterisksString;?>đ</td>
                                        <?php } ?>
                                        <td  style="text-align: center; padding-left: 5px; width: 10%;"><?php echo $set['ngaycu']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php if($set['giamoi'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%; color:crimson"><?php 
                                        $priceString = (string) $set['giamoi'];

                                        // Lấy số ký tự đầu tiên của giá trị
                                        $numberOfCharactersToMask = 1;
                                        $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                        
                                        // Tạo chuỗi dấu "*"
                                        $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                        $asterisksString = str_repeat('*', $numberOfAsterisks);
                                        
                                        // Hiển thị kết quả
                                        echo $maskedValue . $asterisksString;?>đ</td>
                                        <?php } ?>

                                        <td  style="text-align: center; padding-left: 5px; width: 10%; "><?php echo $set['ngaymoi']; ?></td>
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
                                                }elseif($set['nguon'] == 'medigoapp.com'){
                                                    ?>
                                                    <td class="nguonf"><a href="<?php echo $set['link'];?>" target="_blank" class="thea">medigoapp.com</a></td>
                                                    <?php  
                                            }else{
                                                echo "";
                                            }
                                            ?>

                                        

                                        <td style="align-items: center; text-align:center; margin: 0 auto; width: 5%; padding: 0 2px;" ><img src='<?php echo $set['photo'] ?>' style="width:100%; text-align:center; margin: 0 auto;"></td>
                                    
                                        <td class="chitiet"><a href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>">Chi tiết</a></td>
                                        
                                        <?php
                                            for($k=1;$k<=12;$k++){
                                                ?>
                                                <td hidden><?php echo $set['month_'.$k] ?></td>
                                        <?php
                                            }
                                        ?>
                                        <td><form action="#" method="post">
                                            <input type="text" name='machuyenhoa' >
                                            <button name='submitchuyenhoa'>Lưu</button>
                                        </form></td>
                                    </tr>
                                    <?php 
                                            }
                                        }
                                    ?>
                            
                                </tbody>
                    </table>
                    <?php if($trang>1){
                    ?>
                    <div id="pagination">
                            
                            <?php if($trangthu==1){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="search.php?&word=<?=($search)?>&page=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } ?><a href="search.php?&word=<?=($search)?>&page=<?=(1)?>" id="start1">1</a><?php
                            $page=array();                        
                            for($i=$from;$i<=$to;$i++){
                                $page[$i]="p".($i);
                            }
                            $next=1; 
                            if(($from-1)>1){
                                ?>
                            <a href="#">...</a>
                            
                            <?php    
                            }
                            for($i=$from;$i<=$to;$i++){
                                                     
                            ?>
                            <a href="search.php?&word=<?=($search)?>&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                            
                        } ?>
                        <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?>
                        <a href="search.php?&word=<?=($search)?>&page=<?=($trang)?>" id="end1"><?php echo $trang;?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="search.php?&word=<?=($search)?>&page=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                        
                    </div>
                    <?php } ?>
                    <!-- <a href="#">Show All</a> -->
                </div>
                <script>
                        // document.querySelector("#ne").style.background = '#C0C0C0';
                        // document.querySelector("#ne").style.color = 'black';
                        if(<?php echo $numpage?>==1){
                            document.querySelector("#start").style.background = '#fff';  
                            document.querySelector("#start1").style.background = '#fff';  
                        }
                        if(<?php echo $numpage?>==<?php echo $trang?>){
                            document.querySelector("#end").style.background = '#fff';  
                            document.querySelector("#end1").style.background = '#fff';
                        }
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
                    .chart-label {
                        white-space: normal;
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
            <?php include_once('inc/footer.php')?>
