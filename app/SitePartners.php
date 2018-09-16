<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SitePartners extends Model
{
  protected $guarded = [];
  protected $table = 'plots';
  public $timestamps = false;
}
