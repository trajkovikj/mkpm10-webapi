<?php

namespace App\Http\Controllers;

use App\AppHelpers\Transformers\CustomMeasurementTransformer;
use App\AppHelpers\Transformers\Transformer;
use App\Http\Requests\CustomMeasurementsFilterRequest;
use App\Measurement;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;


class MeasurementsController extends BaseApiController
{
    public static  $globalLimit = 50;
    protected $customMeasurementTransformer;

    function __construct(Transformer $baseTransformer)
    {
        parent::__construct($baseTransformer);
        $this->customMeasurementTransformer = new CustomMeasurementTransformer();
    }

    public function index()
    {
        $limit = Input::get('limit') ?: self::$globalLimit;
        $measurements = Measurement::paginate($limit);

        return $this->setStatusCode(200)->respondWithPaginator($measurements, [
            'measurements' => $this->transformer->transformCollection($measurements->all()),
        ]);
    }


    public function show($id)
    {
        $measurement = Measurement::find($id);

        if(!$measurement)
            return $this->respondNotFound(Lang::get('messages.measurementNotFound'));

        return $this->setStatusCode(200)->respond($this->transformer->transform($measurement));
    }

    /**
     * Show the form for creating a new resource.
     * Route: GET /measurements/filter?properties=
     *
     * @return Response
     */
    public function filter()
    {
        $propertiesQueryParam = Input::get('properties');
        if(! $propertiesQueryParam) return  $this->setStatusCode(400)->respondWithError(Lang::get('messages.searchFilterNotProvided'));

        $propertiesArray = explode(';', $propertiesQueryParam);
        $properties = [];

        foreach($propertiesArray as $propertiesArrayItem)
        {
            $temp = explode(',',$propertiesArrayItem);
            if(count($temp) != 3) break;

            $prop = [];
            $prop['leftOperand'] = $temp[0];
            $prop['operator'] = $temp[1];
            $prop['rightOperand'] = $temp[2];

            array_push($properties, $prop);
        }

        $limit = Input::get('limit') ?: self::$globalLimit;

        $measurements = Measurement::searchFilter($properties)->paginate($limit);

        // if($measurements->total() <= 0) return $this->respondNotFound();

        return $this->setStatusCode(200)->respondWithPaginator($measurements, [
            'measurements' => $this->transformer->transformCollection($measurements->all()),
        ]);
    }
    

    public function allYearsWithMonths()
    {
        # da se popravi da bide zavisno od grad
        $dbType = config('database.default');
        $queryKey = 'yearMonthDistinct';
        $query = parent::$queryFactory->getQuery($dbType,$queryKey);

        $allYearsWithMonths = DB::table('measurement')
            ->select(DB::raw($query))
            ->get();

        $responseData = array_map([$this,'dateArrayMap'], $allYearsWithMonths);

        return $this->setStatusCode(200)->respond($responseData);
    }


    public function customFilter(CustomMeasurementsFilterRequest $request)
    {
        $cityId = $request->input('cityId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $measurements = DB::table('city')
            ->join('station', 'city.id', '=', 'station.city_id')
            ->join('measurement', 'station.id', '=', 'measurement.station_id')
            ->select('measurement.id as id',
                'city.id as city_id',
                'station.id as station_id',
                'measurement.pm10 as pm10',
                'measurement.date as date')
            ->where('city.id', '=', $cityId)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();



        return $this->setStatusCode(200)->respond($measurements);
    }
    
    public function filterByCity(CustomMeasurementsFilterRequest $request)
    {
        $cityId = $request->input('cityId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $timeUnit = $request->input('timeUnit');

        $query = $this->getQueryByTimeUnit('city', $timeUnit);

        $results = DB::select($query, [
            'cityId' => $cityId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        //$resultsAsArray = json_decode(json_encode($results), true);
        return $this->setStatusCode(200)->respond($this->customMeasurementTransformer->transformMeasurementsByCity($results));
    }


    public function filterByStation(CustomMeasurementsFilterRequest $request)
    {
        $cityId = $request->input('cityId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $timeUnit = $request->input('timeUnit');

        $query = $this->getQueryByTimeUnit('station', $timeUnit);

        $results = DB::select($query, [
            'cityId' => $cityId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $this->setStatusCode(200)->respond($this->customMeasurementTransformer->transformMeasurementsByStation($results));
    }

    public function dateArrayMap($dateObject)
    {
        return $dateObject->date;
    }

    private function getQueryByTimeUnit($resource, $timeUnit)
    {
        $dbType = config('database.default');
        $queryKey = '';

        switch ($resource)
        {
            case 'city':
            {
                $queryKey = $timeUnit === 0
                    ? 'measurementsByCityByDay'
                    : 'measurementsByCityByHour';
                break;
            }
            case 'station':
            {
                $queryKey = $timeUnit === 0
                    ? 'measurementsByStationByDay'
                    : 'measurementsByStationByHour';
                break;
            }
            default:
            {
                $queryKey = 'measurementsByCityByDay';
            }
        }

        return parent::$queryFactory->getQuery($dbType,$queryKey);
    }

    public function getAvg()
    {

        /*
            [
              {
                  "date":"2016-01-01T00:00:00.000Z",
                "pmValue":30
              },
              {
                  "date":"2016-01-02T00:00:00.000Z",
                "pmValue":50
              },
              {
                  "date":"2016-01-03T00:00:00.000Z",
                "pmValue":70
              },
              {
                  "date":"2016-01-04T00:00:00.000Z",
                "pmValue":200
              },
              {
                  "date":"2016-01-05T00:00:00.000Z",
                "pmValue":800
              }
            ]
        */
    }



    public function getPoStanica()
    {

        /*
            [
              {
                "date":"2016-01-01T00:00:00.000Z",
                "values" : [
                  {
                    "stanicaId" : 0,
                    "pmValue":30
                  },
                  {
                    "stanicaId" : 1,
                    "pmValue":50
                  },
                  {
                    "stanicaId" : 2,
                    "pmValue":70
                  },
                  {
                    "stanicaId" : 3,
                    "pmValue":90
                  }
                ]
              },

              {
                "date":"2016-01-02T00:00:00.000Z",
                "values" : [
                  {
                    "stanicaId" : 0,
                    "pmValue":110
                  },
                  {
                    "stanicaId" : 1,
                    "pmValue":150
                  },
                  {
                    "stanicaId" : 2,
                    "pmValue":170
                  },
                  {
                    "stanicaId" : 3,
                    "pmValue":200
                  }
                ]
              },

              {
                "date":"2016-01-03T00:00:00.000Z",
                "values" : [
                  {
                    "stanicaId" : 0,
                    "pmValue":300
                  },
                  {
                    "stanicaId" : 3,
                    "pmValue":360
                  }
                ]
              },

              {
                "date":"2016-01-04T00:00:00.000Z",
                "values" : [
                  {
                    "stanicaId" : 0,
                    "pmValue": 400
                  },
                  {
                    "stanicaId" : 1,
                    "pmValue":430
                  },
                  {
                    "stanicaId" : 2,
                    "pmValue": 480
                  },
                  {
                    "stanicaId" : 3,
                    "pmValue": 1290
                  }
                ]
              }
            ]
        */
    }



}
