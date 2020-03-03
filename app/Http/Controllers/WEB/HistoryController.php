<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function index()
    {
      $request=Request::create('/api/v1/history','GET',
            [],[],[],$_SERVER
            );
      $request->headers->set('Authorization','Bearer '.auth()->user()->api_token);

      $response=app()->handle($request);
      $data=(object)$response->getOriginalContent();


      return view('history',compact('data'));
    }
}
