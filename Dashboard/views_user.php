<?php
    include 'inc/header.php'; 
    include 'classes/customer.php';
    include_once 'format/format.php';
?>
<?php
    $customer = new Customer();
    $fm = new Format();
    if(isset($_GET['customerid'])){
        $id = $_GET['customerid'];

        $deletecustomer = $customer->delete_customer($id);
    }

?>

<?php  include('inc/deshboad.php'); ?>

                    <!END OF INCOME>
                </div>
                <div class="recent-order">
                    <h2 style="margin-left:5rem">Tài Khoản Người Dùng</h2>
                    <span style="font-size: 1.3em; margin:5rem"> <?php
                    if(isset($deletecustomer)){
                        echo $deletecustomer;
                    }
                   ?></span>
                  
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Tên đăng nhập</th>
                                <th>Mật khẩu</th>
                                <th>Chức vụ</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <style>
                            .type {
                                color: #FF9999;
                                font-weight: bold;
                                text-align: left;
                            }

                            .email {
                                color: 	#FF9900;
                                font-weight: bold;
                                text-align: left;
                            }

                            .username {
                                text-align: left;
                            }

                            .password {
                                text-align: left;
                            }

                            .chucnang {
                                font-weight: 700;
                                transition: .5s all ease;
                            }

                            .chucnang .a1:hover{
                                color: #FF9900;
                            }

                            .chucnang .a2:hover {
                                color: #FF9900;
                            }
                        </style>
                        <tbody>
                            <?php

                            $showcustomer = $customer->show_customer();
                            $i = 0;
                            if($showcustomer){
                                while($result = $showcustomer->fetch()){
                                    $i++;
                            ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><a href="edit_user.php?customerid=<?php echo $result['id'] ?>"><?php echo $result['fullname'] ?></a></td>
                                <td class="email"><?php echo $result['email'] ?></td>
                                <td class="username"><?php echo $result['username'] ?></td>
                                <td class="password"><?php echo $fm->textShorten($result['password'], 30);  ?></td>
                                <td class="type"><?php if($result['type'] == 1){
                                    echo "Nhân viên";
                                }else{
                                    echo "Admin";
                                }  ?></td>
                                <td class="chucnang"><a onclick="return confirm('Bạn có chắc chắn muốn xoá không ?')" href="?customerid=<?php echo $result['id'] ?>" class="a1">Xoá</a>
                                <a href="edit_user.php?customerid=<?php echo $result['id'] ?>" class="a2">Sửa</a></td>
                            </tr>
                            <?php

                                 }
                            }
                            ?>
                      
                        </tbody>
                    </table>
                    <div class="kjasj"></div>
                    <style>
                        .kjasj{
                            height: 2rem;
                        }
                    </style>
                    <a href="#"></a>
                </div>
            </main>
            <?php include 'inc/footer.php'; ?>