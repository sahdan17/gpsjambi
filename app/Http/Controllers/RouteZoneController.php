<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteZoneController extends Controller
{
    public function ppssglRoute() {
        $json = file_get_contents(public_path('assets/kmz/pps-sgl.json'));
        $polyline = json_decode($json, true);

        return response()->json([
            'polyline' => $polyline,
        ]);
    }
}
