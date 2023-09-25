<?php 
        include_once('inc/deshboad.php');

?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submitMasp'])){
        $id = $_GET['id_p'];
        $id_product = $_GET['text'];

        $insert_id_product = $pd->insert_id_product($id, $id_product);
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submitMasp_sua'])){
        $id_sua = $_GET['id_p_sua'];
        $id_product_sua = $_GET['text_sua'];

        $insert_id_product_sua = $pd->insert_id_product_sua($id_sua, $id_product_sua);
    }
    
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

            <! END OF ASIDE>
            <script src="https://code.jquery.com/jquery-latest.js"></script>
            <link rel="stylesheet" href="css/index.css">
<script>
var loader = function() {
    setTimeout(function() {
        $('#loader').css({ 'opacity': 0, 'visibility':'hidden' });
    }, 50);
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
   

       <div class="recent-order">
 <h2>SẢN PHẨM     <form style="height: 1rem; width:12rem;" action="" method="get" id="xeptheotheloai">
    <div class="select-wrapper">
        <select name="theloaiban" id="theloaiban" onchange="this.form.submit()">
            <option value="tatcasanpham" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'tatcasanpham') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='tatcasanpham'){echo "selected";}?> >Tất cả</option>
            <option value="bansi" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'bansi') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='bansi'){echo "selected";}?> >Bán sỉ</option>
            <option value="banle" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'banle'){unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='banle'){echo "selected";}?> >Bán lẻ</option>
            <option value="thuocsi" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'thuocsi') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='thuocsi'){echo "selected";}?> >Thuocsi</option>
            <option value="chosithuoc" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'chosithuoc') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='chosithuoc'){echo "selected";}?> >Chosithuoc</option>
            <option value="ankhang" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'ankhang'){unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='ankhang'){echo "selected";}?> >AnKhang</option>
            <option value="pharex" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'pharex') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='pharex'){echo "selected";}?> >Pharex</option>
            <option value="longchau" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'longchau') {unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='longchau'){echo "selected";}?> >Longchau</option>
            <option value="pharmacity" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'pharmacity'){unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='pharmacity'){echo "selected";}?> >Pharmacity</option>
            <option value="medigo" <?php if(isset($_GET['theloaiban']) && $_GET['theloaiban'] == 'medigo'){unset($_SESSION['theloai']);echo "selected";}elseif(isset($_SESSION['theloai']) && $_SESSION['theloai']=='medigo'){echo "selected";}?> >Medigo</option>
        </select>
        <noscript><button type="submit">Submit</button></noscript>
    </div>
 
        <?php 
        if(isset($_GET['theloaiban'])){
            unset($_SESSION['theloai']);
            $_SESSION['theloai']=$_GET['theloaiban'];
            $theloaiban=$_GET['theloaiban'];
            
        }elseif(isset($_SESSION['theloai'])){
            $theloaiban=$_SESSION['theloai'];
        }else $theloaiban='tatcasanpham';
         ?>
         <!-- <i class="fa fa-caret-down dropdown__caret" id="ico"></i> -->
 </form>
    </h2>
 <script>
    const icon = document.getElementById('ico');
icon.addEventListener("click", function(){
        
    // document.getElementById("xeptheotheloai").;
    document.getElementById("theloaiban").click();
});

 </script>
 <?php 
 if($theloaiban=='tatcasanpham'){
    ?>
   <h2 class="dsach"><span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.vn/products" target="_blank" class="a">Thuocsi.vn</a></span>  <span>-
 <i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a">Chosithuoc</a></span> <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.nhathuocankhang.com/" class="a">Ankhang.com</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a">Pharex.vn</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a">Longchau.vn</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.pharmacity.vn/" class="a" >Pharmacity.vn</a></span> <span> -<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.medigoapp.com/" class="a">Medigoapp.com</a></span></h2>
  <?php
 }elseif($theloaiban=='bansi'){
    ?><h2 class="dsach">
   <span class="dsach">-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.vn/products" target="_blank" class="a">Thuocsi.vn</a></span>  <span>-
 <i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a">Chosithuoc</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a">Pharex.vn</a></span>   <span >-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.pharmacity.vn/" class="a">Pharmacity.vn</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.medigoapp.com/" class="a">Medigoapp.com</a></span></h2>
  <?php
 }elseif($theloaiban=='banle'){
    ?>
    <h2 class="dsach">
   <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.nhathuocankhang.com/" class="a">Ankhang.com</a></span>  <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a">Longchau.vn</a></span></h2>
 <?php
 }elseif($theloaiban=='thuocsi'){
    ?> <h2 class="dsach"> <span >-<i class="fa fa-caret-down dropdown__caret"></i><a href="https://thuocsi.vn/products" target="_blank" class="a" >Thuocsi.vn</a></span></h2>
 <?php
 }elseif($theloaiban=='chosithuoc'){
    ?>
  <h2 class="dsach"> <span > -<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://chosithuoc.com/" class="a">Chosithuoc</a></span> </h2>
 <?php
 }elseif($theloaiban=='ankhang'){
    ?>
 <h2 class="dsach"> <span>-<i class="fa fa-caret-down dropdown__caret"></i> <a href="https://www.nhathuocankhang.com/" class="a" >Ankhang.com</a></span> </h2>
  <?php
 }elseif($theloaiban=='longchau'){
    ?>
<h2 class="dsach"> <span >-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://nhathuoclongchau.com.vn/" class="a">Longchau.vn</a></span></h2>
 <?php
 }elseif($theloaiban=='pharmacity'){
    ?>
<h2 class="dsach"> <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://www.pharmacity.vn/" class="a" >Pharmacity.vn</a></span></h2>
 <?php
 }elseif($theloaiban=='medigo'){
    ?>
 <h2 class="dsach"> <span>-<i class="fa fa-caret-down dropdown__caret"></i>
<a href="https://www.medigoapp.com/" class="a">Medigoapp.com</a></span></h2>
<?php
 }elseif($theloaiban=='pharex'){
    ?>
 <h2 class="dsach"> <span>-<i class="fa fa-caret-down dropdown__caret"></i>
 <a href="https://thuocsi.pharex.vn/products" class="a">Pharex.vn</a></span></h2>

<?php
 }
  ?>
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
        if(isset($_GET['page'])){
            $trangthu=$_GET['page'];
            $from=$trangthu-4; if($from<3){$from=2;}
            $to=$trangthu+4; if($to>=$trang){$to=$trang-1;}
            $previouspage=$trangthu-1;if($previouspage<2){$previouspage=1;}
            $nextpage=$trangthu+1;if($nextpage>$trang){$$nextpage=$trang;}
        }
        
        ?>  
    
    <?php
    
        $pro = new product();
            
        ?>
        <div id="pagination">
            
            <?php if($trangthu==1){ ?> 
            <a href="index.php?&page=<?=(1)?>" id="st" style="display:none">Trước</a>
            <?php }else{ ?> 
                <a href="index.php?&page=<?=($previouspage)?>" id="pr"><</a>
            <?php } 
            ?>
            <a href="index.php?&page=<?=(1)?>" id="start">1</a>
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
            
            <a href="index.php?&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
            <?php
        } ?>
            <?php
            if(($trang-$to)>1){
                ?>
            <a href="#">...</a>
            <?php
            } ?>
            
        <a href="index.php?&page=<?=($trang)?>" id="end"><?php echo $trang?></a>
        <?php if($trangthu>=$trang){ ?> 
            <a href="index.php?&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
            <?php }else{ ?>                     
        <a href="index.php?&page=<?=($nextpage)?>" id="next">></a>
        <?php } ?>
        
        
        <div class="bloc" >
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
            
        </form></p>
   
    </div>
    <?php $result = $pro ->getListproduct($theloaiban,$selectedValue,$trangthu,100);?>
    </div>
            <table id="mytable">                    
                <thead >
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
                        <th>MÃ CHUẨN HOÁ</th>
                        <th>CHỨC NĂNG</th>
                        <?php
                            for($k=1;$k<=12;$k++){
                                ?>
                                <th hidden>MONTH_<?php echo $k ?></th>
                        <?php
                            }
                        ?>
                        
                                
                                <?php
                                if($result){
                                    $j=0;
                                    while($set = $result->fetch()){
                                        $j++
                                ?>
                                <?php 
                            ?>
                            <tbody>
                                    <tr onclick="handleClick(event)" id="tbody" class="tr" >
                                        <td><?php echo $j;?></td>
                                        <td class="title"><a style="color: var(--color-info-dark); font-weight:bold;" href="product_detail.php?id=<?php echo $set['photo'];?>&link=<?php echo $set['link'];?>&price=<?php echo $set['giamoi']?>"><?php echo $set['title'] ?></a></td>
                                        
                                        <?php
                                        if($checkLoginAdmin == 0){
                                        ?>
                                        <?php 
                                        if(is_null($set['giacu']) or $set['giacu']==''){
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
                                        }elseif($set['giamoi'] == ""){
                                        ?>
                                         <td style="text-align: right; padding-left: 5px; width: 7%;">Liên hệ</td>
                                         <?php }else{ ?>
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
                                        if(is_null($set['giacu'])){
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
                                        $numberOfCharactersToMask = 1;
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
                                            }elseif($set['nguon'] == 'thuocsi.pharex.vn' or $set['nguon'] == 'pharex.vn'){
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
                                        <?php if($set['masp'] == null){?>
                                        <td><div>
                                        <?php if($checkLoginAdmin == 0){?>    
                                        <form action="" method="get" class='form-mach'>
                                            <input type="hidden" name="id_p" value="<?php echo $set['id']?>">
                                            <div class="input-flex" style="display: flex; justify-content: center;">
                                            <input type="text" name="text" value="" id="" placeholder="Thêm mã..." >
                                            <button type="submit" id="themma" name="submitMasp" style="background-color:#669966;">+</button>
                                            </div>
                                        </form></div></td>
                                        <?php }elseif($checkLoginAdmin == 1){?>    
                                        <form action="" method="get" class='form-mach'>
                                            <input type="hidden" name="id_p" value="<?php echo $set['id']?>">
                                            <input type="text" name="text" value="" id="" placeholder="Thêm mã..." >
                                            <!-- <button type="submit" id="themma" name="submitMasp" style="position:absolute; border: 1px solid #777777; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem; padding: .2rem .77rem;   background-color:#669966; color: #fff; cursor:pointer; margin-left: -2%;">+</button> -->
                                        </form></div></td>
                                        <?php } ?>
                                        <?php }else{ ?>
                                         
                                            <td><div >
                                            <form action="" method="get" class='form-mach'>
                                                <input type="hidden" name="id_p_sua" value="<?php echo $set['id']?>">
                                                <div class="input-flex" style="display: flex; justify-content: center;">
                                                <input type="text" name="text_sua" value="<?php echo $set['masp']?>" id="" placeholder="Sửa mã...">
                                                <?php if($checkLoginAdmin == 0){?>
                                                <button type="submit" id="suama" name="submitMasp_sua" style="background-color:darksalmon;"><i class="fa fa-save"></i></button>
                                                <?php } ?>
                                                </div>
                                                <a href="search.php?masp=<?php echo $set['masp']?>">SP Tương Tự <i class="fa fa-angle-right"></i></a>
                                            </form>
                                            
                                        </div></td>
                                        <?php } ?>
                                            
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
                            <a href="index.php?&page=<?=(1)?>" id="st" style="display:none">Trước</a>
                            <?php }else{ ?> 
                                <a href="index.php?&page=<?=($previouspage)?>" id="pr">Trước</a>
                            <?php } 
                            ?>
                            <a href="index.php?&page=<?=(1)?>" id="start1">1</a>
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
                            
                            <a href="index.php?&page=<?=($i)?>" id=<?php echo "$page[$i]" ?>><?php echo ($i) ?></a>
                            <?php
                        } ?>
                            <?php
                            if(($trang-$to)>1){
                                ?>
                            <a href="#">...</a>
                            <?php
                            } ?>
                            
                        <a href="index.php?&page=<?=($trang)?>" id="end1"><?php echo $trang?></a>
                        <?php if($trangthu>=$trang){ ?> 
                            <a href="index.php?&page=<?=($nextpage)?>" id="ne" style="display:none">Sau</a>
                            <?php }else{ ?>                     
                        <a href="index.php?&page=<?=($nextpage)?>" id="next">Sau</a>
                        <?php } ?>
                    </div>
                 
                    
                        <script>
                        if(<?php echo $trangthu?>==1){
                            document.querySelector("#start").style.background = '#fff';  
                            document.querySelector("#start1").style.background = '#fff';  
                        }
                        if(<?php echo $trangthu?>==<?php echo $trang?>){
                            document.querySelector("#end").style.background = '#fff';  
                            document.querySelector("#end1").style.background = '#fff';
                        }
                        document.querySelector("#p<?php echo $trangthu?>").style.background = '#fff';
                        document.querySelector("#pa<?php echo $trangthu?>").style.background = '#fff';
                    </script>
                </div>
               <style>
                    
                </style>
                <div class="quaylai">
                <i class="fas fa-chevron-circle-up" onclick="scrollUp()"></i><br>
                <i class="fas fa-chevron-circle-down" onclick="scrollDown()"></i>
                </div>
                <!-- <button class="quaylai" onclick="scrollUp()">Quay lại đầu trang</button> -->
                <div class="abc" style="margin-bottom: 1rem; height:1rem;"></div>

                <?php include_once("inc/footer.php");?>
               
