import schedule
import time
import subprocess
import os
from dotenv import load_dotenv
import threading

load_dotenv()


def run_scripts():
    backend_folder = os.getenv("BACKEND_FOLDER")

    ankhang = os.path.join(backend_folder, "ankhang.py")
    thuocsi = os.path.join(backend_folder, "thuocsi.py")
    chosithuoc = os.path.join(backend_folder, "run_chosithuoc.py")
    

    subprocess.run(["python", ankhang])
    subprocess.run(["python", thuocsi])
    subprocess.run(["python", chosithuoc])
    


def my_task():
    thread = threading.Thread(target=run_scripts)
    thread.start()


# Schedule the task to run daily at 10 AM
schedule.every().day.at("11:00").do(my_task)

while True:
    schedule.run_pending()
    time.sleep(1)