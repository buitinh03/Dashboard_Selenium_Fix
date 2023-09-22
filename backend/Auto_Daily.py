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

def run_chosithuoc():
    while True:
        script_file = "chosithuoc.py"
        script_path = os.path.join(backend_folder, script_file)
        run_script(script_path)

def my_task():
    while True:
        script_files1 = [
            "longchau.py",
            "medigo.py",
            "thuocsi.py",
        ]
        script_files2 = [
            "pharex.py",
            "ankhang.py",
            "pharmacity.py",
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