<?php include_once('lib/session.php'); ?>
<!--  -->
<?php include_once('connect.php'); ?>
<?php include_once('format/format.php'); ?>
<?php

 class Customer{
    // private $db;
    // private $fm;
    public function __construct()
    {
    }

    function delete_customer($id){
        $db = new connect();
        $query = "DELETE FROM tbl_admin WHERE id='$id'";
        $result = $db->exec($query);
        if($result){
            $alert = "<span class='success' style='color: #0000FF;'>Xoá thành công !</span>";
            return $alert;
   
        }else {
        
            $msg = "<span class='error' style='color:  #FF0000;'>Xoá thất bại !</span>";
            return $msg;
        }
    }

    function show_customer(){
        $db = new connect();
        $query = "SELECT * FROM tbl_admin";
        $result = $db->getList($query);
        return $result;
    }

    function getcustomerbyid($id){
        $db = new connect();
        $query = "SELECT * FROM tbl_admin Where id='$id'";
        $result = $db->getList($query);
        return $result;
    }

    function update_customer($customername, $email, $username, $password, $type,$id){
        $db = new connect();
        $query = "UPDATE tbl_admin SET fullname='$customername', email='$email', username='$username', password='$password',type='$type' WHERE id='$id'";
        $result = $db->exec($query);
        if($result){
            $alert = "<span class='success' style='color: #0000FF;'>Cập nhật thành công !</span>";
            return $alert;
   
        }else {
        
            $msg = "<span class='error' style='color:  #FF0000;'>Cập nhật thất bại !</span>";
            return $msg;
        }
    }

 }
?>
