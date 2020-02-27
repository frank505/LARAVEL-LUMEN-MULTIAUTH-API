<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRegisterRequest;
use App\Admin;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Services\UtilityService;
use Tymon\JWTAuth\JWTAuth;

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
           return $this->utilityService->is401Response();
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
        return response()->json(['admin' => Auth::guard('admin')->user()], 200);
    }



}
