<?php namespace App\AppHelpers\Transformers;


class CityStationsTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'description' => $item['description'],
            'lat' => $item['lat'],
            'lng' => $item['lng']
        ];
    }
}
