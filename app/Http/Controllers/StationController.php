<?php

namespace App\Http\Controllers;

use App\AppHelpers\GlobalPropertiesFormatter;
use App\AppHelpers\Transformers\Transformer;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\CreateStationRequest;
use App\Http\Requests\EditStationRequest;
use App\Station;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Webpatser\Uuid\Uuid;

class StationController extends BaseApiController
{
    protected $formatter;
    public static  $globalLimit = 50;

    function __construct(Transformer $baseTransformer)
    {
        parent::__construct($baseTransformer);
        $this->formatter = new GlobalPropertiesFormatter();
    }

    /**
     * Display a listing of the resource.
     * Route: GET /stations?limit=5&page=3
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = Input::get('limit') ?: self::$globalLimit;
        $stations = Station::paginate($limit);

        return $this->setStatusCode(200)->respondWithPaginator($stations, [
            'stations' => $this->transformer->transformCollection($stations->all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Route: GET /stations/{id}/create
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
     * @param CreateStationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStationRequest $request)
    {
        # $userId = $this->getUserId();

        $additionalInfo = [
            'id' => Uuid::generate(4),
            # 'created_by' => $userId,
            # 'updated_by' => $userId
        ];

        $formattedRequestProperties = $this->formatter->formatRequestProperties($request->all());
        $cleanRequest = $this->removeHiddenFieldsFromRequest($formattedRequestProperties, new Station());
        $req = array_merge($cleanRequest, $additionalInfo);

        $station = Station::create($req);
        $station->id = $req['id']->string;

        return $this->setStatusCode(201)->respond($this->transformer->transform($station));
    }

    /**
     * Display the specified resource.
     * Route: GET /stations/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $station = Station::find($id);

        if(!$station)
            return $this->respondNotFound(Lang::get('messages.stationNotFound'));

        return $this->setStatusCode(200)->respond($this->transformer->transform($station));
    }

    /**
     * Show the form for editing the specified resource.
     * Route: GET /stations/{id}/edit
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
     * Route: PATCH/PUT /stations/{id}
     *
     * @param EditStationRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditStationRequest $request, $id)
    {
        $formattedRequestProperties = $this->formatter->formatRequestProperties($request->all());
        $req = $this->removeHiddenFieldsFromRequest($formattedRequestProperties, new Station());
        # $req = array_merge($req, ['updated_by' => $this->getUserId()]);

        if(! Station::where('id', '=', $id)->update($req)) $this->respondInternalError();

        $changedStation = Station::where('id', '=', $id)->first();
        return $this->setStatusCode(200)->respond($this->transformer->transform($changedStation));
    }

    /**
     * Remove the specified resource from storage.
     * Route: DELETE /stations/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $station = Station::find($id);

        if(!$station)
            return $this->respondNotFound(Lang::get('messages.stationNotFound'));

        $station->delete();

        return $this->setStatusCode(200)->respond(true);
    }
}
