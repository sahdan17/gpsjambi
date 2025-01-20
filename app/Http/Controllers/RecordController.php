<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function store(Request $request) {
        $timestamp = Carbon::now('Asia/Jakarta');

        $rec = Record::create([
            'lat' => $request->lat,
            'long' => $request->long,
            'speed' => $request->speed,
            'status' => $request->status,
            'idDevice' => $request->idDevice,
            'timestamp' => $timestamp,
        ]);

        return response()->json([
            'record' => $rec,
        ]);
    }
}
