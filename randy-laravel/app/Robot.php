<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    /**
     * Set up the robot pins
     */
    protected $fillable = [
        'name',
        'ip_address',
        'control_port',
        'webcam_port',
        'motor_a_en_pin',
        'motor_a_in_1_pin',
        'motor_a_in_2_pin',
        'motor_b_en_pin',
        'motor_b_in_1_pin',
        'motor_b_in_2_pin',
        'webcam_x_pin',
        'webcam_y_pin',
        'state',
        'state_direction',
        'state_left_speed',
        'state_right_speed',
        'state_webcam_x',
        'state_webcam_y'
    ];

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
        shell_exec('gpio write ' . $this->motor_a_in_1_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_a_in_2_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_b_in_1_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_b_in_2_pin . ' 0');

        // Set state
        $this->state_direction = 'forward';
        $this->state = 'stopped';
        $this->state_left_speed = 0;
        $this->state_right_speed = 0;
        $this->state_webcam_x = 90;
        $this->state_webcam_y = 90;
        $this->save();
    }

    /**
     * Stop both robot motors
     */
    public function stop()
    {
        shell_exec('gpio write ' . $this->motor_a_in_1_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_a_in_2_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_b_in_1_pin . ' 0');
        shell_exec('gpio write ' . $this->motor_b_in_2_pin . ' 0');
        $this->state = 'stopped';
        $this->save();
    }

    /**
     * Set the robot direction
     * 
     * @param $direction    String
     */
    public function setDirection(String $direction)
    {
        if ($direction == 'forward') {
            shell_exec('gpio write ' . $this->motor_a_in_1_pin . ' 0');
            shell_exec('gpio write ' . $this->motor_a_in_2_pin . ' 1');
            shell_exec('gpio write ' . $this->motor_b_in_1_pin . ' 1');
            shell_exec('gpio write ' . $this->motor_b_in_2_pin . ' 0');
        } else {
            shell_exec('gpio write ' . $this->motor_a_in_1_pin . ' 1');
            shell_exec('gpio write ' . $this->motor_a_in_2_pin . ' 0');
            shell_exec('gpio write ' . $this->motor_b_in_1_pin . ' 0');
            shell_exec('gpio write ' . $this->motor_b_in_2_pin . ' 1');
        }
        $this->state_direction = $direction;
        $this->save();
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
            shell_exec('gpio pwm ' . $this->motor_a_en_pin . ' ' . $speed);
            shell_exec('gpio pwm ' . $this->motor_b_en_pin . ' ' . $speed);
            $this->state_left_speed = $speed;
            $this->state_right_speed = $speed;
        } else if ($motor == 'left') {
            shell_exec('gpio pwm ' . $this->motor_a_en_pin . ' ' . $speed);
            $this->state_left_speed = $speed;
        } else {
            shell_exec('gpio pwm ' . $this->motor_b_en_pin . ' ' . $speed);
            $this->state_right_speed = $speed;
        }
        $this->save();
    }

    /**
     * Get the robot status
     *
     */
    public function getStatus()
    {
        return [
            'state' => $this->state,
            'direction' => $this->state_direction,
            'overall_speed' => $this->state_overall_speed,
            'left_speed' => $this->state_left_speed,
            'right_speed' => $this->state_right_speed,
            'webcam_x' => $this->state_webcam_x,
            'webcam_y' => $this->state_webcam_y
        ];
    }

    /**
     * Set the robot webcam position
     *
     */
    public function setWebcamPosition(Int $x, Int $y)
    {
        $this->state_webcam_x = $x;
        $this->state_webcam_y = $y;
        $this->save();
        return true;
    }
}
