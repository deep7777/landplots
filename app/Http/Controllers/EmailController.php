<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class EmailController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){  
    
    $data = array("name"=>"Deepak Yadav");
    Mail::send('emails.demo', $data, function($message)
    {
      $num = rand(1, 500);
      $message->to('deep.7178@gmail.com', 'Deepak Yadav')->subject('This is a demo!'.$num);
    });
    echo "mail sent exit";
  }
}
