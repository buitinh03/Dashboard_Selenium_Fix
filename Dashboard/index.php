<?php 
        include_once('inc/deshboad.php');

?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

            <! END OF ASIDE>
            <script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
var loader = function() {
    setTimeout(function() {
        $('#loader').css({ 'opacity': 0, 'visibility':'hidden' });
    }, 2500);
};
$(function(){
    loader();
});
</script>
<section id="loader" class="section">
        <div class="loader">
            <span style="--i:1;"></span>
            <span style="--i:2;"></span>
            <span style="--i:3;"></span>
            <span style="--i:4;"></span>
            <span style="--i:5;"></span>
            <span style="--i:6;"></span>
            <span style="--i:7;"></span>
            <span style="--i:8;"></span>
            <span style="--i:9;"></span>
            <span style="--i:10;"></span>
            <span style="--i:11;"></span>
            <span style="--i:12;"></span>
<!--             <span style="--i:13;"></span>
            <span style="--i:14;"></span>
            <span style="--i:15;"></span>
            <span style="--i:16;"></span>
            <span style="--i:17;"></span>
            <span style="--i:18;"></span>
            <span style="--i:19;"></span>
            <span style="--i:20;"></span> -->
        </div>
    </section>
    <style>
        #theloaiban{
            position: relative;
            width: 5.1rem;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0.5rem;
            align-items: center;
            display: flex;
            justify-content: center;
            border-radius: 3px;
            background: bisque;
            color: #7380ec;
        }
        #xeptheotheloai i{
            position: relative;
            top: -1.9rem;
            left: 4.35rem;
            color: chocolate;
        }
    </style>
       <div class="recent-order">
 <h2>SẢN PHẨM     <form style="height: 1rem;" action="" method="get" id='xeptheotheloai'><select name="theloaiban" id="theloaiban" onchange="this.form.submit()">
        <option value="tatcasanpham"  <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'tatcasanpham') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='tatcasanpham'){echo "selected";}?>>Tất cả</option>
        <option value="bansi" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'bansi') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='bansi'){echo "selected";}?>>Bán sỉ</option>
        <option value="banle" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'banle'){unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='banle'){echo "selected";}?>>Bán lẻ</option></select>
        <noscript><button type="submit">Submit</button></noscript> 
        <?php 
        if(isset($_GET['theloaiban'])){
            unset($_SESSION['theloai']);
            $_SESSION['theloai']=$_GET['theloaiban'];
            $theloaiban=$_GET['theloaiban'];
            
        }elseif(isset($_SESSION['theloai'])){
            $theloaiban=$_SESSION['theloai'];
        }else $theloaiban='tatcasanpham';
         ?>
         <i class="fa fa-caret-down dropdown__caret"></i>
 </form>
 <?php 
 if($theloaiban=='tatcasanpham'){
    ?>
  - <span style="color: green; "><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.vn/products" target="_blank" class="a" >Thuocsi.vn</a></span> - <span style="color: blue;">
 <i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a" style="color:blue;">Chosithuoc</a></span>- <span style="color: #33CC33;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.nhathuocankhang.com/" class="a" style="color: #33CC33;">Ankhang.com</a></span> - <span style="color: #17a2b8;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a" style="color: #17a2b8; ">Pharex.vn</a></span> - <span style="color: #1250dc;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a" style="color: #1250dc; ">Longchau.vn</a></span> - <span style="color: #5dac46;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.pharmacity.vn/" class="a" style="color: #5dac46; ">Pharmacity.vn</a></span> - <span style="color: #F60B8A;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.medigoapp.com/" class="a" style="color: #F60B8A; ">Medigoapp.com</a></span></h2>
  <?php
 }elseif($theloaiban=='bansi'){
    ?>
  - <span style="color: green; "><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.vn/products" target="_blank" class="a" >Thuocsi.vn</a></span> - <span style="color: blue;">
 <i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a" style="color:blue;">Chosithuoc</a></span> - <span style="color: #17a2b8;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a" style="color: #17a2b8; ">Pharex.vn</a></span>  - <span style="color: #5dac46;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.pharmacity.vn/" class="a" style="color: #5dac46; ">Pharmacity.vn</a></span> - <span style="color: #F60B8A;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.medigoapp.com/" class="a" style="color: #F60B8A; ">Medigoapp.com</a></span></h2>
  <?php
 }elseif($theloaiban=='banle'){
    ?>
  - <span style="color: #33CC33;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.nhathuocankhang.com/" class="a" style="color: #33CC33;">Ankhang.com</a></span> - <span style="color: #1250dc;"><i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a" style="color: #1250dc; ">Longchau.vn</a></span></h2>
  <?php
 }
 
  ?>
       
 
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
                        .bloc p{
                            /* position:relative; */
                            color: chocolate;
                            /* margin-top: .5rem;                         
                            margin-left: .5rem; */
                        }
                        #pagination .bloc select{
                                
                                text-align: center;
                                padding: 7px 20px 7px 8px;
                             
                                background: bisque;
                                border-radius: 3px;
                              
                                color: #7380ec;
                                margin-left: 5px; 
                        }
                        
                        #pagination .bloc i{
                            position: relative;
                            left: -1.3rem;
                            color: chocolate;
                        }
                                                
                    </style>
                    <style>                       
                            .select-wrapper {
                            position: relative;
                            display: inline-block;
                            margin-bottom: 10px;
                            }

                            .select-dropdown {
                            width: 200px;
                            height: 40px;
                            padding: 10px;
                            font-size: 16px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            appearance: none;
                            -webkit-appearance: none;
                            background-color: #fff;
                            }

                            .select-dropdown:focus {
                            outline: none;
                            border-color: #2196F3;
                            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
                            }

                            .submit-btn {
                            padding: 10px 20px;
                            font-size: 16px;
                            border: none;
                            border-radius: 4px;
                            background-color: #2196F3;
                            color: #fff;
                            cursor: pointer;
                            }

                            .submit-btn:hover {
                            background-color: #1565C0;
                            }
                            

                    </style>
                    
                    
                    
                    <?php
                    $sotrang=1;
                         $tongsanpham =  $pd->tongsanpham($theloaiban);
                         if($tongsanpham){
                             while($result = $tongsanpham->fetch(PDO::FETCH_ASSOC)){                   
                            $tong= $result['quantity'];
                         }
                         if($tong%100==0){$trang=$tong/100;}
                         else{$trang=ceil($tong/100);}
                        }
                         
                                $format = new Format();
                                $pro = new product();
                                $trangthu=1;
                                $from=2;
                                $to=6;
                                $nextpage=2;
                        if(isset($_GET['trang'])){
                            $trangthu=$_GET['trang'];
                            $from=$trangthu-4; if($from<3){$from=2;}
                            $to=$trangthu+4; if($to>=$trang){$to=$trang-1;}
                            $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
                            $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
                        }
                        
                        ?>  
                    
                    <?php
                    
                        $pro = new product();
                            $demcol = $pro->testcol('giacu');
                            $demd = $demcol->fetch();
                            $sorow=$demd['sothu'];
                        ?>
                        <div id="pagination">
                            
                            <?php if($trangthu==1){ ?> 
                            <a href="index.php?&trang=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="index.php?&trang=<?=($previouspage)?>" id="pr"><</a>
                            <?php } 
                            ?>
                            <a href="index.php?&trang=<?=(1)?>" id="start">1</a>
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
                            
                            <a href="index.php?&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                        } ?>
                            <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?>
                            
                        <a href="index.php?&trang=<?=($trang)?>" id="end"><?php echo $trang?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="index.php?&trang=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="index.php?&trang=<?=($nextpage)?>" id="next">></a>
                        <?php } ?>
                        
                        <!-- <style>
                        .bloc p{
                            /* position:relative; */
                            color: chocolate;
                            /* margin-top: .5rem;                         
                            margin-left: .5rem; */
                        }
                        .bloc p select{
                            /* width: 6rem;
                            margin-left: .5rem;
                            padding: .5rem;
                            align-items: center;
                            display: flex;
                            justify-content: center;
                            border-radius: 3px;
                            
                            
                            margin-top: .3rem; */
                            display: flex;
                            color: #7380ec;
                                                
                            text-align: center;
                            padding: 5px 8px;
                            margin: 5px;
                            background: bisque;
                            border-radius: 3px;

                        }
                        .bloc h2 i{
                            /* position: absolute; */
                            margin-top: -1.5rem;
                             margin-left: 1.5rem;
                        }
                    </style> -->
                        <div class="bloc" style="display: flex;align-items: center;/* background: bisque; */border-radius: 3px;margin: 5px 5px 5px 3rem;">
                        <p>Sắp xếp theo: 
                        <form method="POST" action="index.php" class="boloc" >
                        <!-- <i class="fa fa-caret-down dropdown__caret"></i> -->
                            <select  name="myComboBox" onchange="this.form.submit()">
                                <option value="option1" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option1') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option1'){echo "selected";} ?>>Giá lệch</option> <i class="fa fa-caret-down dropdown__caret"></i>
                                <option value="option2" <?php if(isset($_POST['myComboBox']) && $_POST['myComboBox'] == 'option2') {unset($_SESSION['selectedValue']);echo "selected";}elseif(isset($_SESSION['selectedValue'])&&$_SESSION['selectedValue']=='option2'){echo "selected";} ?>>Thời gian</option><i class="fa fa-caret-down dropdown__caret"></i>
                            </select>                 
                            <noscript><button type="submit">Submit</button></noscript>                        
                            <?php
                            
                            if (isset($_POST['myComboBox'])) {
                                $selectedValue = $_POST['myComboBox'];
                                unset($_SESSION['selectedValue']);
                                $_SESSION['selectedValue'] = $selectedValue;
                            }elseif(isset($_SESSION['selectedValue'])){
                                $selectedValue=$_SESSION['selectedValue'];
                            } else {$selectedValue='option1';}
                            ?>
                            <i class="fa fa-caret-down dropdown__caret"></i>
                        </form></p>
                        
                    </div>
                    <?php $result = $pro ->getListproduct($theloaiban,$selectedValue,$trangthu,100);?>
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
                                        color:tomato;
                                        font-weight: bold;
                                        text-align: left;
                                    } 

                                    .nguonb .thea:hover {
                                        color:lightcoral;
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
                                    .recent-order tbody tr td:nth-child(2) a{
                                    cursor: pointer;
                                    color: rgb(221, 94, 94);
                                    transition: .5s all ease;
                                    text-align: left;
                                }
                                
                                .recent-order tbody tr td:nth-child(2):hover a{
                                    color: rgb(221, 50, 50);
                                    font-size: 14px;
                                }

                                 .nguon .thea1{
                                    transition: all .5s ease;
                                    color: green;
                                    font-weight: bold;
                                    text-align: left;
                                    
                                }
                                </style>
                                
                                <?php
                                if($result){
                                    $j=0;
                                    while($set = $result->fetch()){
                                        $j++
                                ?>
                            <tbody>
                                    <tr onclick="handleClick(event)" id="tbody" class="tr">
                                        <td><?php echo $j;?></td>
                                        <td class="title"><a style="color: #333; font-weight:bold;" href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <?php 
                                        if($sorow==0){
                                        ?>
                                        <td  style="text-align: center;">-</td>
                                        <td  style="text-align: center;">-</td>
                                        <?php   
                                        }else{
                                        ?>
                                        <?php if($set['giacu'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                        <?php
                                        }else{
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
                                        }else{
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 7%; color:crimson"><?php echo number_format( $set['giamoi']); ?><sup>đ</sup></td>
                                        <?php } ?>

                                        <td  style="text-align: center; padding-left: 5px;  width: 10%;"><?php echo $set['ngaymoi']; ?></td>

                                        
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
                                        if($sorow==0){
                                        ?>
                                        <td  style="text-align: center;">-</td>
                                        <td  style="text-align: center;">-</td>
                                        <?php   
                                        }else{
                                        ?>
                                        <?php if($set['giacu'] == 0){?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%;">Liên hệ</td>
                                        <?php
                                        }else{
                                        ?>
                                        <td  style="text-align: right; padding-left: 5px; width: 10%; color:crimson"><?php 
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
                                        $numberOfCharactersToMask = 2;
                                        $maskedValue = substr_replace($priceString, '*', $numberOfCharactersToMask);
                                        
                                        // Tạo chuỗi dấu "*"
                                        $numberOfAsterisks = strlen($priceString) - $numberOfCharactersToMask;
                                        $asterisksString = str_repeat('*', $numberOfAsterisks);
                                        
                                        // Hiển thị kết quả
                                        echo $maskedValue . $asteriskgoappsString;?>đ</td>
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
                                    </tr>
                                    <?php 
                                            }
                                        }
                                    ?>
                            
                                </tbody>
                            </table>
                            <div id="pagination" >
                            <?php if($trangthu==1){ ?> 
                            <a href="index.php?&trang=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="index.php?&trang=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            ?>
                            <a href="index.php?&trang=<?=(1)?>" id="start1">1</a>
                            <?php
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
                            
                            <a href="index.php?&trang=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                        } ?>
                            <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?>
                            
                        <a href="index.php?&trang=<?=($trang)?>" id="end1"><?php echo $trang?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="index.php?&trang=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="index.php?&trang=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                    </div>
                 
                    <script>
                     
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

                   
                     </script>
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
                </div>
               <style>
                    .quaylai {
                        display: none;
                        position: fixed;
                        font-size: 2rem;
                        text-align: right;
                        max-width: 97%;
                        color: #333;
                        cursor: pointer;
                        top: 50%;
                        right: 1.3%;
                        transition: .3s all ease;
                    }

                    .quaylai i {
                        transition: .3s all ease;
                        color: #fff;
                        font-size: 2.5rem;
                    }
                </style>
                <div class="quaylai">
                <i class="fas fa-chevron-circle-up" onclick="scrollUp()"></i><br>
                <i class="fas fa-chevron-circle-down" onclick="scrollDown()"></i>
                </div>
                <!-- <button class="quaylai" onclick="scrollUp()">Quay lại đầu trang</button> -->
                <div class="abc" style="margin-bottom: 1rem; height:1rem;"></div>

                <?php include_once("inc/footer.php");?>
               
