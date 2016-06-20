<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = [
        'id',
        'station_id',
        'date',
        'pm10',
        'pm25',
        'o3',
        'co',
        'no2',
        'so2'
    ];

    protected $hidden = [];
}
