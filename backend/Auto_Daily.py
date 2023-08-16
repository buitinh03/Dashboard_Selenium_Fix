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
    
    # selenium_script_path = os.path.join(backend_folder, "thuocsi_autoDaily.py")
    scrapy_script_path = os.path.join(backend_folder, "run_scrapy.py")
    # selenium_script_path_click = os.path.join(backend_folder, "thuocsi_click.py")
    
    
    # subprocess.run(["python", selenium_script_path])
    subprocess.run(["python", scrapy_script_path])
    # subprocess.run(["python", selenium_script_path_click])

def my_task():
    thread = threading.Thread(target=run_scripts)
    thread.start()

# Schedule the task to run daily at 10 AM
schedule.every().day.at("15:43").do(my_task)

while True:
    schedule.run_pending()
    time.sleep(1)
