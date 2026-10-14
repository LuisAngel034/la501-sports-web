import os
import datetime

paths = [
    "C:/Users/HP_User/Documents/501/Doctor/ml_proposals_desglosado.ipynb",
    "C:/Users/HP_User/Documents/Yose/Doctor/ml_proposals_desglosado.ipynb"
]

for p in paths:
    if os.path.exists(p):
        stat = os.stat(p)
        mtime = datetime.datetime.fromtimestamp(stat.st_mtime)
        print(f"Path: {p}")
        print(f"  Size: {stat.st_size} bytes")
        print(f"  Modified: {mtime}")
    else:
        print(f"Path: {p} (Does not exist)")
