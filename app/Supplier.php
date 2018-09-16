<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  protected $guarded = [];
  protected $table = 'supplier';
  public $timestamps = false;
  
}