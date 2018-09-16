<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotBookingOwners extends Model
{
  protected $guarded = [];
  protected $table = 'plot_booking_owners';
  public $timestamps = false;
}
