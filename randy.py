#!/usr/bin/python

import sys

direction = sys.argv[1]
leftSpeed = sys.argv[2]
rightSpeed = sys.argv[3]

# External module imports
import RPi.GPIO as GPIO
import time

# Pin Definitons:

# Motor 1 - Left
enA = 26 # Broadcom pin 13 (P1 pin 33)
inA1 = 17 # Broadcom pin 19 (P1 pin 35)
inA2 = 22 # Broadcom pin 26 (P1 pin 37)

# Motor 2 - Right
enB = 27 # Broadcom pin 13 (P1 pin 33)
inB1 = 5 # Broadcom pin 19 (P1 pin 35)
inB2 = 6 # Broadcom pin 26 (P1 pin 37)

# Pin Setup:
GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
GPIO.cleanup()

# Motor 1
GPIO.setup(inA1, GPIO.OUT) # inA1 pin set as output
GPIO.setup(inA2, GPIO.OUT) # inA2 pin set as output
GPIO.setup(enA, GPIO.OUT) # PWM pin set as output

# Motor 2
GPIO.setup(inB1, GPIO.OUT) # inB1 pin set as output
GPIO.setup(inB2, GPIO.OUT) # inB2 pin set as output
GPIO.setup(enB, GPIO.OUT) # PWM pin set as output

pwmA = GPIO.PWM(enA, 100)  # Initialize PWM on enA 100Hz frequency
pwmB = GPIO.PWM(enB, 100)  # Initialize PWM on enA 100Hz frequency

# count = 0 # Initialize count

# Initial state for Motors (LF, RF):
if (direction == 'forward'):
    GPIO.output(inA1, GPIO.LOW)
    GPIO.output(inA2, GPIO.HIGH)
    GPIO.output(inB1, GPIO.HIGH)
    GPIO.output(inB2, GPIO.LOW)
else:
    GPIO.output(inA1, GPIO.HIGH)
    GPIO.output(inA2, GPIO.LOW)
    GPIO.output(inB1, GPIO.LOW)
    GPIO.output(inB2, GPIO.HIGH)

pwmA.start(int(leftSpeed))
pwmB.start(int(rightSpeed))
