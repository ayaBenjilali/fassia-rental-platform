from PIL import Image
import os

def remove_background(input_path, output_path):
    img = Image.open(input_path)
    img = img.convert("RGBA")
    
    datas = img.getdata()
    
    newData = []
    for item in datas:
        # If pixel is white or very close to white, make it transparent
        if item[0] > 230 and item[1] > 230 and item[2] > 230:
            newData.append((255, 255, 255, 0))
        else:
            newData.append(item)
            
    img.putdata(newData)
    img.save(output_path, "PNG")

# Use the last generated logo or any gold logo on white
input_img = r"C:\Users\DELL\.gemini\antigravity\brain\73d48a58-9d0c-4125-bb6a-90bc81dfb9dd\fassia_final_gold_logo_1776425812919.png"
output_img = r"c:\Users\DELL\pfa-rentals\public\images\logo_text.png"

if os.path.exists(input_img):
    remove_background(input_img, output_img)
    print("Background removed successfully!")
else:
    print(f"Source file not found: {input_img}")
