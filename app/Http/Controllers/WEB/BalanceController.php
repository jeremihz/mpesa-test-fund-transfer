<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    public function index()
    {
      $request=Request::create('/api/v1/balance','GET',
            [],[],[],$_SERVER
            );
      $request->headers->set('Authorization','Bearer '.auth()->user()->api_token);

      $response=app()->handle($request);
      $data=$response->getOriginalContent();

      // dd($data);
      return view('balance',compact('data'));
    }
}
