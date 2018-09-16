<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Partners extends Model
{
  protected $guarded = [];
  protected $table = 'partners';
  public $timestamps = false;
}
