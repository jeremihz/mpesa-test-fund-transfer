<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
      $token = $request->header('Authorization');

      $tokenExplode=explode(" ",$token);
      $theToken=$tokenExplode[1];
      $userID=User::where('api_token',$theToken)->value('id');

      //Fetch notifications
      $balance=User::where('id',$userID)->value('wallet_amount');

      return $balance;
    }
}
