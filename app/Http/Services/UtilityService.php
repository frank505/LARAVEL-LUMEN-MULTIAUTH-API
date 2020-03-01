<?php
 namespace App\Http\Services;

 use Illuminate\Http\Exceptions\HttpResponseException;
 use Illuminate\Support\Facades\Hash;



 class UtilityService
 {
 

    public function is200Response($responseMessage)
    {
      throw new HttpResponseException(response()->json(
        [
            "success"=>true,
            "message"=>$responseMessage
    ], 200));      
    }
    
    public function is422Response($responseMessage)
    {
      throw new HttpResponseException(response()->json(
        [
            "success"=>false,
            "error"=>$responseMessage,
            "message"=>$responseMessage
    ], 422));
    }

    public function is500Response($responseMessage)
    {
      throw new HttpResponseException(response()->json(
        [
            "success"=>false,
            "error"=>$responseMessage,
            "message"=>$responseMessage
    ], 500));
    }

    public function is401Response()
    {
        throw new HttpResponseException(response()->json(
            [
                "success"=>false,
                "message"=>'unauthenticated',
                "error"=>"unauthenticated"
        ], 401));
    }

    public function hash_password($password)
    {
    return Hash::make($password);
    }
    



 }