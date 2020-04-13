<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    /**
     * Set up the robot pins
     */
    public function setup()
    {
        // Set up Motor A
        shell_exec('gpio mode ' . $this->motor_a_en_pin . ' pwm');
        shell_exec('gpio mode ' . $this->motor_a_in_1_pin . ' output');
        shell_exec('gpio mode ' . $this->motor_a_in_2_pin . ' output');

        // Set up Motor B
        shell_exec('gpio mode ' . $this->motor_b_en_pin . ' pwm');
        shell_exec('gpio mode ' . $this->motor_b_in_1_pin . ' output');
        shell_exec('gpio mode ' . $this->motor_b_in_2_pin . ' output');

        // Stop motors
        shell_exec('gpio write '.config('robot.motorA.in1').' 0');
        shell_exec('gpio write '.config('robot.motorA.in2').' 0');
        shell_exec('gpio write '.config('robot.motorB.in1').' 0');
        shell_exec('gpio write '.config('robot.motorB.in2').' 0');
    }

    /**
     * Stop both robot motors
     */
    public function stop()
    {
        shell_exec('gpio write '.config('robot.motorA.in1').' 0');
        shell_exec('gpio write '.config('robot.motorA.in2').' 0');
        shell_exec('gpio write '.config('robot.motorB.in1').' 0');
        shell_exec('gpio write '.config('robot.motorB.in2').' 0');
    }

    /**
     * Set the robot direction
     * 
     * @param $direction    String
     */
    public function setDirection(String $direction)
    {
        if ($direction == 'forward') {
            shell_exec('gpio write '.config('robot.motorA.in1').' 0');
            shell_exec('gpio write '.config('robot.motorA.in2').' 1');
            shell_exec('gpio write '.config('robot.motorB.in1').' 1');
            shell_exec('gpio write '.config('robot.motorB.in2').' 0');
        } else {
            shell_exec('gpio write '.config('robot.motorA.in1').' 1');
            shell_exec('gpio write '.config('robot.motorA.in2').' 0');
            shell_exec('gpio write '.config('robot.motorB.in1').' 0');
            shell_exec('gpio write '.config('robot.motorB.in2').' 1');
        }
    }

    /**
     * Set the robot speed
     * 
     * @param $speed    Int
     * @param $motor    String
     */
    public function setSpeed(Int $speed, String $motor = '')
    {
        if ($motor == '') {
            shell_exec('gpio pwm '.config('robot.motorA.en').' ' . $speed);
            shell_exec('gpio pwm '.config('robot.motorB.en').' ' . $speed);
        } else if ($motor == 'left') {
            shell_exec('gpio pwm '.config('robot.motorA.en').' ' . $speed);
        } else {
            shell_exec('gpio pwm '.config('robot.motorA.en').' ' . $speed);
        }
    }
}
