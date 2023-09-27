import os
from dotenv import load_dotenv
import time
import threading

load_dotenv()
backend_folder = os.getenv("BACKEND_FOLDER")
operation=os.getenv("OPERATION")

def run_script(script_path):
    while True:
        os.system(os.getenv("OPERATION")+' '+f'{script_path}')
        time.sleep(1)

def my_task():
    # Danh sách các tên file script
    script_files = [
        "ankhang_CH.py",
        "longchau_CH.py",
        "pharmacity_CH.py",
        "chosithuoc_CH.py",
        "medigoapp_CH.py",
        "pharex_CH.py",
        "thuocsi_CH.py",
]

    for script_file in script_files:
        script_path = os.path.join(backend_folder, script_file)
        thread = threading.Thread(target=run_script, args=(script_path,))
        thread.start()


my_task()

while True:
    pass
