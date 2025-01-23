<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function storeVehicle(Request $request) {
        $vehicle = Vehicle::create([
            'nopol' => $request->nopol,
            'kode' => $request->kode,
            'cat' => $request->cat,
        ]);

        return response()->json([
            'vehicle' => $vehicle,
        ]);
    }
}
