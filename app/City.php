<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'id',
        'name',
        'lat',
        'lng',
        'zoom_level',
        'north',
        'south',
        'east',
        'west'
        #'created_by',
        #'updated_by'
    ];

    protected $hidden = [
        #'created_by',
        #'updated_by'
    ];



    public function cityStations()
    {
        return $this->hasMany('\App\Station');
    }

    # Many to many
    /*public function warehouses()
    {
        return $this->belongsToMany('\App\Warehouse', 'article_warehouse');
    }*/


    # Search
    public function scopeSearchToken($query, $token)
    {
        return $query->where('name', 'LIKE', '%'.$token.'%')
            ->orWhere('lat', 'LIKE', '%'.$token.'%')
            ->orWhere('lng', 'LIKE', '%'.$token.'%');
    }

    # Filter
    public function scopeSearchFilter($query,array $properties)
    {
        foreach($properties as $property)
            $query = $query->where($property['leftOperand'], $property['operator'], $property['rightOperand']);
        return $query;
    }
}
