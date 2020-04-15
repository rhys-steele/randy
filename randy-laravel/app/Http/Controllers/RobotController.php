<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Robot;

class RobotController extends Controller
{
    protected $robot;

    public function __construct()
    {
        $this->robot = Robot::find(1);
    }

    public function setup(Request $request)
    {
        // Set up robot
        $this->robot->setup();
        // @todo error checking

        // Return response
        return response()->json([
            'success' => true,
            'data' => $this->robot->getStatus()
        ], 200);
    }

    public function sync(Request $request)
    {
        // Validate 
        $validated = $request->validate([
            'state' => 'string|in:running,stopped|required',
            'turning' => 'numeric|min:0|max:200|required',
            'direction' => 'string|in:forward,backward|required',
            'speed' => 'numeric|min:30|max:150|required',
            'webcam.x' => 'numeric|min:0|max:180|required',
            'webcam.y' => 'numeric|min:0|max:180|required',
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

        // Set the webcam position
        $this->robot->setWebcamPosition((int) $validated['webcam']['x'], (int) $validated['webcam']['y']);

        return response()->json([
            'success' => true,
            'data' => $this->robot->getStatus()
        ], 200);
    }
}
