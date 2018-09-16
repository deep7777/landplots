<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteImages extends Model
{
 protected $fillable = [
    'image_site_id',
    'image_name'
  ];
  protected $table = 'site_images';
  public $timestamps = false;
}
