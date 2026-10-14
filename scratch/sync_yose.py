import shutil
import os

src_dir = "C:/Users/HP_User/Documents/501/Doctor"
dest_dir = "C:/Users/HP_User/Documents/Yose/Doctor"

files_to_copy = [
    "customer_rfm.csv",
    "sales_history.csv",
    "transactional_dataset.csv",
    "ml_proposals_desglosado.ipynb",
    "Doctor_Proyecto.zip"
]

print("Iniciando sincronización hacia Yose/Doctor...")
for f in files_to_copy:
    src_path = os.path.join(src_dir, f)
    dest_path = os.path.join(dest_dir, f)
    if os.path.exists(src_path):
        shutil.copy2(src_path, dest_path)
        print(f"Sincronizado: {f}")
    else:
        print(f"Error: No existe {src_path}")

print("Sincronización completa.")
