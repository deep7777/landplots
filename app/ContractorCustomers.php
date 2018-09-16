<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorCustomers extends Model
{
  protected $fillable = [
    'contractor_id',
    'contractor_site_id',
    'contractor_work',
    'contractor_amount',
    'contractor_paid_amount',
    'contractor_date'
  ];
  protected $table = 'contractor_customers';
  public $timestamps = false;
}