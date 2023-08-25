<?php include_once('lib/session.php'); ?>
<!--  -->
<?php include_once('../connect.php'); ?>
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

    
    function user_confirmation($email){
        $db = new connect();
        if($email == ""){
            $msg = "<span class='error' style='color:  #FF0000; margin-right: 17rem;'>Không được để trống !</span>";
            return $msg;
        }
        else{
            $checks_email = "SELECT COUNT(*) AS count FROM tbl_admin WHERE email='$email' LIMIT 1";
            $result_email = $db->getList($checks_email);
            $count = 0;
            while($rsc=$result_email->fetch()){
                $count = $rsc['count'];
            }
    
            $query = "SELECT * FROM tbl_admin WHERE email='$email' LIMIT 1";
            $result = $db->getList($query);
            if($count == 1){
                $values = $result->fetch(PDO::FETCH_ASSOC);
                // Session::set('adminlogin', true);
                Session::set('userEmail', $values['email']);
                Session::set('userId', $values['id']);
              
                echo "<div id='toast'></div><script>window.location='new_password.php'</script>";
                //  echo '<div onclick="showSuccessToast();" class="btn--success btn-success-click"></div>';
            }else {
                // echo "<script>alert('Email không chính xác')</script>";
                echo '<div id="toast"></div><div onclick="showErrorToast();" class="btn--danger btn-danger-click"></div>';
            }
        }
    }

    function new_pass($password, $id){
        $db = new connect();
        if($password == ''){
            $msg = "<span class='error' style='color:  #FF0000;'>Không được để trống !</span>";
            return $msg;
        }
        else{
            $query = "UPDATE tbl_admin SET password='$password' WHERE id='$id'";
            $result = $db->exec($query);
            if($result){
                // $alert = "<span class='success' style='color: #0000FF; margin-left: 2rem;'>Tạo mật khẩu thành công !</span>";
                // return $alert;
                echo '<div onclick="showSuccessToast();" class="btn btn--success"></div>';
               
            }else {
            
                // $msg = "<span class='error' style='color:  #FF0000;'>Tạo mật khẩu mới thất bại !</span>";
                // return $msg;
                echo '<div onclick="showErrorToast();" class="btn btn--danger"></div>';
            }
        }
    }

 }
?>
