#!/usr/bin/python
#-------------------------------------------------------------------------------
# Name:        displaygui
# Purpose:     displays a simple gui which shows what each of the lights would be at at the current point
#
# Author:      Amelia Cordwell
#
# Created:     20/10/2015
# Copyright:   (c) Amelia Cordwell 2015
# Licence:     Creative Commons
#-------------------------------------------------------------------------------

import pickle
import time
from Tkinter import *

root = Tk()
root.wm_title("ELiDMX Lighting Display")

pickapickle = pickle.load(open( "test.p", "rb" ))
values = pickapickle[0]
prevvalues = values

lights = ["Full Big Left","Full Big Center","Full Big Right","Zoom Spot","Downstage Left","Downstage Right","Center Stage Right","Center Stage Left","Blue (small)","Blue (big)","Red","Work","Left (on side)","Right (on side)","Floor Far Left","Floor Left","Floor Center","Floor Right","Floor Far Right","Upstage Far Left","Upstage Left","Upstage Center","Upstage Right","Upstage Far Right"]

def createColor(number):
    hexcode = "%x" % number
    color = "#" + hexcode + hexcode + "00"
    return color

d = 0

def setText():
    global values

    try:
        #on color convert int to hex then use in string
        pickapickle = pickle.load(open( "test.p", "rb" ))
        prevvalues = values
        values = pickapickle[0]
        r = 1
        for i in range(len(lights)):
            # ONLY UPDATE ON CHANGE
            if values[i] != prevvalues[i]:
                Label(bg='#ffff00', text=str(int(values[i] + 0.5)), relief=SUNKEN,width=30).grid(row=r,column=1)
            r = r + 1
    except:
        print("Error in reading from pickle")
    
    root.after(100, setText)

Label(text="ELiDMX Lighting Display", relief=FLAT,width=30,font=("Purisa", 14)).grid(row=0,column=0,columnspan=2)
Label(text="ELiDMX Lighting Display", relief=FLAT,width=30,font=("Purisa", 14)).grid(row=0,column=0,columnspan=2)

r = 1
for i in range(len(lights)):
    Label(text=lights[i], relief=RIDGE,width=30).grid(row=r,column=0)
    #on color convert int to hex then use in string
    # "%x" % int (converts to hexadecimal)
    Label(bg=createColor(255), text=str(int(values[i]+0.5)), relief=SUNKEN,width=30).grid(row=r,column=1)
    r = r + 1

root.after(100, setText)
root.mainloop()
