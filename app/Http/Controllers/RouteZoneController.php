<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteZoneController extends Controller
{
    public function ppssglRoute() {
        $json = file_get_contents(public_path('assets/kmz/rute_vt.json'));
        // $json = file_get_contents(public_path('assets/kmz/pps-sgl.json'));
        $polyline = json_decode($json, true);

        return response()->json([
            'polyline' => $polyline,
        ]);
    }

    public function formatCoordinates(Request $request): array {
        $lines = explode(" ", trim($request->input));
        $formatted = [];
        
        foreach ($lines as $line) {
            $parts = explode(",", $line);
            if (count($parts) >= 2) {
                $formatted[] = [(float) $parts[0], (float) $parts[1]];
            }
        }

        file_put_contents('coordinates1.json', json_encode($formatted, JSON_PRETTY_PRINT));
        
        return $formatted;
    }
}
