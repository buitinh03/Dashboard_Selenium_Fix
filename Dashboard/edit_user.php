<?php

    include 'inc/header.php'; 
    include 'classes/customer.php';
?>
<?php
    $customer = new Customer();
    if(!isset($_GET['customerid']) && $_GET['customerid'] == NULL){
        echo "<script>window.location='views_user.php'</script>";
    }else{
        $id = $_GET['customerid'];
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $customername = $_POST['customername'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $hash = $_POST['password'];
        $password = hash('sha256', $hash);
        $type = $_POST['type'];

        $update = $customer->update_customer($customername, $email, $username, $password, $type, $hash, $id);
        
    }

?>

<?php  include('inc/deshboad.php'); ?>

                    <!END OF INCOME>
                </div>
                <div class="recent-order">
                    <h2 style="margin-left:10rem; font-size:1.5rem">Cập nhật người dùng</h2>
                    <?php
                        if(isset($update)){
                            echo $update;
                        }
                    ?>
                   
                    <div class="recent-order-forms">
                    <style>
                        .recent-order-forms {
                            background-color: #fff;
                            font-size: 15px;
                            margin: 10px 10rem;
                            border-radius: 10px;
                        }

                        .recent-order-form {
                            margin-left: 10px;
                            font-family: poppins,sans-serif;
                        }

                        form {
                            margin: 5px 0;
                        }

                        main .recent-order .submit {
                            text-align: center;
                        }
                    

                        .recent-order-forms .submit {
                            font-size: 20px;
                            margin-left: 45%;
                            margin-top: 25px;
                            width: 150px;
                            height: 30px;
                            margin-bottom: 10px;
                            background-color: #6666FF;
                            font-family: poppins,sans-serif;
                            border-radius: 3px;
                            transition: 1s all ease;
                            cursor: pointer;
                            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            font-weight: 900;
                        }

                        .recent-order-forms .submit:hover {
                            background-color: #6600FF;
                        }

                       

                        .error {
                            color: #FF0000;
                        }

                        .success {
                            color: #0000FF;
                        }

                        .recent-order-form {
                            display: flex;
                            justify-content: space-between;
                          
                        }

                        .recent-order-form input {
                            border: 1px solid #333;
                            margin-right: 10rem;
                            margin-top: 15px;
                            padding:5px 3px;
                            width: 480px;
                            font-size: 18px;
                        }

                        .recent-order-form label {
                            margin-top: 20px;
                            margin-left: 10rem;
                            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            font-weight: 900;
                        }
                        .recent-order-form select {
                            border: 1px solid #333;
                            margin-right: 10rem;
                            margin-top: 15px;
                            padding:5px 3px;
                            width: 480px;
                            font-size: 18px;
                        }

                        .recent-order-form textarea {
                            margin-right: 200px;
                            margin-top: 10px;
                            border: 1px solid #333;
                            width: 400px;
                            padding: 4px;
                            font-size: 20px;
                        }

                        .recent-order-form .image {
                            border: none;
                        }
                        
                        .div {
                            display: flex;
                        }
                        
                        .div .back{
                         
                            margin-bottom: .9em;
                            padding-bottom: .5em;
                            font-size: 1.3em;
                            text-align: left;
                            transition: .5s all ease;
                        }

                        .div a:hover {
                            color: #FF0000;
                        }
                      
                        main .recent-order a {
                            text-align: left;
                            margin-left: 1em;
                        }

                        main .recent-order i {
                            display: block;
                            margin-top: 1em;
                        }
                        
                    </style>
                     <?php
                    $show_customerbyid = $customer->getcustomerbyid($id);
                    if($show_customerbyid){
                        while($result = $show_customerbyid->fetch()){

                     ?>
                        <form action="" method="post" enctype="multipart/form-data">
                           
                            <div class="recent-order-form">
                                <label for="productid">Họ và tên:</label>
                                <input type="text" name="customername" id="productid" value="<?php echo $result['fullname'] ?>" placeholder="Họ và tên" class="productid">
                            </div>
                            <div class="recent-order-form">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" value="<?php echo $result['email'] ?>" placeholder="Email" class="productname">
                            </div>
                            <div class="recent-order-form">
                                <label for="username">Tên đăng nhập:</label>
                                <input type="text" name="username" id="username" value="<?php echo $result['username'] ?>" placeholder="Tên đăng nhập" class="productname">
                            </div>
                            <div class="recent-order-form">
                                <label for="password">Mật khẩu:</label>
                                <input type="text" name="password" id="password" value="<?php echo trim($result['password']); ?>" placeholder="Mật khẩu" class="productname">
                            </div>
             
                            <div class="recent-order-form">
                                <label>Chức vụ:</label>
                                <select id="select" name="type" class="selecttype">
                                   <?php 
                                    if($result['type'] == 1)
                                     {
                                        echo 'selected';
                                        ?>
                                    <option selected value="1">Nhân viên</option>
                                    <option value="0">Admin</option>
                                  
                                   
                                      
                                    <?php
                                     }elseif($result['type'] == 0){
                                        echo 'selected';
                                     ?>
                                     <option  value="1">Nhân viên</option>
                                    <option selected value="0">Admin</option>
                                    <?php
                                     }
                                     ?>
                                </select>
                            </div>
                          
                            <input type="submit" value="Cập nhật" name="submit" class="submit">
                            
                        </form>
                        <?php
                                }
                            }
                         ?>
                         <div class="div">
                               <a href="views_user.php" class="back" style="margin: 1rem 0 1rem 10rem">< Quay lại</a>
                        </div>
                       
                    </div>
                    <div class="kjasj"></div>
                    <style>
                        .kjasj{
                            height: 2rem;
                        }
                    </style>
                    <a href="#"></a>
                </div>
            </main>
            <! END OF MAIN>
         <?php include 'inc/footer.php'; ?>
