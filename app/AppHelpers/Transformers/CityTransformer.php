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
            'zoomLevel' => $item['zoom_level'],
            'north' => $item['north'],
            'south' => $item['south'],
            'east' => $item['east'],
            'west' => $item['west']
            /*'rectangleBounds' => [
                'north' => $item['north'],
                'south' => $item['south'],
                'east' => $item['east'],
                'west' => $item['west'],
            ]*/
        ];
    }
}
