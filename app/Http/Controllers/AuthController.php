<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
      $response = $client->request('POST', '/api/v1/login', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'email' => $token,
            ],
          ]);
    }
}
