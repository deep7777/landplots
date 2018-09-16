<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  protected $fillable = [
    'media_name'
  ];
  protected $table = 'media';
  public $timestamps = false;
}
