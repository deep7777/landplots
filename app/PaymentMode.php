<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentMode extends Model
{
  protected $guarded = [];
  protected $table = 'payment_mode';
  public $timestamps = false;
}
