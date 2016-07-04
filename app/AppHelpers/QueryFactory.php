<?php
/**
 * Created by PhpStorm.
 * User: srbo
 * Date: 02-Jul-16
 * Time: 2:41 PM
 */

namespace App\AppHelpers;


class QueryFactory
{

    public function getQuery($dbType, $queryKey)
    {
        $dbTypeQueries = $this->queries[$dbType];
        return $dbTypeQueries[$queryKey];
    }

    protected $queries = [

        'sqlite' => [
            'yearMonthDistinct' => "distinct(strftime('%Y-%m', date)) as date",

            'measurementsByCityByDay' => "SELECT m.id as measurement_id, c.id as city_id, s.id as station_id, avg(m.pm10) as pm10, strftime('%Y-%m-%d', m.date) as date FROM city c inner join station s on c.id=s.city_id inner join measurement m on s.id=m.station_id WHERE c.id = :cityId and m.date >= :startDate and m.date <= :endDate GROUP BY strftime('%Y-%m-%d', m.date)",

            'measurementsByCityByHour' => "SELECT m.id as measurement_id, c.id as city_id, s.id as station_id, avg(m.pm10) as pm10, m.date as date	FROM city c inner join station s on c.id=s.city_id inner join measurement m on s.id=m.station_id WHERE c.id = :cityId and m.date >= :startDate and m.date <= :endDate GROUP BY m.date",

            'measurementsByStationByDay' => "SELECT m.id as measurement_id, c.id as city_id, s.id as station_id, avg(m.pm10) as pm10, strftime('%Y-%m-%d', m.date) as date FROM city c inner join station s on c.id=s.city_id inner join measurement m on s.id=m.station_id WHERE c.id = :cityId and m.date >= :startDate and m.date <= :endDate GROUP BY s.id, strftime('%Y-%m-%d', m.date)",

            'measurementsByStationByHour' => "SELECT m.id as measurement_id, c.id as city_id, s.id as station_id, m.pm10 as pm10, m.date as date FROM city c inner join station s on c.id=s.city_id inner join measurement m on s.id=m.station_id	WHERE c.id = :cityId and m.date >= :startDate and m.date <= :endDate",

        ],

        'mysql' => [

        ],

        'pgsql' => [

        ],

    ];

}