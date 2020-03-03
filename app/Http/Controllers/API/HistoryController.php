<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\User;
use App\Transaction;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
      $token = $request->header('Authorization');

      $tokenExplode=explode(" ",$token);
      $theToken=$tokenExplode[1];
      $userID=User::where('api_token',$theToken)->value('id');

        if ($userID == null) {
          return [
            'status'=>'error',
            'message'=>'User with token not found',
          ];
        }
      //Fetch Transactions
      $history=Transaction::where('made_by',$userID)->get();

      return $history;
    }
}
