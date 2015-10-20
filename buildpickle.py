#!/usr/bin/python3

import pickle

values = [0,0,0,0,0,0,0,0,0,0,0,0,0]
codes = [0,0,0,0,0,0,0,0,0,0,0,0,0]
toPickle = [values,codes]
pickle.dump(toPickle, open( "test.p", "wb" ) )
