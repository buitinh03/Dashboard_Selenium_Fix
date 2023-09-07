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

    ankhang = os.path.join(backend_folder, "ankhang.py")
    longchau = os.path.join(backend_folder, "longchau.py")
    chosithuoc = os.path.join(backend_folder, "run_chosithuoc.py")
    medigo = os.path.join(backend_folder, "medigo.py")
    pharex = os.path.join(backend_folder, "pharex.py")
    pharmacity = os.path.join(backend_folder, "pharmacity.py")
    thuocsi = os.path.join(backend_folder, "thuocsi.py")

    subprocess.run(["python", ankhang])
    subprocess.run(["python", longchau])
    subprocess.run(["python", chosithuoc])
    subprocess.run(["python", medigo])
    subprocess.run(["python", pharex])
    subprocess.run(["python", pharmacity])
    subprocess.run(["python", thuocsi])


def my_task():
    thread = threading.Thread(target=run_scripts)
    thread.start()


# Schedule the task to run daily at 10 AM
schedule.every().day.at("16:00").do(my_task)

while True:
    schedule.run_pending()
    time.sleep(1)
