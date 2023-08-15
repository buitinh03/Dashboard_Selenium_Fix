// Hiện ẩn mật khẩu Phần Đăng Nhập
$(document).ready(function(){
    $('#eye').click(function(){

        $(this).toggleClass('open');
          // Khi nhấn vào icon hiện mật khẩu thì Thay đổi icon kia lên
        $(this).children('i').toggleClass('fa-eye-slash fa-eye');
        
        // Nếu bản thân nó tồn tại call open thì co type=text để hiện mk
        if($(this).hasClass('open')){
            document.getElementById('hiddenpassword').type = 'text';
        }else{
            document.getElementById('hiddenpassword').type = 'password';
        }
    })
})

// Hiện ẩn mật khẩu Phần Đăng Ký
$(document).ready(function(){
    $('#eyes').click(function(){

        $(this).toggleClass('open');
          // Khi nhấn vào icon hiện mật khẩu thì Thay đổi icon kia lên
        $(this).children('i').toggleClass('fa-eye-slash fa-eye');
        
        // Nếu bản thân nó tồn tại call open thì co type=text để hiện mk
        if($(this).hasClass('open')){
            document.getElementById('hiiddenpassword').type = 'text';
        }else{
            document.getElementById('hiiddenpassword').type = 'password';
        }
    })
})