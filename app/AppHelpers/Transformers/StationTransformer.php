<?php
/**
 * Created by PhpStorm.
 * User: Srbo
 * Date: 29.06.2016
 * Time: 16:52
 */

namespace App\AppHelpers\Transformers;


class StationTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'cityId' => $item['city_id'],
            'description' => $item['description'],
            'lat' => $item['lat'],
            'lng' => $item['lng']
        ];
    }
}