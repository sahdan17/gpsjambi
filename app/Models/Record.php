<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'record';
    protected $fillable = [
        'lat',
        'long',
        'speed',
        'sat',
        'status',
        'idDevice',
        'timestamp'
    ];
    public $timestamps = false;
}
