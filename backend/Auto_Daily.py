import schedule
import time
import subprocess
import os
from dotenv import load_dotenv
import threading

# Load environment variables from .env file
load_dotenv()

def run_scripts():
    backend_folder = os.getenv("BACKEND_FOLDER")
    
    selenium_script_path = os.path.join(backend_folder, "thuocsi_autoDaily.py")
    scrapy_script_path = os.path.join(backend_folder, "run_scrapy.py")
    selenium_script_path_click = os.path.join(backend_folder, "thuocsi_click.py")
    
    # Bắt đầu một luồng cho mỗi tập lệnh
    threads = []
    threads.append(threading.Thread(target=lambda: subprocess.run(["python", selenium_script_path])))
    threads.append(threading.Thread(target=lambda: subprocess.run(["python", scrapy_script_path])))
    threads.append(threading.Thread(target=lambda: subprocess.run(["python", selenium_script_path_click])))
    
    for thread in threads:
        thread.start()
    
    for thread in threads:
        thread.join()

def my_task():
    thread = threading.Thread(target=run_scripts)
    thread.start()

# Lên lịch thực hiện nhiệm vụ hàng ngày vào lúc 14:07
schedule.every().day.at("14:28").do(my_task)

while True:
    schedule.run_pending()
    time.sleep(1)
