<?php namespace App\AppHelpers\Transformers;


class CityTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'lat' => $item['lat'],
            'lng' => $item['lng']
        ];
    }
}
