<?php namespace App\Http\Controllers;

use App\AppHelpers\Transformers\Transformer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
// use Request;

class BaseApiController extends Controller {

    protected $statusCode;
    protected $transformer;


    function __construct(Transformer $baseTransformer)
    {
        $this->transformer = $baseTransformer;
    }


    public function getStatusCode() { return $this->statusCode; }

    public function setStatusCode($statusCode) { $this->statusCode = $statusCode; return $this;}



    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }


    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }



    public function respond($data, $headers = [])
    {
        return response()->json([
            'data' => $data,
            'status_code' => $this->getStatusCode()
        ], $this->getStatusCode(), $headers);
    }

    public function respondWithError($message, $internalStatusCode = null)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'internal_status_code' => $internalStatusCode
            ]
        ]);
    }


    /**
     * @param Paginator|LengthAwarePaginator $resourcePaginator
     * @param $data
     * @return mixed
     */
    public function respondWithPaginator(LengthAwarePaginator $resourcePaginator, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $resourcePaginator->total(),
                'total_pages' => ceil($resourcePaginator->total() / $resourcePaginator->perPage()),
                'current_page' => $resourcePaginator->currentPage(),
                'limit' => $resourcePaginator->perPage()
            ]
        ]);

        return $this->respond($data);
    }


    public function removeHiddenFieldsFromRequest(array $request, Model $model)
    {
        $arr = [];
        $allowed =  array_diff($model->getFillable(), $model->getHidden());

        foreach($request as $key => $value)
        {
            if(in_array($key, $allowed)) $arr[$key] = $value;
        }

        return $arr;
    }


    public function getUserId()
    {
        return $this->getUser()->id;
    }

    public function getUser()
    {
        # return Auth User
        #return JWTAuth::parseToken()->authenticate();
        return Auth::guard('api')->user();
    }

}