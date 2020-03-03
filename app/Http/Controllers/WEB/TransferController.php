<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    public function index()
    {
      return view('transfer');
    }

    public function transfer(Request $request)
    {

      $request=Request::create('/api/v1/transactions/transfer','POST',[
        'amount'=>$request->amount,
        'madeTo' =>$request->madeTo,

      ]);
      $request->headers->set('Authorization','Bearer '.auth()->user()->api_token);

      $response=app()->handle($request);
      $data=(object)$response->getOriginalContent();
      //  dd($data);
      $status=$data->status;
      if ($status == 'success') {
        flash($data->message)->success();
        return back();
      }else{
        flash($data->message)->error();
        return back();
      }
    }
}
