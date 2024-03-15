#!/usr/bin/python3
# coding: utf-8

import time, morse, sys
import RPi.GPIO as GPIO
from signal import signal, SIGINT
from datetime import datetime, timedelta
from buttonLED import ButtonLED
from pyparam import Params

PTT = 1
GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
GPIO.setup(PTT, GPIO.OUT) # PTT
GPIO.output(PTT, GPIO.LOW)

def handler(signal_received, frame):
    GPIO.output(PTT, GPIO.LOW) #Arreter le transmetteur
    print('SIGINT or CTRL-C detected. Exiting gracefully')
    sys.exit(1)
    
#################################################################################

class buttonX(ButtonLED):
    x = 0
    def run(self):
        while True:
            if self.button.is_pressed:
                self.led.on()
                self.x += 1
                if self.x == 5:
                    self.x = 0
                print(self.x + 1)
                time.sleep(0.5)
            else:
                self.led.off()

def main(my_params):
    HUNT_TIME = timedelta(hours = my_params['time'])
    SSID = my_params['id']
    TXID = my_params['tx'] if my_params['tx'] is None else int(my_params['tx'])
    TXTIME = timedelta(seconds = my_params['txtime'])
    DELAY = timedelta(minutes = my_params['txdelay'])
    MO = my_params['prefix']

    button = buttonX(18, 17)
    END_TIME = datetime.now() + HUNT_TIME
    ID = morse.morse("VVV " +  SSID, 1000, 30)
    SK = morse.morse(SSID + " SK", 1000, 30)
    MOtx = []
    for tx in ['', 'e', 'i', 's', 'h', '5']:
        MOtx.append( morse.morse(MO + tx, 750, 8) )

    while(datetime.now() < END_TIME):
        timeout = datetime.now() + TXTIME - timedelta(seconds=ID.time + SK.time)
        print(datetime.now())
        print("TX on")
        GPIO.output(PTT, GPIO.HIGH) #Activer le transmetteur
        try:
            ID.play()
            while(datetime.now() < timeout):
                time.sleep(1)
                if TXID is None:
                    MOtx[button.x].play()
                else:
                    MOtx[TXID].play()
            SK.play()
        except:
            pass
        print("TX off")
        GPIO.output(PTT, GPIO.LOW) #Arreter le transmetteur
        now = datetime.now()
        nexttime = now + DELAY
        print(now)
        print("Next TX:", nexttime)
        time.sleep(DELAY.total_seconds())
    
###############################################

if __name__ == '__main__':
    signal(SIGINT, handler)

    params = Params(desc="Contrôleur de chasse à l'émetteur", help_on_void=False)
    params.add_param('t, time', type=int, desc='Temps de la chasse en heures', default=3)
    params.add_param('i, id', type=str, desc="Identification de la chasse", default="")
    params.add_param('x, tx', type='choice', desc='Identification du transmetteur (0, 1, 2, 3, 4, 5)', choices=["0", "1", "2", "3", "4", "5"])
    params.add_param('p, prefix', type=str, desc='Prefix du ID du transmetteur (MOx)', default="MO")
    params.add_param('s, txtime', type=int, desc='Temps de transmission en secondes', default=30)
    params.add_param('d, txdelay', type=int, desc='Delais entre les transmission en minutes', default=3)

    my_params = vars(params.parse())
    main(my_params)
