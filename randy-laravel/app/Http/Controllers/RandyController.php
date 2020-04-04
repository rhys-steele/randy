<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RandyController extends Controller
{
    public function setup(Request $request)
    {
        Artisan::call('pin:mode', [
            'pin' => 27,
            'mode' => 'output'
        ]);
        Artisan::call('pin:mode', [
            'pin' => 28,
            'mode' => 'output'
        ]);
        Artisan::call('pin:mode', [
            'pin' => 29,
            'mode' => 'output'
        ]);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function execute(Request $request)
    {
        $validated = $request->validate([
            'state' => 'string|in:running,stopped|required',
            'direction' => 'numeric|min:0|max:200|required',
            'speed' => 'numeric|min:0|max:100|required'
        ]);
        return response()->json([
            'success' => true
        ], 200);
    }
}
