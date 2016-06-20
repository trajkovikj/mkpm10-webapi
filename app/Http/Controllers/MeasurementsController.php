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

    }
}
