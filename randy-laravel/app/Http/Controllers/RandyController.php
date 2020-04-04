<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RandyController extends Controller
{
    public function setup(Request $request)
    {
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorA.en'),
            'mode' => 'pwm'
        ]);
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorA.in1'),
            'mode' => 'output'
        ]);
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorA.in2'),
            'mode' => 'output'
        ]);
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorB.en'),
            'mode' => 'pwm'
        ]);
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorB.in1'),
            'mode' => 'output'
        ]);
        Artisan::call('pin:mode', [
            'pin' => config('randy.motorB.in2'),
            'mode' => 'output'
        ]);
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
        Artisan::call('pin:value', [
            'mode' => 'pwm',
            'pin' => config('randy.motorA.en'),
            'value' => 0,
        ]);
        Artisan::call('pin:mode', [
            'mode' => 'pwm',
            'pin' => config('randy.motorB.en'),
            'value' => 0
        ]);

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
            Artisan::call('pin:value', [
                'mode' => 'digital',
                'pin' => config('randy.motorA.in1'),
                'value' => 0,
            ]);
            Artisan::call('pin:mode', [
                'mode' => 'digital',
                'pin' => config('randy.motorA.in2'),
                'value' => 1
            ]);
            Artisan::call('pin:value', [
                'mode' => 'digital',
                'pin' => config('randy.motorB.in1'),
                'value' => 1,
            ]);
            Artisan::call('pin:mode', [
                'mode' => 'digital',
                'pin' => config('randy.motorB.in2'),
                'value' => 0
            ]);
        } else {
            Artisan::call('pin:value', [
                'mode' => 'digital',
                'pin' => config('randy.motorA.in1'),
                'value' => 1,
            ]);
            Artisan::call('pin:mode', [
                'mode' => 'digital',
                'pin' => config('randy.motorA.in2'),
                'value' => 0
            ]);
            Artisan::call('pin:value', [
                'mode' => 'digital',
                'pin' => config('randy.motorB.in1'),
                'value' => 0,
            ]);
            Artisan::call('pin:mode', [
                'mode' => 'digital',
                'pin' => config('randy.motorB.in2'),
                'value' => 1
            ]);
        }

        // Set motors to speed
        Artisan::call('pin:value', [
            'mode' => 'pwm',
            'pin' => config('randy.motorA.en'),
            'value' => $speedPWM
        ]);
        Artisan::call('pin:mode', [
            'mode' => 'pwm',
            'pin' => config('randy.motorB.en'),
            'value' => $speedPWM
        ]);

        return response()->json([
            'success' => true
        ], 200);
    }
}
