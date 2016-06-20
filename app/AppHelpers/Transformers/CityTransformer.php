<?php namespace App\AppHelpers\Transformers;


class CityTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'lat' => $item['lat'],
            'lng' => $item['lng'],
            'zoom_level' => $item['zoom_level'],
            'rectangleBounds' => [
                'north' => $item['north'],
                'south' => $item['south'],
                'east' => $item['east'],
                'west' => $item['west'],
            ]
        ];
    }
}
