<?php
    require 'vendor/autoload.php'; // Đường dẫn tới autoload.php của Composer
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    class connect{
        var $db=null;
        public function __construct(){
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $name = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            $dns = "pgsql:host=$host;port=$port;dbname=$name;user=$user;password=$pass";
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

        function getListproduct($start=1,$limit=0){
            $db=new connect();
            $select="SELECT *,
        CASE
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
            ELSE 0
            END AS gialech   
        FROM thuocsi_vn ORDER BY gialech desc ";
        if($limit!=0){
            $select=$select." limit ".$limit." offset "."((".$start."-1)*".$limit.")";
        }
            $result=$db->getList($select);
            return $result;
        }
        
        function analysischart(){
            $db=new connect();
            $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn";
            $result = $db->getList($query);
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


        // function buy_the_most(){
        //     $db =  new connect();
        //     $query = "SELECT title, sales_in_last_24_hours, photo, giamoi FROM thuocsi_vn ORDER BY sales_in_last_24_hours DESC LIMIT 1;";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function buy_at_Last(){
        //     $db =  new connect();
        //     $query = "SELECT MIN(sales_in_last_24_hours) AS buy_at_last FROM thuocsi_vn";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function buy_the_two(){
        //     $db = new connect();
        //     $query = "SELECT title,sales_in_last_24_hours,photo,giamoi FROM  thuocsi_vn ORDER BY sales_in_last_24_hours DESC LIMIT 1 OFFSET 1";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function buy_the_three(){
        //     $db = new connect();
        //     $query = "SELECT title,sales_in_last_24_hours,photo,giamoi FROM  thuocsi_vn ORDER BY sales_in_last_24_hours DESC LIMIT 1 OFFSET 2";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function phantramnhieunhat(){
        //     $db = new connect();
        //     $query = "SELECT SUM(CAST(sales_in_last_24_hours AS real)) as phantramnhieunhat from thuocsi_vn";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function phantramnhieunhi(){
        //     $db = new connect();
        //     $query = "SELECT SUM(CAST(sales_in_last_24_hours AS real)) as phantramnhieunhi from thuocsi_vn";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        // function phantramnhieuba(){
        //     $db = new connect();
        //     $query = "SELECT SUM(CAST(sales_in_last_24_hours AS real)) as phantramnhieuba from thuocsi_vn";
        //     $result = $db->getList($query);
        //     return $result;
        // }

        //search
        function search($name){
            $db =  new connect();
            $query="SELECT *,
        CASE
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 and (CAST(giamoi AS real) > CAST(giacu AS real)) THEN (CAST(giamoi AS real) / CAST(giacu AS real) )- 1
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 and CAST(giamoi AS real) < CAST(giacu AS real) THEN 1- (CAST(giamoi AS real) / CAST(giacu AS real) )
            WHEN cast(giamoi as real)!=0 and cast(giacu as real)!=0 THEN CAST(giamoi AS real) / CAST(giacu AS real)-1
            ELSE 0
            END AS gialech   
        FROM thuocsi_vn where LOWER(title) like LOWER('%$name%') or LOWER(nguon) like LOWER('%$name%') or LOWER(cast((to_char(ngaymoi, 'dd-mm-YYYY')) as text) ) like LOWER('%$name%') or LOWER(cast((to_char(ngaymoi, 'dd/mm/YYYY')) as text) ) like LOWER('%$name%') ORDER BY gialech desc ";
             $result = $db->getList($query);
            return $result;
        }
        
        function testcol($thu){
            $db = new connect();
            $dem = "select count(*) as sothu from  thuocsi_vn where ".$thu." is not null";
            $result = $db->exec($dem);
            return $result;
        }

        function tongsanpham(){
            $db=new connect();
            $query = "SELECT COUNT(giamoi) AS quantity FROM thuocsi_vn";
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