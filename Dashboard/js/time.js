function CountTime(){
    var date = new Date();
    var hours = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    var rank = date.getDay() ;
    var day = date.getDate();
    var moth = date.getMonth() + 1;
    var year = date.getFullYear();

    // Cấu hình thứ mấy trong tuần
    var day_name = "";
    switch (rank) {
        case 0:
            day_name = "Chủ nhật";
            break;
        case 1:
            day_name = "Thứ hai";
            break;
        case 2:
            day_name = "Thứ ba";
            break;
        case 3:
            day_name = "Thứ tư";
            break;
        case 4:
            day_name = "Thứ năm";
            break;
        case 5:
            day_name = "Thứ sáu";
            break;
        case 6:
            day_name = "Thứ bảy";
        }
    document.getElementById('rank').innerHTML = day_name ;

    document.getElementById('dates').innerHTML = day + " / " + moth + " / " + year;

    // Cấu hình giờ phút giây có thêm số 0 ở đầu nếu các số nhỏ hơn 10
    if(hours < 10){
        hours = "0" + hours;
    }
    if(minute < 10){
        minute = "0" + minute;
    }
    if(second < 10){
        second = "0" + second;
    }
    document.getElementById('coundtime').innerHTML = hours + " : " + minute + " : " + second;
    // Cứ mỗi 1 giây sẽ nhảy số 1 lần 1000 = 1s
    if(hours==9 && minute==2 && second==1){
        window.location.href="auto.php";
    }
    setTimeout('CountTime()', 1000);
   
}

CountTime();


// Nút quay lại đầu trang trong file index
    function scrollDown() {
        window.scrollTo(0, document.body.scrollHeight);
      
        var intervals = setInterval(function() {
          if (window.scrollY === document.body.scrollHeight) {
            clearInterval(intervals);
          }
          requestAnimationFrame();
        },0);
      }
   

    function scrollUp() {
        function animate() {
            window.scrollTo(0, 0);
            if (window.scrollY === 0) {
            clearInterval(interval);
            return
            }
            requestAnimationFrame(animate);
        }
    
        var interval = setInterval(animate, 0);
        }

    

    // HIện thị 2 bút lên đầu trang và xuống cuối trang
    const element = document.querySelector(".quaylai");
    element.style.display = "none";

    window.addEventListener("scroll", function() {
    if (window.scrollY / document.body.scrollHeight >= 0.05) {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
    });



