<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
  protected $guarded = [];
  protected $table = 'salary';
  public $timestamps = false;
}
