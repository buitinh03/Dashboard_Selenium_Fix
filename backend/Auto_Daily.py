import schedule
import time
import subprocess
import os
from dotenv import load_dotenv
import threading

load_dotenv()
is_task_running = False
is_first_run = True  # Biến để kiểm tra lần chạy đầu tiên

def run_script(script_path):
    # Thực hiện logic của công việc ở đây
    subprocess.run(["python", script_path])

def run_scripts():
    backend_folder = os.getenv("BACKEND_FOLDER")

    global is_task_running
    global is_first_run

    # Nếu đây là lần chạy đầu tiên, hoặc không có công việc nào đang chạy
    if is_first_run or not is_task_running:
        is_task_running = True
        is_first_run = False  # Đánh dấu rằng đã chạy lần đầu tiên

        # Danh sách các tên file script
        script_files = [
            "ankhang.py",
            "longchau.py",
            "run_chosithuoc.py",
            "medigo.py",
            "pharex.py",
            "pharmacity.py",
            "thuocsi.py"
        ]

        # Tạo và khởi động một luồng cho mỗi script
        threads = []
        for script_file in script_files:
            script_path = os.path.join(backend_folder, script_file)
            thread = threading.Thread(target=run_script, args=(script_path,))
            threads.append(thread)
            thread.start()

        # Chờ cho tất cả các luồng hoàn thành
        for thread in threads:
            thread.join()

        is_task_running = False

def my_task():
    thread = threading.Thread(target=run_scripts)
    thread.start()

# Gọi hàm run_scripts ngay lần đầu tiên
run_scripts()

def schedule_task():
    # Đảm bảo nhiệm vụ được chạy vào lần chạy đầu tiên
    if is_first_run:
        my_task()


# Schedule công việc chạy vào lúc 10:10 AM vào ngày 1 hàng tháng
schedule.every(3600 * 24 * 3).seconds.do(my_task)


while True:
    schedule.run_pending()
    time.sleep(1)
