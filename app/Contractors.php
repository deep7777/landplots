<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractors extends Model
{
  protected $fillable = [
    'contractor_first_name',
    'contractor_last_name',
    'contractor_email',
    'contractor_mobile_no',
    'contractor_address'
  ];
  protected $table = 'contractors';
  public $timestamps = false;
  
  
}
