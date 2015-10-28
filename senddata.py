#!/usr/bin/python
#-------------------------------------------------------------------------------
# Name:        senddata.py
# Purpose:     Sends DMX data according to its arguments
#
# Author:      Amelia Cordwell
#
# Created:     20/10/2015
# Copyright:   (c) Amelia Cordwell 2015
# Licence:     Creative Commons
#-------------------------------------------------------------------------------

#BASK IN THE GLORIOUSNESS OF MY VERY MESSY CODE
#(actually though im kinda sorry)

import sys
from ola.ClientWrapper import ClientWrapper
import array
import math
import time
import pickle

wrapper = None
loopCount = 0
TICK_INTERVAL = 100  # in ms
universe = 1
CHANNELS = 24
fadetime = 100
goal = []
toChange = []
#we save a code as the current date time for if another thread takes the thing over
currentCode = time.time()


def DmxSent(state):
    if(loopCount >= tickGoal or len(toChange) == 0):
        #print("loop over")
        wrapper.Stop()


def SendDMXFrame():
    global toChange
    global loopCount

    data = array.array('B')
    # schdule a function call in 100ms
    # we do this first in case the frame computation takes a long time.
    wrapper.AddEvent(TICK_INTERVAL, SendDMXFrame)

    try:
        newOld = pickle.load(open( "test.p", "rb" ))
        codes = newOld[1]
        values = newOld[0]
    except:
        codes = []
        values = []
        toPickle = [values,codes]
        pickle.dump(toPickle, open( "test.p", "wb" ))



    for i in range(CHANNELS-len(codes)):
        codes.append(0)

    for i in range(CHANNELS-len(values)):
        values.append(0)

    print(values)

    if(not loopCount >= tickGoal):
        # print("add some more bro")
        # print(loopCount)
        # print(tickGoal)
        # compute frame here

        if(loopCount != 0):
            toChange = []
            for i in range((len(codes))):
                try:
                    if codes[i] == currentCode:
                        if int(values[i]+0.5) != int(goal[i]):
                            toChange.append(i)
                        else:
                            values[i] = goal[i]
                except IndexError:
                    if int(values[i]+0.5) != int(goal[i]):
                        toChange.append(i)
                    else:
                        values[i] = goal[i]

        else:
            for i in toChange:
                codes[i] = currentCode

        for i in toChange:
            values[i] = values[i] + change[i]
            if(values[i]>255):
                values[i] = 255
            elif values[i]<0:
                values[i] = 0


    if len(toChange) == 0:
        loopCount = tickGoal

    for i in range(0,len(values)):
        data.append(int(values[i] + 0.5))

    #print(toChange)
    print(values)
    toPickle = [values,codes]
    pickle.dump(toPickle, open( "test.p", "wb" ) )

    loopCount += 1

    # send
    wrapper.Client().SendDmx(universe, data, DmxSent)



# GIMME DAT DATA
try:
    prev = pickle.load(open( "test.p", "rb" ))
    prevvalues = prev[0]
    prevcodes = prev[1]
except:
    prevvalues = []
    prevcodes = []
    toPickle = [prevvalues,prevcodes]
    pickle.dump(toPickle, open( "test.p", "wb" ))

i = 1
while i < len(sys.argv):
    arg = sys.argv[i]
    if(arg == "-f"):
        i = i + 1
        fadetime = int(sys.argv[i])
    else:
        try:
            x = int(arg)
            goal.append(x)
            # Tell the things what ones we are in charge of
            toChange.append(len(goal)-1)
        except ValueError:
            try:
                #The math.floor() is technically unnessacary but better safe than sorry
                #AKA MY CODE DONT TRUST NO IDIOT
                #And anyway we refresh this code each time we send it cause reasons
                goal.append(int(math.floor(prevvalues[0][i])))
            except:
                goal.append(0);

    i=i+1
print(goal)

tickGoal = int(fadetime/TICK_INTERVAL)

if(tickGoal < 1):
    tickGoal = 1

# Create list of the amount to add each time to the current value
change = []
for i in range(len(goal)):
    try:
        diff = goal[i]-prevvalues[i]
    except:
        diff = goal[i]
    #print(diff/tickGoal)
    change.append(float(diff/tickGoal))
#print(change)

wrapper = ClientWrapper()
wrapper.AddEvent(TICK_INTERVAL, SendDMXFrame)
wrapper.Run()
SendDMXFrame();
DmxSent(True);
