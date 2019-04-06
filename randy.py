# External module imports
import RPi.GPIO as GPIO
import time

# Pin Definitons:
enA = 18 # Broadcom pin 13 (P1 pin 33)
inA1 = 23 # Broadcom pin 19 (P1 pin 35)
inA2 = 17 # Broadcom pin 26 (P1 pin 37)

dc = 100 # duty cycle (0-100) for PWM pin

# Pin Setup:
GPIO.setmode(GPIO.BCM) # Broadcom pin-numbering scheme

GPIO.setup(inA1, GPIO.OUT) # inA1 pin set as output
GPIO.setup(inA2, GPIO.OUT) # inA2 pin set as output
GPIO.setup(enA, GPIO.OUT) # PWM pin set as output

pwm = GPIO.PWM(enA, 100)  # Initialize PWM on enA 100Hz frequency

count = 0 # Initialize count

# Initial state for LEDs:
GPIO.output(inA1, GPIO.HIGH)
GPIO.output(inA2, GPIO.LOW)
pwm.start(dc)

print("Here we go! Press CTRL+C to exit")
try:
    while count < 10:
        count += 1
        time.sleep(1)
        print 10 - count

except KeyboardInterrupt: # If CTRL+C is pressed, exit cleanly:
    pwm.stop() # stop PWM
    GPIO.cleanup() # cleanup all GPIO

pwm.stop() # stop PWM
GPIO.cleanup() # cleanup all GPIO
