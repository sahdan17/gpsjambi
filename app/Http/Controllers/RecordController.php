<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\LastRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecordController extends Controller
{
    public function store(Request $request) {
        $timestamp = Carbon::now('Asia/Jakarta');

        try {
            $rec = Record::create([
                'lat' => $request->lat,
                'long' => $request->long,
                'speed' => $request->speed,
                'sat' => $request->sat,
                'dir' => $request->dir,
                'status' => $request->status,
                'idDevice' => $request->idDevice,
                'timestamp' => $timestamp,
            ]);

            $last = LastRecord::updateOrCreate(
                ['idDevice' => $request->idDevice],
                [
                'lat' => $request->lat,
                'long' => $request->long,
                'speed' => $request->speed,
                'sat' => $request->sat,
                'dir' => $request->dir,
                'status' => $request->status,
                'timestamp' => $timestamp,
            ]);
    
            return response()->json([
                'record' => $rec,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getRecordByDevice(Request $request) {
        $idDevice = $request->idDevice;
        $timestamp = $request->date;

        $history = Record::where('idDevice', $idDevice)
                        ->whereDate('timestamp', $timestamp)
                        ->get();

        return response()->json([
            'idDevice' => $idDevice,
            'date' => $timestamp,
            'record' => $history,
        ]);
    }

    public function getLatestRecord(Request $request) {
        $latestRecords = LastRecord::all();

        return response()->json([
            'records' => $latestRecords,
        ]);
    }

    public static function haversine($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000;
    
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);
    
        $latDiff = $latTo - $latFrom;
        $lonDiff = $lonTo - $lonFrom;
    
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        return $earthRadius * $c;
    }
    
    public static function isWithinAllowedArea($vehicleLat, $vehicleLon, $polylineSet, $tolerance = 50) {
        foreach ($polylineSet as $polyline) {
            for ($key = 0; $key < count($polyline) - 1; $key++) {
                $start = $polyline[$key];
                $end = $polyline[$key + 1];
    
                $distanceStart = self::haversine($vehicleLat, $vehicleLon, $start[1], $start[0]);
                $distanceEnd = self::haversine($vehicleLat, $vehicleLon, $end[1], $end[0]);
    
                if ($distanceStart <= $tolerance || $distanceEnd <= $tolerance) {
                    return true;
                }
            }
        }
    
        return false;
    }    
    
    public function areaCheck(Request $request) {
        $json = file_get_contents(public_path('assets/kmz/pps-sgl.json'));
        $polyline = json_decode($json, true);
        
        $coords = explode(',', $request->loc);

        $vehicleLat = $coords[0];
        $vehicleLon = $coords[1];

        if ($this->isWithinAllowedArea($vehicleLat, $vehicleLon, $polyline)) {
            echo "Kendaraan berada di dalam area yang diperbolehkan.";
        } else {
            echo "Kendaraan berada di luar area yang diperbolehkan.";
        }
    }
}
