<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRegisterRequest;
use App\Admin;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Services\UtilityService;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AdminController extends Controller
{

    //
     protected $admin;
     protected $utilityService;


    public function __construct()
    {
        $this->middleware("auth:admin",['except'=>['login','register']]);
        $this->admin = new Admin;
        $this->utilityService = new UtilityService;
    }



    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::guard('admin')->attempt($credentials)) {
           $responseMessage = "invalid username or password";
           return $this->utilityService->is422Response($responseMessage);
        }

        return $this->respondWithToken($token);
    }


    public function register(AdminRegisterRequest $request)
    {
    $password_hash = $this->utilityService->hash_password($request->password);
    $this->admin->createAdmin($request,$password_hash);
    $success_message = "registration completed successfully";
     return  $this->utilityService->is200Response($success_message);
    }

    public function viewProfile()
    {
        return response()->json([
            'success'=>true,
            'admin' => Auth::guard('admin')->user()
            ]
            , 200);
       
    }

     /**
     * Log the application out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
           
             $this->logAdminOut();

        } catch (TokenExpiredException $e) {
            
            $responseMessage = "token has already been invalidated";
            $this->tokenExpirationException($responseMessage);
        } 
    }

    
    public function logAdminOut()
    {
        Auth::guard('admin')->logout();
        $responseMessage = "successfully logged out";
      return  $this->utilityService->is200Response($responseMessage);
    }


    public function tokenExpirationException($responseMessage)
    {
        return $this->utilityService->is422Response($responseMessage);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        try
         {
            return $this->respondWithToken(Auth::guard('admin')->refresh());
        }
         catch (TokenExpiredException $e)
         {
            $responseMessage = "Token has expired and can no longer be refreshed";
            return $this->tokenExpirationException($responseMessage);
        } 
    }


}
