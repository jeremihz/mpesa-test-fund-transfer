<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use Validator;
use Auth;

class AuthController extends Controller
{

     public $apiToken;

  public function __construct()
   {
     $this->apiToken=str_random(60);
   }

    public function login(Request $request){
       //validate Request
       $rules=[
         'email' => 'required',
         'password' => 'required'
       ];

       $validator=Validator::make($request->all(),$rules);

       if ($validator->fails()) {
         return $validator->messages();
       }else{
        // Attempt Auth
            $auth= Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]);
            if ($auth) {
              //Update Token
              User::where('email',$request['email'])->update(['api_token'=>$this->apiToken]);
              return [
                'status'=>'success',
                'email' => $request['email'],
                'api_token'=>$this->apiToken,
              ];
            }else{
              return [
                'status' =>'error',
                'error'=>'Credentials Dont match',
                'code'=>'401'];
            }

       }
    //  return $request;
    }

    public function register(Request $request)
    {
      //validate
      $validator=Validator::make($request->all(),[
        'name'=>'required|max:255',
        'email' =>'required|unique:users|string',
        'phone' => 'required',
        'password'=>'required|string|confirmed'
      ]);

      if ($validator->fails()) {
        return [
          'status'=>'error',
          'message'=> 'Rules dont match'
        ];
      }else {
        //Create user

        $user=User::create([
            'name'=>$request->name,
            'email' =>$request->email,
            'phone'=>$request->phone,
            'password'=>bcrypt($request->password),
            'api_token' =>$this->apiToken,
          ]);


        return [
          'status'=>'success',
          'message'=>'User Created',
          'name'=>$user->name,
          'email'=>$user->email,
          'phone'=>$user->phone,
          'api_token'=>$user->api_token,
        ];
      }
    }

   public function logout(Request $request)
   {
     $token = $request->header('Authorization');
     $tokenExplode=explode(" ",$token);
     $theToken=$tokenExplode[1];

     $user = User::where('api_token',$theToken)->first();

     if($user) {

       $logout = User::where('id',$user->id)->update(['api_token'=>null]);
       if($logout) {
         return ['message' => 'User Logged Out'];
       }
     } else {
       return ['message' => 'User not found'];
     }
   }
}
