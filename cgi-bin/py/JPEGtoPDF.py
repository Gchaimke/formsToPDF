from fpdf import FPDF
from PIL import Image
import glob
import os


# set here
image_directory = os.path.dirname(os.path.abspath(__file__))
extensions = ('*.jpg','*.png','*.gif')
# set 0 if you want to fit pdf to image
# unit : pt
margin = 0

imagelist=[]
for ext in extensions:
	imagelist.extend(glob.glob(os.path.join(image_directory,ext)))

pdfWH = Image.open(imagelist[0])
pwidth,pheight = pdfWH.size
pdf = FPDF(unit="pt", format=[pwidth + 2*margin, pheight + 2*margin])
for image in imagelist:
	cover = Image.open(image)
	width, height = cover.size
	pdf.add_page()
	pdf.image(image,margin,margin,width + 2*margin, height + 2*margin)

pdf.output("yourfile2.pdf", "F")
print("File printed")