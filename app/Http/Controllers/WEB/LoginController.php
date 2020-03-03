<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{

  public function index()
  {
    return view('auth.login');
  }
  public function submitLogin(Request $request)
  {
    $request = Request::create('/api/v1/login', 'POST',[
      'name'=>Input::get('email'),
      'password'=>Input::get('password')
      ]);

    $response = Route::dispatch($request);
    $data=(object)$response->getOriginalContent();
    $status=$data->status;
    if ($status == 'error') {
      flash($data->error)->error();
      return back();
    }else{
      $email=$data->email;
      flash('welcome '.$data->email);
      return view('home',compact('email'));
    }

  }

  public function register()
  {
   return view('register');
  }

  public function registerSubmit()
  {
    $request = Request::create('/api/v1/register', 'POST',[
      'name'=>Input::get('name'),
      'email'=>Input::get('email'),
      'phone'=>Input::get('phone'),
      'password'=>Input::get('password'),
      'password_confirmation'=>Input::get('password_confirmation'),
      ]);

    $response = Route::dispatch($request);
    $data=(object)$response->getOriginalContent();

    $status=$data->status;
    if ($status == 'error') {
      flash($data->message)->error();
      return back();
    }else{

      flash('You have Successfuly registered please use the details to login, Thankyou ');
      return view('auth.login');
    }
  }

}
