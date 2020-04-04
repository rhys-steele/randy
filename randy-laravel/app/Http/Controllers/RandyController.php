<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RandyController extends Controller
{
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
