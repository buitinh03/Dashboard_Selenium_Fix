<?php
    class connect{
        var $db=null;
        public function __construct(){
            $config = require 'db_config.php';
            $dns = "pgsql:host=".$config['host'].";port=".$config['port'].";dbname=".$config['database'].";user=".$config['user'].";password=".$config['password'];
            $this->db = new PDO($dns);

        }
        public function getList($select){
            $results=$this->db->query($select);
            return $results;
        }
        public function getInstance($select){
            $results=$this->db->query($select);
            $results=$results->fetch();
            return $results;
        }
        public function exec($select){
            $results=$this->db->query($select);
            return $results;
        }
    }
    class product{
        public function __construct(){

        }
        function getList(){
            $db=new connect();
            $select="select * from tbl_thuocsi";
            $result=$db->getList($select);
            return $result;
        }
        function insert_id_product($id, $id_product){
            $db=new connect();
            $query = "UPDATE thuocsi_vn SET masp='".$id_product."' WHERE id='".$id."'";
            $result = $db->exec($query);
            // if($result){
            //     echo "<span class='success' style='color: #0000FF; font-size: 1rem; margin-left: 4rem; margin-top: 5rem;'>Thêm mã sản phẩm thành công!</span>";
            // }else {
            //     echo "<span class='error' style='color:  #FF0000; font-size: 1rem; margin-left: 4rem; margin-top: 5rem;'>Thêm mã sản phẩn thất bại !</span>"; 
            // }
            return $result;
        }

        function insert_id_product_sua($id_sua, $id_product_sua){
            $db=new connect();
            $query = "UPDATE thuocsi_vn SET masp='$id_product_sua' WHERE id='$id_sua'";
            $result = $db->exec($query);
            // if($result){
            //     echo "<span class='success' id='suama' style='color: #0000FF; font-size: 1rem; margin-left: 4rem; margin-top: 5rem;'>Sửa mã sản phẩm thành công!</span>";
            // }else {
            //     echo "<span class='error' id='suama' style='color:  #FF0000; font-size: 1rem; margin-left: 4rem; margin-top: 5rem;'>Sửa mã sản phẩn thất bại !</span>"; 
            // }
            return $result;
        }

        function getListproduct($theloai='tatcasanpham',$value='option1',$start=1,$limit=0){
            $db=new connect();
            if($theloai=='tatcasanpham'){
            if($value=='option1'){
            $select=" SELECT *,
                            CASE
                                WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
                                WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
                                WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
                                ELSE 0
                                END AS gialech   
                            FROM thuocsi_vn ORDER BY  gialech desc" ;
                if($limit!=0){
                    $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                }           
        }else {
                $select="SELECT *          
                FROM thuocsi_vn ORDER BY ngaymoi desc ";
                if($limit!=0){
                    $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                }                    
            }}elseif($theloai=='bansi'){
                if($value=='option1'){
                    $select="SELECT *,
                        CASE
                            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
                            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
                            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
                            ELSE 0
                            END AS gialech   
                        FROM thuocsi_vn WHERE nguon='thuocsi.vn' or nguon='chosithuoc.com' or nguon='thuocsi.pharex.vn' or nguon='pharmacity.vn' or nguon='medigoapp.com' ORDER BY gialech desc ";
                        if($limit!=0){
                            $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                        }           
                }else {
                        $select="SELECT *          
                        FROM thuocsi_vn WHERE nguon='thuocsi.vn' or nguon='chosithuoc.com' or nguon='thuocsi.pharex.vn' or nguon='pharmacity.vn' or nguon='medigoapp.com' ORDER BY ngaymoi desc ";
                        if($limit!=0){
                            $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                        }      }}              
                    elseif($theloai=='banle'){
                        if($value=='option1'){
                            $select="SELECT *,
                                CASE
                                    WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
                                    WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
                                    WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
                                    ELSE 0
                                    END AS gialech   
                                FROM thuocsi_vn WHERE nguon='ankhang.com' or nguon='longchau.vn' ORDER BY gialech desc ";
                                if($limit!=0){
                                    $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                                }           
                        }else {
                                $select="SELECT *          
                                FROM thuocsi_vn WHERE nguon='ankhang.com' or nguon='longchau.vn' ORDER BY ngaymoi desc ";
                                if($limit!=0){
                                    $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
                                }                    
                            }
                    }

            $result=$db->getList($select);
                    return $result; 
        }   
        function search($value='option1',$name,$st=0,$limited=0){
            $db =  new connect();
            if($value=='option1'){
            $query="SELECT *,
        CASE
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
            ELSE 0
            END AS gialech   
        FROM thuocsi_vn where unaccent(title) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(nguon) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(cast((to_char(ngaymoi, 'dd-mm-YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(cast((to_char(ngaymoi, 'dd/mm/YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*')
         ORDER BY COALESCE(masp, '') desc, gialech desc ";
         if($st!=0){
            $query=$query." limit ".$limited." offset "."((".$st."-1)*".$limited.")";
         }
         $result = $db->getList($query);
            return $result;
        }else{
            $query="SELECT * FROM thuocsi_vn where unaccent(title) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(nguon) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(cast((to_char(ngaymoi, 'dd-mm-YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*') 
         or unaccent(cast((to_char(ngaymoi, 'dd/mm/YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*')
         ORDER BY COALESCE(masp, '') desc, ngaymoi desc ";
         if($st!=0){
            $query=$query." limit ".$limited." offset "."((".$st."-1)*".$limited.")";
         }
         $result = $db->getList($query);
            return $result;
         }
             
        }     
        function analysischart(){
            $db=new connect();
            $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn";
            $result = $db->getList($query);
            return $result;

        }
        function updatech($mach, $link){
            $db =new connect();
            $query="update thuocsi_vn set masp='".$mach."' where link = '".$link."'";
            $result = $db->exec($query);
            return $result;
        }
        function selectch($mach, $limited=0,$st=0){
            $db =new connect();
            $query="select * from thuocsi_vn  where masp= trim('".$mach."') ORDER BY cast(giamoi as real) asc limit ".$limited." offset "."((".$st."-1)*".$limited.")";;
            $result = $db->exec($query);
            return $result;
        }
        function countmach( $mach){
            $db = new connect();
            $query= "select count(*) as demmach from thuocsi_vn where masp = '".$mach."'";
            $result = $db->exec($query);
            return $result;
        }
        // function charproductorder(){
        //     $db=new connect();
        //     $query = "SELECT sum(sales_in_last_24_hours) as sale from thuocsi_vn";
        //     $result = $db->exec($query);
        //     return $result;

        // }

        function chartSumproductorder(){
            $db=new connect();
            $query = "SELECT SUM(price) AS orderprice FROM tbl_thuocsi";
            $result = $db->getList($query);
            return $result;

        }

        function details_product($id){
            $db =  new connect();
            $query = "SELECT * FROM tbl_thuocsi WHERE photo='$id'";
            $result = $db->getList($query);
            return $result;
        }

        function details_product_2($id, $link){
            $db =  new connect();
            $query = "SELECT * FROM thuocsi_vn WHERE photo='$id' AND link='$link'";
            $result = $db->getList($query);
            return $result;
        }
        function details_product_3($masp){
            $db =  new connect();
            $query = "SELECT * FROM thuocsi_vn WHERE masp='$masp'";
            $result = $db->getList($query);
            return $result;
        }


       
        function search_xemthem($value='option1',$id_product_xemthem,$st=0,$limited=0){
            $db =  new connect();
            if($value=='option1'){
            $query="SELECT *,
        CASE
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
            WHEN giamoi is not null and giamoi !='' and cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
            ELSE 0
            END AS gialech   
        FROM thuocsi_vn where unaccent(masp)= unaccent('".$id_product_xemthem."')
        ORDER BY COALESCE(masp, '') desc, gialech desc ";
         if($st!=0){
            $query=$query." limit ".$limited." offset "."((".$st."-1)*".$limited.")";
         }
             $result = $db->getList($query);
            return $result;
        }else{
            $query="SELECT *   
        FROM thuocsi_vn where unaccent(masp)= unaccent('".$id_product_xemthem."')
        ORDER BY COALESCE(masp, '') desc, ngaymoi desc ";
         if($st!=0){
            $query=$query." limit ".$limited." offset "."((".$st."-1)*".$limited.")";
         }
             $result = $db->getList($query);
            return $result;
        }
    }
        function count_search_xemthem($thu){
            $db = new connect();
            $dem = "select count(*) as count from  thuocsi_vn where unaccent(masp) ~* replace(unaccent('$thu'), ' ', '.*') 
            ";
            $result = $db->exec($dem);
            return $result;
        }
        function search_id($email){
            $db = new connect();
            $dem = "select * from tbl_admin where email='".$email."'";
            $result = $db->exec($dem);
            return $result;
        }
        function search_capnhat_xemthem($name,$nguon){
            $db = new connect();
            $dem = "select * from thuocsi_vn where (unaccent(masp) ~* replace(unaccent('$name'), ' ', '.*')) and nguon='".$nguon."'";
            $result = $db->exec($dem);
            return $result;
        }
         
        //test phan trang
        
        
        function search_capnhat($name,$nguon){
            $db = new connect();
            $dem = "select * from thuocsi_vn where (unaccent(title) ~* replace(unaccent('$name'), ' ', '.*') 
            or unaccent(nguon) ~* replace(unaccent('$name'), ' ', '.*') 
            or unaccent(cast((to_char(ngaymoi, 'dd-mm-YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*') 
            or unaccent(cast((to_char(ngaymoi, 'dd/mm/YYYY')) as text)) ~* replace(unaccent('$name'), ' ', '.*')) and nguon='".$nguon."'";
            $result = $db->exec($dem);
            return $result;
        }
        
        function count_search($thu){
            $db = new connect();
            $dem = "select count(*) as count from  thuocsi_vn where unaccent(title) ~* replace(unaccent('$thu'), ' ', '.*') 
            or unaccent(nguon) ~* replace(unaccent('$thu'), ' ', '.*') 
            or unaccent(cast((to_char(ngaymoi, 'dd-mm-YYYY')) as text)) ~* replace(unaccent('$thu'), ' ', '.*') 
            or unaccent(cast((to_char(ngaymoi, 'dd/mm/YYYY')) as text)) ~* replace(unaccent('$thu'), ' ', '.*')
             ";
            $result = $db->exec($dem);
            return $result;
        }

        // function testcol($thu){
        //     $db = new connect();
        //     $dem = "select count(*) as sothu from  thuocsi_vn where photo = '".$thu."' and giacu is not null";
        //     $result = $db->exec($dem);
        //     return $result;
        // }

        function tongsanpham($theloaiban='tatcasanpham'){
            $db=new connect();
            if($theloaiban=='tatcasanpham'){
                $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn ";
            }elseif($theloaiban=='bansi'){
                $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn where  nguon='thuocsi.vn' or nguon='chosithuoc.com' or nguon='thuocsi.pharex.vn' or nguon='pharmacity.vn'";

            }elseif($theloaiban=='banle'){
                $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn where   nguon='ankhang.com' or nguon='longchau.vn'";

            }
            
            $result = $db->getList($query);
            return $result;

        }
        // function buy_min(){
        //     $db =new connect();
        //     $query = "SELECT title, photo, giamoi,sales_in_last_24_hours
        //     FROM thuocsi_vn
        //     WHERE CAST(sales_in_last_24_hours AS real) = (SELECT MIN(CAST(sales_in_last_24_hours AS real))
        //                     FROM thuocsi_vn)";
        //     $result = $db->getList($query);
        //     return $result;
        // }
        // function phantramitnhat(){
        //     $db = new connect();
        //     $query = "SELECT SUM(CAST(sales_in_last_24_hours AS real)) as phantramitnhat from thuocsi_vn";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        
    }
?>
