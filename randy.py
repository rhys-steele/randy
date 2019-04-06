# External module imports
import RPi.GPIO as GPIO
import time

# Pin Definitons:
enA = 13 # Broadcom pin 13 (P1 pin 33)
inA1 = 19 # Broadcom pin 23 (P1 pin 35)
inA2 = 26 # Broadcom pin 17 (P1 pin 37)

dc = 95 # duty cycle (0-100) for PWM pin

# Pin Setup:
GPIO.setmode(GPIO.BCM) # Broadcom pin-numbering scheme

GPIO.setup(inA1, GPIO.OUT) # LED pin set as output
GPIO.setup(inA2, GPIO.OUT) # LED pin set as output
GPIO.setup(enA, GPIO.OUT) # PWM pin set as output

pwm = GPIO.PWM(pwmPin, 50)  # Initialize PWM on pwmPin 100Hz frequency

# Initial state for LEDs:
GPIO.output(inA1, GPIO.LOW)
GPIO.output(inA2, GPIO.HOW)
pwm.start(dc)

print("Here we go! Press CTRL+C to exit")
try:
    while 1:

except KeyboardInterrupt: # If CTRL+C is pressed, exit cleanly:
    pwm.stop() # stop PWM
    GPIO.cleanup() # cleanup all GPIO