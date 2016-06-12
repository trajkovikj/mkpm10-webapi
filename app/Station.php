<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'id',
        'description',
        'lat',
        'lng',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'created_by',
        'updated_by'
    ];



    # Search
    public function scopeSearchToken($query, $token)
    {
        return $query->where('description', 'LIKE', '%'.$token.'%')
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
