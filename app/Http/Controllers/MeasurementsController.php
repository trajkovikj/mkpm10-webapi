<?php

namespace App\Http\Controllers;

use App\AppHelpers\Transformers\Transformer;
use Illuminate\Http\Request;

use App\Http\Requests;

class MeasurementsController extends BaseApiController
{
    public static  $globalLimit = 50;

    function __construct(Transformer $baseTransformer)
    {
        parent::__construct($baseTransformer);
    }


    public function getAllDates()
    {

        /*
           [
              {
                "year" : "2013",
                "months" : ["Јануари", "Фебруари", "Март", "Април", "Мај", "Јуни", "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"]
              },
              {
                "year" : "2014",
                "months" : ["Јануари", "Фебруари", "Март", "Април", "Мај", "Јуни", "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"]
              },
              {
                "year" : "2015",
                "months" : ["Јануари", "Фебруари", "Март", "Април", "Мај", "Јуни", "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"]
              },
              {
                "year" : "2016",
                "months" : ["Јануари", "Фебруари", "Март", "Април", "Мај"]
              }
            ]
        */
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
