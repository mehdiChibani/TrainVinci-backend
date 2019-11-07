<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
class BaseController extends Controller
{
    //
    public function sendResponse($result,$message){
        $response=[
            'succees'=>true,
            'data'=>$result,
            'message'=>$message
        ];
        return  response()->json($response,200);
    }
    public function sendEroor($error,$errorMessage=[],$code=404){
        $response=[
            'succees'=>false,
            'data'=>$result,    
            'message'=>$error
        ];
        if(!empty($errorMessage)){
            $response['date']=$errorMessage;
        }
        return  response()->json($response,$code);
    }
    
}
