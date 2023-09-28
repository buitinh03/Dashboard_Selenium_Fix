import os
from dotenv import load_dotenv
import time
import threading

load_dotenv()
backend_folder = os.getenv("BACKEND_FOLDER_MCH")
operation=os.getenv("OPERATION")

def run_script(script_path):
    while True:
        os.system(os.getenv("OPERATION")+' '+f'{script_path}')
        time.sleep(1)
def run_chosithuoc():
    while True:
        script_file = "chosithuoc_CH.py"
        script_path = os.path.join(backend_folder, script_file)
        run_script(script_path)
def my_task():
    # Danh sách các tên file script
#     script_files = [
#         "ankhang_CH.py",
#         "longchau_CH.py",
#         "pharmacity_CH.py",
#         "chosithuoc_CH.py",
#         "medigoapp_CH.py",
#         "pharex_CH.py",
#         "thuocsi_CH.py",
# ]

#     for script_file in script_files:
#         script_path = os.path.join(backend_folder, script_file)
#         thread = threading.Thread(target=run_script, args=(script_path,))
#         thread.start()
    while True:
        script_files1 = [
            "longchau_CH.py",
            "medigoapp_CH.py",
            "thuocsi_CH.py",
        ]
        script_files2 = [
            "pharex_CH.py",
            "ankhang_CH.py",
            "pharmacity_CH.py",
        ]

        # Tạo luồng cho script "chosithuoc.py"
        thread_chosithuoc = threading.Thread(target=run_chosithuoc)
        thread_chosithuoc.start()

        current_script_group = script_files1
        is_script1_group = True

        threads = []
        while script_files1 or script_files2:
            current_group = script_files1 if is_script1_group else script_files2

            for i in range(3):
                if current_group:
                    script_file = current_group.pop(0)
                    script_path = os.path.join(backend_folder, script_file)
                    thread = threading.Thread(target=run_script, args=(script_path,))
                    threads.append(thread)
                    thread.start()

            for thread in threads:
                thread.join()

            is_script1_group = not is_script1_group
            time.sleep(5)
if __name__ == "__main__":
    my_task()
# my_task()

# while True:
#     pass
