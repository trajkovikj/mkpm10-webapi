<?php namespace App\Http\Controllers;

use App\AppHelpers\Transformers\Transformer;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use Exception;
use Faker\Provider\Uuid;
use App\User;
use Auth;
use DB;
use JWTAuth;
use Lang;


class UsersController extends BaseApiController {

    // Make Repository for Redis

    /**
     * @param Transformer $baseTransformer
     */
    function __construct(Transformer $baseTransformer)
    {
        parent::__construct($baseTransformer);
    }



    public function create(CreateUserRequest $request)
    {
        $uuid =  Uuid::generate(4);
        $date = new \DateTime;

        try {

            $user = User::create([
                'id' => $uuid,
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                # 'api_token' => str_random(60),
                'created_at' => $date,
                'updated_at' => $date
            ]);

        } catch (Exception $e) {
            # 409 HTP_CONFLICT
            return $this->setStatusCode(409)->respondWithError(Lang::get('messages.userAlreadyExist'));
        }

        if(!$user) return $this->respondInternalError();

        # $token = JWTAuth::fromUser($user);

        return $this->setStatusCode(201)->respond([
            'message' => Lang::get('messages.userCreated'),
            # 'token' => $token
        ]);
    }


    public function login(LoginUserRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return $this->setStatusCode(401)->respondWithError(Lang::get('messages.invalidCredentials'));
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->respondInternalError(Lang::get('messages.couldNotCreateToken'));
        }

        // all good so return the token
        return $this->setStatusCode(200)->respond([
            'token' => $token
        ]);

    }

    /*public function login(LoginUserRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $request->only('email', 'password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return $this->setStatusCode(200)->respond([
                'token' => $this->getUser()->api_token
            ]);
        }

        return $this->setStatusCode(401)->respondWithError(Lang::get('messages.invalidCredentials'));
    }*/



    public function getAll()
    {

    }

    public function get($id)
    {

    }

    public function delete($id)
    {

    }

    public function test()
    {
        return $this->setStatusCode(200)->respond([
            'test' => 'TEST TEST TEST'
        ]);
    }

    public function testAuth()
    {
        return $this->setStatusCode(200)->respond([
            'test' => 'TEST AUTH TEST'
        ]);
    }


}

