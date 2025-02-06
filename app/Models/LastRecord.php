<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lastrecord extends Model
{
    use HasFactory;

    protected $table = 'lastrecord';
    protected $primaryKey = 'idDevice';
    public $incrementing = false;
    protected $fillable = [
        'lat',
        'long',
        'speed',
        'sat',
        'dir',
        'status',
        'idDevice',
        'timestamp'
    ];
    public $timestamps = false;
}
