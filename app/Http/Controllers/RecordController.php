<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\LastRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            'date' => $date,
            'record' => $history,
        ]);
    }

    public function getLatestRecord(Request $request) {
        $subQuery = Record::select('idDevice', DB::raw('MAX(timestamp) as latest_timestamp'))
                        ->groupBy('idDevice');

        $latestRecords = Record::joinSub($subQuery, 'latest', function($join){
                            $join->on('record.idDevice', '=', 'latest.idDevice')
                                ->on('record.timestamp', '=', 'latest.latest_timestamp');
                        })
                        ->select('record.*')
                        ->get();

        return response()->json([
            'records' => $latestRecords,
        ]);
    }
}
