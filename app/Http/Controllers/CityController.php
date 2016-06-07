<?php

namespace App\Http\Controllers;

use App\AppHelpers\Transformers\CityTransformer;
use App\AppHelpers\Transformers\Transformer;
use App\City;
use App\Http\Controllers\ApiControllers\BaseApiController;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class CityController extends BaseApiController
{
    protected  $cityTransformer;
    public static  $globalLimit = 50;

    function __construct(Transformer $baseTransformer, CityTransformer $CityTransformer)
    {
        parent::__construct($baseTransformer);
        $this->cityTransformer = $CityTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return $this->setStatusCode(200)->respond($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCityRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        return $this->setStatusCode(200)->respond($city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCityRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::findOrFail($id)->delete();
        return $this->setStatusCode(200)->respond(true);
    }
}
