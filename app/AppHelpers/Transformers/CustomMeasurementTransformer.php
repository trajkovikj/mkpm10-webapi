<?php
/**
 * Created by PhpStorm.
 * User: srbo
 * Date: 03-Jul-16
 * Time: 4:15 PM
 */

namespace App\AppHelpers\Transformers;


class CustomMeasurementTransformer
{

    public function transformMeasurementsByCity(array $collection)
    {
        return array_map([$this, 'transformSingleMeasurementsByCity'], $collection);
    }

    public function transformSingleMeasurementsByCity($item)
    {
        return [
            'date' => $item->date,
            'pmValue' => $item->pm10
        ];
    }

    public function transformMeasurementsByStation(array $collection)
    {
        return $this->groupStationsByDate($collection);
    }


    private function groupStationsByDate($collection)
    {
        $resultCollection = [];

        foreach ($collection as $collectionItem)
        {
            $foundItemPosition = $this->containsDate($resultCollection, $collectionItem->date);

            if(!is_null($foundItemPosition))
            {
                array_push($resultCollection[$foundItemPosition]['values'], [
                    'stationId' => $collectionItem->station_id,
                    'pmValue' => $collectionItem->pm10
                ]);
            }
            else
            {
                array_push($resultCollection, [
                    'date' => $collectionItem->date,
                    'values' => [
                        [
                            'stationId' => $collectionItem->station_id,
                            'pmValue' => $collectionItem->pm10
                        ]
                    ]
                ]);
            }
        }

        return $resultCollection;
    }

    private function containsDate($collection, $date)
    {
        for ($i=0; $i < count($collection); $i++)
        {
            if($collection[$i]['date'] === $date) return $i;
        }

        return null;
    }

}