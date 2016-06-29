<?php

namespace App\Http\Controllers;

use App\AppHelpers\GlobalPropertiesFormatter;
use App\AppHelpers\Transformers\CityStationsTransformer;
use App\AppHelpers\Transformers\CityTransformer;
use App\AppHelpers\Transformers\Transformer;
use App\City;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Webpatser\Uuid\Uuid;


class CityController extends BaseApiController
{
    protected $formatter;
    protected  $cityStationsTransformer;
    public static  $globalLimit = 50;

    function __construct(Transformer $baseTransformer, CityStationsTransformer $CityStationsTransformer)
    {
        parent::__construct($baseTransformer);
        $this->cityStationsTransformer = $CityStationsTransformer;
        $this->formatter = new GlobalPropertiesFormatter();
    }

    /**
     * Display a listing of the resource.
     * Route: GET /cities?limit=5&page=3
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = Input::get('limit') ?: self::$globalLimit;
        $cities = City::paginate($limit);

        return $this->setStatusCode(200)->respondWithPaginator($cities, [
            'cities' => $this->transformer->transformCollection($cities->all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Route: GET /cities/{id}/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Not implemented';
    }

    /**
     * Store a newly created resource in storage.
     * Route: POST /cities
     *
     * @param CreateCityRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        # $userId = $this->getUserId();

        $additionalInfo = [
            'id' => Uuid::generate(4),
            #'created_by' => $userId,
            #'updated_by' => $userId
        ];
        

        $formattedRequestProperties = $this->formatter->formatRequestProperties($request->all());
        $cleanRequest = $this->removeHiddenFieldsFromRequest($formattedRequestProperties, new City());
        $req = array_merge($cleanRequest, $additionalInfo);

        $city = City::create($req);
        $city->id = $req['id']->string;

        return $this->setStatusCode(201)->respond($this->transformer->transform($city));
    }

    /**
     * Display the specified resource.
     * Route: GET /cities/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);

        if(!$city)
            return $this->respondNotFound(Lang::get('messages.cityNotFound'));

        $cityStations = $city->cityStations;
        $transformedCity = $this->transformer->transform($city);
        $transformedCityStations = $this->cityStationsTransformer->transformCollection($cityStations->all());
        $transformedCity = array_merge($transformedCity, [ 'cityStations' => $transformedCityStations ]);

        return $this->setStatusCode(200)->respond($transformedCity);
    }

    /**
     * Show the form for editing the specified resource.
     * Route: GET /cities/{id}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'Not implemented';
    }

    /**
     * Update the specified resource in storage.
     * Route: PATCH/PUT /cities/{id}
     *
     * @param UpdateCityRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityRequest $request, $id)
    {
        $formattedRequestProperties = $this->formatter->formatRequestProperties($request->all());
        $req = $this->removeHiddenFieldsFromRequest($formattedRequestProperties, new City());
        # $req = array_merge($req, ['updated_by' => $this->getUserId()]);

        if(! City::where('id', '=', $id)->update($req)) $this->respondInternalError();

        $changedCity = City::where('id', '=', $id)->first();
        return $this->setStatusCode(200)->respond($this->transformer->transform($changedCity));
    }

    /**
     * Remove the specified resource from storage.
     * Route: DELETE /cities/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if(!$city)
            return $this->respondNotFound(Lang::get('messages.cityNotFound'));

        $city->delete();

        return $this->setStatusCode(200)->respond(true);
    }
}
