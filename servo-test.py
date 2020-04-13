#!/usr/bin/python
import wiringpi as piwiring # the name seems backwards IMO
import time

pin=4
piwiring.wiringPiSetupGpio()
try:
     #hardware pwm
     piwiring.pinMode(pin, 2)
     piwiring.pwmWrite(pin, 512) # 50%
     time.sleep(3)
     piwiring.pwmWrite(pin, 0) # 0%

     #software pwm
     piwiring.pinMode(pin, 1)
     piwiring.softPwmCreate(pin,0,100)
     piwiring.softPwmWrite(pin, 50) # 50%
     time.sleep(3)
     piwiring.softPwmWrite(pin, 0) # 0%
except KeyboardInterrupt:
     piwiring.pinMode(pin, 0)