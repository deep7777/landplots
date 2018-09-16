<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotOwnerPlots extends Model
{
  protected $guarded = [];
  protected $table = 'plot_owner_plots';
  public $timestamps = false;
}
