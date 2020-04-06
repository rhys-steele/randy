<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RandyController extends Controller
{
    public function setup(Request $request)
    {
        // @todo error checking

        // Set up Motor A
        shell_exec('gpio mode '.config('randy.motorA.en').' pwm');
        shell_exec('gpio mode '.config('randy.motorA.in1').' output');
        shell_exec('gpio mode '.config('randy.motorA.in2').' output');

        // Set up Motor B
        shell_exec('gpio mode '.config('randy.motorB.en').' pwm');
        shell_exec('gpio mode '.config('randy.motorB.in1').' output');
        shell_exec('gpio mode '.config('randy.motorB.in2').' output');
        
        // Set PWM settings
        shell_exec('gpio pwm-bal');
        shell_exec('gpio pwmc 500');
        shell_exec('gpio pwmr 1023');

        // Stop motors
        shell_exec('gpio write '.config('randy.motorA.in1').' 0');
        shell_exec('gpio write '.config('randy.motorA.in2').' 0');
        shell_exec('gpio write '.config('randy.motorB.in1').' 0');
        shell_exec('gpio write '.config('randy.motorB.in2').' 0');

        // Return response
        return response()->json([
            'success' => true
        ], 200);
    }

    public function execute(Request $request)
    {
        // Validate 
        $validated = $request->validate([
            'state' => 'string|in:running,stopped|required',
            'turning' => 'numeric|min:0|max:200|required',
            'direction' => 'string|in:forward,backward|required',
            'speed' => 'numeric|min:0|max:100|required'
        ]);
        $speed = $validated['speed'];

        // Get state and set speed
        if ($validated['state'] == 'stopped') {
            shell_exec('gpio write '.config('randy.motorA.in1').' 0');
            shell_exec('gpio write '.config('randy.motorA.in2').' 0');
            shell_exec('gpio write '.config('randy.motorB.in1').' 0');
            shell_exec('gpio write '.config('randy.motorB.in2').' 0');
        } else {
            // Set direction
            if ($validated['direction'] == 'forward') {
                shell_exec('gpio write '.config('randy.motorA.in1').' 0');
                shell_exec('gpio write '.config('randy.motorA.in2').' 1');
                shell_exec('gpio write '.config('randy.motorB.in1').' 1');
                shell_exec('gpio write '.config('randy.motorB.in2').' 0');
            } else {
                shell_exec('gpio write '.config('randy.motorA.in1').' 1');
                shell_exec('gpio write '.config('randy.motorA.in2').' 0');
                shell_exec('gpio write '.config('randy.motorB.in1').' 0');
                shell_exec('gpio write '.config('randy.motorB.in2').' 1');
            }
        }

        if ($validated['turning'] == 100) {
            // Straight
            $leftSpeed = (((1023 / 100) * $speed) / 100) * 90;
            $rightSpeed = (1023 / 100) * $speed;

        } elseif ($validated['turning'] < 100) {
            // Turning left
            $percent = 100 - (int) $validated['turning'];
            $leftSpeed = (((1023 / 100) * $speed) / 100) * $percent;
            $rightSpeed = (1023 / 100) * $speed;

        } elseif ($validated['turning'] > 100) {
            // Turning right
            $percent = (int) $validated['turning'] - 100;
            $leftSpeed = (1023 / 100) * $speed;
            $rightSpeed = (((1023 / 100) * $speed) / 100) * $percent;
        }

        // Set motors to speed
        shell_exec('gpio pwm '.config('randy.motorA.en').' '.(int) $leftSpeed);
        shell_exec('gpio pwm '.config('randy.motorB.en').' '.(int) $rightSpeed);

        return response()->json([
            'success' => true,
            'data' => [
                'leftSpeed' => (int) $leftSpeed,
                'rightSpeed' => (int) $rightSpeed,
                'leftCommand' => 'gpio pwm '.config('randy.motorA.en').' '.(int) $leftSpeed,
                'rightCommand' => 'gpio pwm '.config('randy.motorB.en').' '.(int) $rightSpeed
            ]
        ], 200);
    }
}
