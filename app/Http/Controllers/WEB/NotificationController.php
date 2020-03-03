<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Notify;

class NotificationController extends Controller
{

    public function index()
    {
      $request=Request::create('/api/v1/notifications','GET',
            [],[],[],$_SERVER
            );
      $request->headers->set('Authorization','Bearer '.auth()->user()->api_token);

      $response=app()->handle($request);
      $data=(object)$response->getOriginalContent();


      return view('notifies',compact('data'));

    }


}
