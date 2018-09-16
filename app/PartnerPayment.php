<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PartnerPayment extends Model
{
  protected $guarded = [];
  protected $table = 'partner_payment';
  public $timestamps = false;
}
