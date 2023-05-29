#!/usr/bin/python3
# coding: utf-8

import time, math, morse, sys
from signal import signal, SIGINT
from datetime import datetime, timedelta
import Hamlib

Hamlib.rig_set_debug(Hamlib.RIG_DEBUG_NONE)
ft857d = Hamlib.Rig(Hamlib.RIG_MODEL_FT857)
ft857d.set_conf("rig_pathname", "/dev/ttyUSB0")

HUNT_TIME = timedelta(hours=3) #Temps en heures de duree de la chasse.
TXTIME = timedelta(seconds=30) #Temps de transmission, prevoir le temps du SSID.
DELAY = timedelta(minutes=3) #Temps de pause entre les transmissions.

SSID = "Chasse de VE2TMQ"
TXmsg = "MOE"

def handler(signal_received, frame):
    #Arreter le transmetteur
    ft857d.set_ptt(1, 0)
    ft857d.close()
    print('SIGINT or CTRL-C detected. Exiting gracefully')
    sys.exit(1)

#################################################################################

def main():
    ft857d.open()
    END_TIME = datetime.now() + HUNT_TIME
    WARN = morse.morse('VVV', 750, 25)
    ID = morse.morse(SSID, 1000, 35)
    TXmo = morse.morse(TXmsg, 750, 8)
    SK = morse.morse(SSID + " SK", 1000, 35)
    while(datetime.now() < END_TIME):
        timeout = datetime.now() + TXTIME
        print(datetime.now())
        print("TX on")
        #Activer le transmetteur
        mode = ft857d.get_mode()
        ft857d.set_mode(2048, 0)
        ft857d.set_ptt(1, 1)
        try:
            WARN.play()
            ID.play()
            while(datetime.now() < timeout):
                time.sleep(2)
                TXmo.play()
            SK.play()
        except:
            pass
        print("TX off")
        #Arreter le transmetteur
        ft857d.set_ptt(1, 0)
        ft857d.set_mode(mode[0], mode[1])
        now = datetime.now()
        nexttime = now + DELAY
        print(now)
        print("Next TX:", nexttime)
        time.sleep(DELAY.total_seconds())

    ft857d.close()
    
###############################################

if __name__ == '__main__':
    signal(SIGINT, handler)
    main()
