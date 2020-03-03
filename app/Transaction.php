<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable=[
      'made_by',
      'made_to',
      'type',
      'amount'
    ];
}
