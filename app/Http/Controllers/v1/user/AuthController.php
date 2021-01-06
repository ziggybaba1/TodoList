<?php

namespace App\Http\Controllers\v1\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';
    protected $auth;

     /**
     * User login
     * Endpoint for users to login
     * @return json
     * @bodyParam email email required email of the registered user. Example: tina@zama.ng
     * @bodyParam password string required password of the registered user
     */
    public function login(LoginRequest $request)
    {
        $message = "unable to log you in";
        $status = 10;
        $statusCode=400;

        try {
            $credentials = $request->only('email', 'password');
             $auth = Auth::guard('web')->attempt( $credentials);;

            if(!$auth){

                $errors= [
                    'email' => [ '0' => 'These credentials do not match our records.'
                    ]
                ];

                $message =  'These credentials do not match our records.';
                $status = 11;

                return response()->json([
                    'message'    =>   $message,
                    'success'   =>  false,
                    'errors' => $errors,
                    'status'=>$status 
                ], $statusCode);
            }
        } catch (Exception $e) {
            $message =  'Invalid email address or password ';
            $status = 12;
            return response()->json([
                'message'    =>   $message,
                'success'   =>  false,
                'status'=>$status 
            ],  $statusCode );
        }

        return $this->respondWithToken();
    }

    /**
     * User Logout.
     * Endpoint for users to logout, user must be authenticated
     */
    public function logout()
    {
        $message = 'User successfully logged out';
        $status =  200;

       auth()->user()->token()->revoke();

        return response()->json([ 'message' => $message ], $status);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken()
    {
        
        $message = 'Login successful';
		$title = "User Login";
        $type = 'success';
        $target = 'login';
        $time = 8000;
        $status =  200;

        $user = User::find(request()->user()->id);
        $token =auth()->user()->createToken('todolist', [auth()->user()->acl])->accessToken;

        
        return response()->json([
            'success'   =>  true,
            'status'=>$status,
            'data' => $token,
            'message' => $message
        ], $status);
    }

    
}
