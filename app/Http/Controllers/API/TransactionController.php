<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AmountTransfered;
use App\Http\Controllers\Controller;
use App\User;
use App\Transaction;
use App\Notify;
use Validator;

class TransactionController extends Controller
{
    public function topUp(Request $request)
    {
      $token = $request->header('Authorization');

      $tokenExplode=explode(" ",$token);
      $theToken=$tokenExplode[1];

      $amount=$request->amount;

      $userID=User::where('api_token',$theToken)->value('id');

      if($userID !=null){
        //Get the current amount
        $currentAmount=User::where('id',$userID)->value('wallet_amount');

        $newAmount=$currentAmount + $amount;
        //Update amount
          $topUp= User::where('id',$userID)->update(['wallet_amount'=>$newAmount]);
          //Update Notification
          $saveTransaction=Transaction::create([
            'made_by'=>$userID,
            'made_to'=>$userID,
            'type' =>'credit',
            'amount'=>$amount,
          ]);
        if ($topUp && $saveTransaction) {

          return [
            'status'=>'success',
            'message'=> 'Success Amount deposited',
          ];

        }else {
          return [
            'status'=>'error',
            'message'=>'Amount could not be deposited',
          ];
        }
      }else {
        return [
          'status'=>'error',
          'message'=>'Token not authenticated| wrong Token',
        ];
      }

    }

    public function transfer(Request $request)
    {

        //Validate
        $validator=Validator::make($request->all(),[
          'amount'=>'required|integer',
          'madeTo' => 'required'
        ]);

        if ($validator->fails()) {
          return $validator->messages();
        }

        $token = $request->header('Authorization');
        $tokenExplode=explode(" ",$token);
        $theToken=$tokenExplode[1];

        $amount=$request->amount;
        $madeTo=$request->madeTo;
        $madeToID=User::where('email',$madeTo)->value('id');

        if ($madeToID == null) {
          return [
            'status'=>'error',
            'message'=>'User not found',
          ];
        }

        $userID=User::where('api_token',$theToken)->value('id');
        $userName=User::where('api_token',$theToken)->value('name');

        if($userID !=null){
          //Get the current amount
          $currentAmount=User::where('id',$userID)->value('wallet_amount');

          //Verify amount Exists 
          if ($currentAmount < $amount) {
            return [
              'status'=>'error',
              'message'=>'Insufficient funds',
            ];
          }
          $newAmount=$currentAmount - $amount;
          //Update amount
            $topUp= User::where('id',$userID)->update(['wallet_amount'=>$newAmount]);
            //Update Notification
            $saveTransaction=Transaction::create([
              'made_by'=>$userID,
              'made_to'=>$madeToID,
              'type' =>'debit',
              'amount'=>$amount,
            ]);

          $message=$userName.' Has transferred '.$amount.' to your account, Your balance now is '.$newAmount;
            //save notification
            Notify::create([
              'user_id'=>$madeToID,
              'message'=>$message,
            ]);
          if ($topUp && $saveTransaction) {
             //Notify through email
             Notification::route('mail', $madeTo)
            ->notify(new AmountTransfered($message));
            return [
              'status'=>'success',
              'message'=> 'Success Amount Sent',
            ];

          }else {
            return [
              'status'=>'error',
              'message'=>'Amount could not be Sent',
            ];
          }
        }else {
          return [
            'status'=>'error',
            'message'=>'Not authenticated to do the request',
          ];
        }

    }
}
