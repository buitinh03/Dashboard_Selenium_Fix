<?php
    include 'classes/customer.php';
    include_once 'format/format.php';
?>
<?php include_once('lib/session.php');
Session::init();
?>

<?php
    $customer = new Customer();
    $fm = new Format();
    $email =   Session::get('userEmail');
    $id =   Session::get('userId');

    // $id = $_SESSION['email'];
  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $hash = $_POST['password'];
        $password = hash('sha256', $hash);
        $new_pass = $customer->new_pass($password, $id);
        
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/quenmatkhau.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="icon" type="image/x-icon" href="images/favicon.png"/>
    <title>HB PHARMA</title>
</head>
<body>
    <div class="container">
     <div id="toast"></div>
     <div>
        <!-- <div onclick="showSuccessToast();" class="btn btn--success">Show success toast</div>
        <div onclick="showErrorToast();" class="btn btn--danger">Show error toast</div> -->
        <?php if(isset($new_pass)){
                        echo $new_pass;
            }?>
    </div>

        <div class="container-content">
            <div class="container-content-flex">
            <h1>Mật Khẩu Mới</h1>
            <a href="login.php">X Đóng</a>
            </div>
            <p>Mật khẩu nên dài ít nhất 12 ký tự. Không nên đặt mật khẩu quá dễ đoán.</p>
            <hr width="50%" color="black">
       
            <form action="" method="post">
            
                <div class="content-form">
                    <label for="hiddenpass">Mật khẩu mới:</label><br>
                    <input type="password" name="password" id="hiddenpass" placeholder="Nhập mật khẩu mới tại đây" required>
                    <div class="remember">
                       <input type="checkbox" name="" id="hien" onclick="myfuction()" class="input">
                       <label for="hien">Hiện mật khẩu</label>
                   </div>
                </div>
                <button type="submit" name="submit">Xác nhận</button><br>
            </form>
         
        </div>
    </div>
    <script>
        var a = true;
        function myfuction(){
            if(a == true){
                document.getElementById('hiddenpass').type = "text"
                a = false;
            }else{
                document.getElementById('hiddenpass').type = "password"
                a = true;
            }
        
        }
    </script>
    <script src="js/messege.js"></script>
</body>
</html>