import os
from dotenv import load_dotenv
import time
import threading

load_dotenv()
backend_folder = os.getenv("BACKEND_FOLDER_AUTO")
operation=os.getenv("OPERATION")

def run_script(script_path):
    os.system(os.getenv("OPERATION")+' '+f'{script_path}')
    time.sleep(1)

def my_task():
    # Danh sách các tên file script
    script_files = [
        "ankhang.py",
        "longchau.py",
        "pharmacity.py",
        "chosithuoc.py",
        "medigo.py",
        "pharex.py",
        "thuocsi.py",
]

    for script_file in script_files:
        script_path = os.path.join(backend_folder, script_file)
        thread = threading.Thread(target=run_script, args=(script_path,))
        thread.start()


my_task()

while True:
    pass
