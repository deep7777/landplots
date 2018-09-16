<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
  protected $guarded = [];
  protected $table = 'site_status';
  public $timestamps = false;
}
