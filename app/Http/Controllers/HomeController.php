<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Company;
use App\Sites;
use App\SiteImages;
class HomeController extends Controller
{
  protected $data;
  public function __construct()
  {

  }

  public function index(Request $request)
  {
    if ($request->session()->has('admin')) {
      return redirect("/admin");
    }else if($request->session()->has('staff')){
      return redirect("/staff");
    }else{
      $company = Company::first();
      $data = [
        'lang' => $this->getLang(),
        'company'=>$company 
      ];
      return view('frontend/index',$data);
    }
  }
  
  public function getLang(){
    $lang = array("en"=>"English","mr"=>"मराठी");
    return $lang;
  }
  
  public function login(Request $request){
    if ($request->session()->has('admin')) {
      return redirect("/admin");
    }else if($request->session()->has('staff')){
      return redirect("/staff");
    }else if($request->session()->has('agent')){
      return redirect("/agent/dashboard");
    }else{
      $data = [
        'lang' => $this->getLang()
      ];
      return view('login',$data);
    }
  }
  
  public function contactUs(Request $request){
    if ($request->session()->has('admin')) {
      return redirect("/admin");
    }else if($request->session()->has('staff')){
      return redirect("/staff");
    }else{
      $company = Company::first();
      $data = [
        'company'=>$company ,
        "success"=>""  
      ];
      return view('frontend/contact-us',$data);
    }
  }
  
  public function sendContactEnquiry(Request $request){
    $num = rand(1, 500);
    $name = $request->name;
    $subject = $request->subject;
    $msg = $request->message;
    $email = $request->email;
    $phone_no = $request->phone_no;
    $this->data = [
        'name'=>$name,
        'subject'=>$subject,
        'phone_no'=>$phone_no,
        'msg'=>$msg,
        'email'=>$email
    ];
    //send mail
    Mail::send('emails.contact_email_template', $this->data, function($message)
    {
      $message->to('deep.7178@gmail.com', 'New Enquiry')->subject($this->data['subject']);
    });
    $msg = "Contact form successfully submitted.Thank you,We will get back to you soon.";
    echo $msg;
    exit;
  }
  
  public function projectStatus(Request $request,$status_id){
    //status_id = ongoing||complete||future
    $sites = Sites::leftJoin('site_images','site_images.image_site_id','=','sites.site_id')
             ->where('site_status_id',$status_id)
            ->where('image_set_active',1)
             ->get();
    $site_status = \App\SiteStatus::where('site_status_id',$status_id)->first();
    $data = [
        'sites'=>$sites,
        'site_status'=>$site_status,
        'status_id' =>$status_id,
        'company' => Company::first()
    ];
    return view('frontend/projects',$data);
  }
  
  public function siteImages(Request $request,$site_id){
    $site_images = SiteImages::join('sites','sites.site_id','=','site_images.image_site_id')
              ->where('image_site_id', $site_id)
              ->get();
    $site = Sites::where('site_id',$site_id)->first();
    $data = [
      'site'=>$site,
      'site_images'=>$site_images,
      'company' => Company::first()
    ];
    return view('frontend/siteimages',$data);
  }
}
