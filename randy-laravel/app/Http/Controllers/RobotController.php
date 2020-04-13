<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RobotController extends Controller
{
    public function setup(Request $request)
    {
        // Set up robot
        $this->robot->setup();
        // @todo error checking

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
            'speed' => 'numeric|min:30|max:150|required'
        ]);
        $speed = $validated['speed'];

        // Get state and set direction
        if ($validated['state'] == 'stopped') {
            $this->robot->stop();
        } else {
            $this->robot->setDirection($validated['direction']);
        }
        if ($validated['turning'] == 100) {
            // Straight
            $leftSpeed = ((380 + $speed) / 100) * 90; // Add slight handicap to left motor (hardware issue)
            $rightSpeed = 380 + $speed;

        } elseif ($validated['turning'] < 100) {
            // Turning left
            $percent = 100 - (int) $validated['turning'];
            $leftSpeed = ((380 + $speed) / 100) * $percent;
            $rightSpeed = 380 + $speed;

        } elseif ($validated['turning'] > 100) {
            // Turning right
            $percent = (int) $validated['turning'] - 100;
            $leftSpeed = 380 + $speed;
            $rightSpeed = ((380 + $speed) / 100) * $percent;
        }

        // Set motors to speed
        $this->robot->setSpeed((int) $leftSpeed, 'left');
        $this->robot->setSpeed((int) $rightSpeed, 'right');

        return response()->json([
            'success' => true,
            'data' => [
                'leftSpeed' => (int) $leftSpeed,
                'rightSpeed' => (int) $rightSpeed,
                'leftCommand' => 'gpio pwm '.config('robot.motorA.en').' '.(int) $leftSpeed,
                'rightCommand' => 'gpio pwm '.config('robot.motorB.en').' '.(int) $rightSpeed
            ]
        ], 200);
    }
}
