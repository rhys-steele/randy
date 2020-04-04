#!/usr/bin/python

import sys

# External module imports
# import RPi.GPIO as GPIO
import time

# Pin Definitons:

# Motor 1 - Left
enA = 26
inA1 = 17
inA2 = 22

# Motor 2 - Right
enB = 27
inB1 = 5
inB2 = 6

dc = 100 # duty cycle (0-100) for PWM pin

# # Pin Setup:
# GPIO.setmode(GPIO.BCM)

# # Motor 1
# GPIO.setup(inA1, GPIO.OUT) # inA1 pin set as output
# GPIO.setup(inA2, GPIO.OUT) # inA2 pin set as output
# GPIO.setup(enA, GPIO.OUT) # PWM pin set as output

# # Motor 2
# GPIO.setup(inB1, GPIO.OUT) # inB1 pin set as output
# GPIO.setup(inB2, GPIO.OUT) # inB2 pin set as output
# GPIO.setup(enB, GPIO.OUT) # PWM pin set as output

# pwmA = GPIO.PWM(enA, 100)  # Initialize PWM on enA 100Hz frequency
# pwmB = GPIO.PWM(enB, 100)  # Initialize PWM on enA 100Hz frequency

# count = 0 # Initialize count

# # Initial state for Motors (LF, RF):
# GPIO.output(inA1, GPIO.LOW)
# GPIO.output(inA2, GPIO.HIGH)

# GPIO.output(inB1, GPIO.HIGH)
# GPIO.output(inB2, GPIO.LOW)

print 'Number of arguments:', len(sys.argv), 'arguments.'
print 'Argument List:', str(sys.argv)

# pwmA.start(dc)
# pwmB.start(dc)

# print("Here we go! Press CTRL+C to exit")
# try:
#     while 1:
#         time.sleep(1)

# except KeyboardInterrupt: # If CTRL+C is pressed, exit cleanly:
#     pwmA.stop() # stop PWM
#     pwmB.stop() # stop PWM
#     GPIO.cleanup() # cleanup all GPIO

# pwmA.stop() # stop PWM
# pwmB.stop() # stop PWM
# GPIO.cleanup() # cleanup all GPIO
