
function showSuccessToast() {
    toast({
      title: "Thành công!",
      message: "Vui lòng đợi trong giây lát !",
      type: "success",
      duration:3000
    });
    //Đợi 5 giây sẽ thực thi lệnh bên trong hàm này
    setTimeout(function () {
        window.location='new_password.php'
      }, 3000);
  }
  
  function showErrorToast() {
    toast({
      title: "Thất bại!",
      message: "Email không chính xác. Vui lòng nhập lại",
      type: "error",
      duration: 3000,
    });
  }
  
  // Toast function
  function toast({ title = "", message = "", type = "info", duration = 3000 }) {
  const main = document.getElementById("toast");
  if (main) {
    const toast = document.createElement("div");
  
    // Auto remove toast
    const autoRemoveId = setTimeout(function () {
      main.removeChild(toast);
    }, duration + 1000);
  
    // Remove toast when clicked
    toast.onclick = function (e) {
      if (e.target.closest(".toast__close")) {
        main.removeChild(toast);
        clearTimeout(autoRemoveId);
      }
    };
  
    const icons = {
      success: "fas fa-check-circle",
      info: "fas fa-info-circle",
      warning: "fas fa-exclamation-circle",
      error: "fas fa-exclamation-circle"
    };
    const icon = icons[type];
    const delay = (duration / 1000).toFixed(2);
  
    toast.classList.add("toast", `toast--${type}`);
    toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;
  
    toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast__body">
                        <h3 class="toast__title">${title}</h3>
                        <p class="toast__msg">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="fas fa-times"></i>
                    </div>
                `;
    main.appendChild(toast);
  }
  }
  const verification_email_error = document.querySelector(".btn-danger-click");
  verification_email_error.click();
  // const verification_email = document.querySelector(".btn-success-click");
  // verification_email.click();

  
