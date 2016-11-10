# ELi-DMX Server Side Code
The server side code for use to control theatre lights with the ELi-DMX app.

This has been superseeded by the new version ["ELi-DMX"](http://www.github.com/cordwella/eli-dmx), which runs as a web app instead, I would recomend using that one.

This is a web API which uses the Open Lighting Architecture [OLA](https://www.openlighting.org/ola/) to send DMX messages and control theatre lights. It was designed for use with [this](https://github.com/cordwella/eli-dmx-android) android application.

Can be seen in use [here](https://www.youtube.com/watch?v=VUXlRPttL04) (I used this as my entry for the 2015 Brightsparks competition as seen [here](http://www.brightsparks.org.nz/elidmx-software/) ).

## Installation
This web app is just PHP which makes calls to python scripts, however as it uses OLA make sure that your computer is capable of running that. 

Step 1: Set up OLA, and make sure the python libraries are enabled when you install it. Currently ELi-DMX is set up to be run on universe 1 however that can be changed inside the python script senddata.py. You can then test that the lights are being controlled by using their control panel.

Step 2: Set up Webserver database etc. Currently this is only set up for MySQL as the PHP uses the MySQLi extension. This program can be run inside pretty much any directory accessable to the webserver (just copy it over). I have attached an example case for how my school is set up, however I'm pretty sure your lighting needs will be different than my schools. In terms of changing this if you are going to change the number of lights are in use you are going to also have to change some of the PHP. (I believe if you don't have all of the 24 channels in use in the lights table there may be some issues in the way that the android app adds/modifies scenes). Please remember to allow your server to execute these files and also to write to test.p (I know horrible naming), as test.p keeps track of each of the lights.

Step 3: Install android app, or develop your own UI if you feel like it.

Notes: This hasn't been tested outside of my school's lighting needs and as such you may run into errors depending on your lighting configuration. I will attempt to update this with fixes for those sorts of issues later.

## API Guide
#### Python Scripts

There are two python scripts in this project. The first is run from the terminal and sends data to the lights and the second displays what values each of the lights should be on. 

** Sending Data: senddata.py **
To send DMX data execute this program. For example:

./senddata.py 255 100 d 100 -f 5000

This example command would set the first channel on the dimmer pack to 255, the second and fourth to 100 on a 5 second fade timer, while leaving the third light  (and any other unspecified channels) to whatever it had been set to beforehand.

The lights have priority set over the last thing sent to them so for example if you ran say ‘./senddata.py 255 -f 5000’, but then two seconds in you realised that you really want to change it to 0 running ‘./senddata.py 0’ would set the light to 0 and stop the previous program.

** Viewing Current Data: gui.py **

This program will show a small gui with the current level for each of the channels. The channel names are currently just written in to the file rather than being accessed from a database so this is only really useful if you feel like showing your app off.

#### PHP

Note: All of these should be run with the same base URL which will depend on how you installed the software. For me it is http://[IP]/ola/v2/. All are HTTP GET requests.

**To get data:**

getdata.php?scene=[scene id]

Returns information from the database as a JSON file. If the optional parameter scene id is specified it will give out all the information from that scene including the percentage values of each of the lights, instead of just the list of all of the scene names ids and categories.

**To send a scene:**

sendscene.php?scenes=[scene ids separated by commas]&values=[values separated by commas 0 is off 255 is full]&fade=[fadetime in milliseconds]

Priority will be given to the last specified scene ID.
The fade parameter is optional, and will be rounded to 100 milliseconds (inside the python program). 

The first given scene id will be paired up with the first given value.


**To send data to single DMX channels:**

sendchanneldmx.php?channels=[channel ids separated by commas]&values=[values separated by commas, 0 is off 255 is full]&fade=[fadetime in milliseconds]

Rules are the same as above. Returns terminal command.

**To add/modify a scene:**

editscenes.php?id=[scene id if editing an already created scene else omit this parameter]&values=[values separated by commas, 0 is off 100 is full (this is a percentage) if a letter is put in place of the value it will be treated as null]&name=[scene name (remember to replace spaces with %20 if not sending from a browser]&category=[category id]

ID is optional, if not specified the program will assume you are creating a new scene and therefore throw an error if any of the other parameters are missing. If the ID is specified then each of the other parameters are optional.

**To delete a scene:**

deletescene.php?scenes=[scene ids seperated by a comma]

This will delete the scenes from the database so be careful.

**To warmup the lights:**

warmup.php

This file is just in there for simplicity's sake but can be useful as you can then modify the default warmup scene without having to modify any other application that requires this (e.g. if you got a new set of lights that only had to be warmed up for 1 minute rather than the 3 in here (although as a whole longer is better so if you want to do that thats good too)).

## Final Note:
* Do not forget to warm up your lights.
