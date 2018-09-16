<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
   public function __construct(){
    $this->middleware('userAuth');    
  }
 
  public function listMessage(){
    return view('message/list_message');
  }
  
}
