import schedule
import time
import subprocess
import os
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv()

def my_task():
    # Construct the path to the Python script using environment variables
    backend_folder = os.getenv("BACKEND_FOLDER")
    python_script_path = os.path.join(backend_folder, "thuocsi.py")
    
    subprocess.run(["python", python_script_path])

# Schedule the task to run daily at 10 AM
<<<<<<< HEAD
schedule.every().day.at("15:59").do(my_task)
=======
schedule.every().day.at("15:23").do(my_task)
>>>>>>> origin/master

while True:
    schedule.run_pending()
    time.sleep(1)
