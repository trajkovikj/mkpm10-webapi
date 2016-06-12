<?php namespace App\Http\Controllers\ApiControllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\ShelfHelpers\Transformers\Transformer;
use Faker\Provider\Uuid;
use Tymon\JWTAuth\Exceptions\JWTException;
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
                'created_at' => $date,
                'updated_at' => $date
            ]);

        } catch (Exception $e) {
            # 409 HTP_CONFLICT
            return $this->setStatusCode(409)->respondWithError(Lang::get('messages.userAlreadyExist'));
        }

        if(!$user) return $this->respondInternalError();

        $token = JWTAuth::fromUser($user);

        return $this->setStatusCode(201)->respond([
            'message' => Lang::get('messages.userCreated'),
            'token' => $token
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

    public function getAll()
    {

    }

    public function get($id)
    {

    }

    public function delete($id)
    {

    }



}

