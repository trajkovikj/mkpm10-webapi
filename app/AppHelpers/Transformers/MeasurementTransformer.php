<?php
/**
 * Created by PhpStorm.
 * User: Srbo
 * Date: 20.06.2016
 * Time: 16:03
 */

namespace App\AppHelpers\Transformers;


class MeasurementTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'station_id' => $item['station_id'],
            'date' => $item['date'],

            'pm10' => $item['pm10'],
            'pm25' => $item['pm25'],
            'o3' => $item['o3'],
            'co' => $item['co'],
            'no2' => $item['no2'],
            'so2' => $item['so2']
        ];
    }
}
