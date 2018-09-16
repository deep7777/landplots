<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesListController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function listSelledPlots(){
    
  }
}
