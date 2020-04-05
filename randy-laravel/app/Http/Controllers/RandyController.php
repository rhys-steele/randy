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

        // Stop motors
        shell_exec('gpio write '.config('randy.motorA.in1').' 0');
        shell_exec('gpio write '.config('randy.motorA.in2').' 0');
        shell_exec('gpio write '.config('randy.motorB.in2').' 0');
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

        // Set motors to 0 speed to perform update
        shell_exec('gpio write '.config('randy.motorA.in1').' 0');
        shell_exec('gpio write '.config('randy.motorA.in2').' 0');
        shell_exec('gpio write '.config('randy.motorB.in2').' 0');
        shell_exec('gpio write '.config('randy.motorB.in2').' 0');

        // Get state and set speed
        if ($validated['state'] == 'stopped') {
            $speed = 0;
            $speedPWM = 0;
        } else {
            $speed = $validated['speed'];
            $speedPWM = (1023 / 100) * $speed;
            $speedPWM = (int) $speedPWM;
        }

        // Set direction
        if ($validated['direction'] == 'forward') {
            shell_exec('gpio write '.config('randy.motorA.in1').' 0');
            shell_exec('gpio write '.config('randy.motorA.in2').' 1');
            shell_exec('gpio write '.config('randy.motorB.in2').' 1');
            shell_exec('gpio write '.config('randy.motorB.in2').' 0');
        } else {
            shell_exec('gpio write '.config('randy.motorA.in1').' 1');
            shell_exec('gpio write '.config('randy.motorA.in2').' 0');
            shell_exec('gpio write '.config('randy.motorB.in2').' 0');
            shell_exec('gpio write '.config('randy.motorB.in2').' 1');
        }

        // Set motors to speed
        shell_exec('gpio pwm '.config('randy.motorA.en').' '.$speedPWM);
        shell_exec('gpio pwm '.config('randy.motorB.en').' '.$speedPWM);

        return response()->json([
            'success' => true,
            'data' => [
                'speed' => $speedPWM
            ]
        ], 200);
    }
}
