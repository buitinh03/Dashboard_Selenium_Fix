// Hiện ẩn mật khẩu Phần Đăng Nhập
$(document).ready(function(){
    $('#eye').click(function(){

        $(this).toggleClass('open');
          // Khi nhấn vào icon hiện mật khẩu thì Thay đổi icon kia lên
        $(this).toggleClass('fa-eye-slash fa-eye');
        
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
        $(this).toggleClass('fa-eye-slash fa-eye');
        
        // Nếu bản thân nó tồn tại call open thì co type=text để hiện mk
        if($(this).hasClass('open')){
            document.getElementById('hiiddenpassword').type = 'text';
        }else{
            document.getElementById('hiiddenpassword').type = 'password';
        }
    })
})

        // Click vào Button Địa chỉ
        const adressbtn = document.querySelector('#adress-form')
        // Click vào nút đóng ở phần địa chỉ giao hàng
        const adressclose = document.querySelector('#adress-close')
        
        // const rightbtn = document.querySelector('.fa-chevron-right')
        // console.log(rightbtn)
        adressbtn.addEventListener("click", function(){
            document.querySelector('.adress-form').style.display = "flex"
        })
        
        adressclose.addEventListener("click", function(){
            document.querySelector('.adress-form').style.display = "none"
        })
