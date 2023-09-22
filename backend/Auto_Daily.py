import os
from dotenv import load_dotenv
import time
import threading

load_dotenv()
backend_folder = os.getenv("BACKEND_FOLDER")
operation = os.getenv("OPERATION")

def run_script(script_path):
    os.system(os.getenv("OPERATION") + ' ' + f'{script_path}')
    time.sleep(1)

def my_task():
    while True:
        script_files1 = [
            "ankhang.py",
            "medigo.py",
            "thuocsi.py",
            "chosithuoc.py",
        ]
        script_files2 = [
            "pharex.py",
            "longchau.py",
            "pharmacity.py",
            "chosithuoc.py",
        ]

        current_script_group = script_files1  # Bắt đầu với script1
        is_script1_group = True  # Biến để xác định nhóm script hiện tại

        threads = []
        while script_files1 or script_files2:
            # Lấy danh sách script của nhóm hiện tại
            current_group = script_files1 if is_script1_group else script_files2

            # Chạy tệp trong nhóm hiện tại
            for i in range(4):
                if current_group:
                    script_file = current_group.pop(0)
                    script_path = os.path.join(backend_folder, script_file)
                    thread = threading.Thread(target=run_script, args=(script_path,))
                    threads.append(thread)
                    thread.start()

            # Đợi tất cả các luồng hoàn thành trước khi tiếp tục
            for thread in threads:
                thread.join()

            # Chuyển đổi giữa hai nhóm
            is_script1_group = not is_script1_group

            # Đợi 5 giây trước khi chuyển đổi và chạy lại
            time.sleep(5)

if __name__ == "__main__":
    my_task()
