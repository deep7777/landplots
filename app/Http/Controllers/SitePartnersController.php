<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Sites;
use App\Plots;
use App\PartnerPayment;
use App\Partners;
use App\PaymentMode;
class SitePartnersController extends Controller
{
  public function __construct(){
    $this->middleware('adminAuth');    
  }
  
  public function index(){
    $data = $this->getData();
    return view('partners/list_partner',$data);
  }
  
  public function getData(){
    $site_list = Sites::all();
    $data = [
      'site_list'=>$site_list
    ];
    return $data;
  }
  
  public function listPartners(){
    $site_list = Sites::all();
    $partners = Partners::leftJoin('sites', 'sites.site_id', '=', 'partners.site_id')->get();
    $data = [
      'site_list'=>$site_list,
      'partners'=>$partners
    ];
    return view('partners/list_partners',$data);
  }
  
  public function addPartner(Request $request,$site_id){
    $site = Sites::where('site_id',$site_id)->first();
    $site_contractor_amount = Sites::getContractorAmount($site_id);
    $total_site_cost = '0';
    if($site){
      $total_site_cost = $site_contractor_amount + $site->site_cost;
    }
    $data = [
        'site'=>$site,
        'site_contractor_amount'=>$site_contractor_amount,
        'total_site_cost'=>$total_site_cost
    ];
    
    return view('partners/add_partner',$data);
  }
  
  public function addSitePartner(Request $request){
    $partner = new Partners();
    $this->getPartnerFields($partner,$request);
    $partner->save();
    return Redirect::to("/listPartners");
  }
  
  public function delPartnerPayments($id){
    $payments = PartnerPayment::where('partner_id', $id)->get();
    foreach($payments as $payment){
      PartnerPayment::where('partner_payment_id', $payment->partner_payment_id)->delete();
    }
  }
  
  public function delSitePartner(Request $request){
    $id = $request->id;
    $this->delPartnerPayments($id);
    $partner = Partners::where('partner_id', $id)->first();
    if ($partner) {
      Partners::where('partner_id', $id)->delete();
      return "success";
    }else{
      return "failure";
    }
  }
  public function editSitePartner(Request $request){
     $id = $request->segment('2');
     $partner = Partners::leftJoin('sites', 'sites.site_id', '=', 'partners.site_id')->where('partner_id', $id)->first();
     if ($partner) {
        $site_contractor_amount = Sites::getContractorAmount($partner->site_id);
        $site = Sites::where('site_id',$partner->site_id)->first();
        $total_site_cost = '0';
        if($site){
          $total_site_cost = $site_contractor_amount + $site->site_cost;
        }
        $data = [
            'partner'=>$partner,
            'site'=>$site,
            'site_contractor_amount'=>$site_contractor_amount,
            'total_site_cost'=>$total_site_cost
        ];
        return view('partners/edit_partner',compact('partners'),$data);
      }else{
        return view('errors/record_not_found',['msg'=>'Record not Found']);
      }
  }
  public function getPartnerFields($partner,$request){
    $partner->site_id = $request->site_id;
    $partner->partner_first_name = $request->partner_first_name;
    $partner->partner_middle_name = $request->partner_middle_name;
    $partner->partner_last_name = $request->partner_last_name;
    $partner->partner_email = $request->partner_email_id;
    $partner->partner_mobile_no = $request->partner_mobile_no;
    $partner->partner_address = $request->partner_address;
    $partner->partner_percentage = $request->partner_percentage;
    $partner->partner_amount = $request->partner_amount;
    return $partner;
  }
  
  public function updateSitePartner(Request $request){
    $partner_id = $request->id;
    $partner = new \stdClass();
    $partner->partner_id = $partner_id;
    $this->getPartnerFields($partner,$request);
    $partner_record = (array) $partner;     
    Partners::where('partner_id', $partner_id)->update($partner_record);
    return Redirect::to("/listPartners");
  }
  
  public function siteInfo($site_id){
    $site_list = Sites::where('site_id',$site_id)->get();
    return view('site/list_site',['site_list'=>$site_list]);
  }
  
  public function getPercentageAndAmount(Request $request){
    $total_site_cost = $request->cal_site_cost;
    $partner_percentage =  $request->partner_percentage;
    $partner_amount = $request->partner_amount;
    $partner = array("amount"=>$partner_amount,"percentage"=>$partner_percentage);
    if($partner_percentage!='' && $total_site_cost!=''){
      $partner['amount'] = $this->getPartnerAmount($request);
    }else if($total_site_cost!='' && $partner_amount!=''){
      $partner['percentage'] = $this->getPartnerPercentage($request);
    }
    echo json_encode($partner);
    exit;
  }
  
  public function getPartnerAmount(Request $request){
    $total_site_cost = $request->cal_site_cost;
    $partner_percentage =  $request->partner_percentage;
    $per = $partner_percentage/100;
    $total_value = ($per*$total_site_cost);
    echo $total_value;
    exit;
  }
  
  public function getPartnerPercentage(Request $request){
    $total_site_cost = $request->cal_site_cost;
    $partner_amount =  $request->partner_amount;
    $per = '';
    if($total_site_cost > 0){
      $val = ($partner_amount/$total_site_cost)*100;
      $per = round($val);
    }
    echo $per;
    exit;
  }
  
  public function partnerPayment(Request $request,$partner_id){
    $partner = Partners::leftJoin('sites', 'sites.site_id', '=', 'partners.site_id')
            ->where('partners.partner_id',$partner_id)
            ->first();
    $payment_mode = PaymentMode::all();
    if ($partner) {
      $partner_payment_amount = PartnerPayment::where('partner_id', $partner_id)->sum('partner_payment_amount');
      $balance_amount = $partner->partner_amount;
      if($partner_payment_amount){
        $balance_amount = $partner->partner_amount - $partner_payment_amount;
      } 
      $partner_payments = PartnerPayment::where('partner_id', $partner_id)->orderBy('partner_payment_date',"desc")->get(); 
      $data = [
          'partner'=>$partner,
          'payment_mode'=>$payment_mode,
          'balance_amount'=>$balance_amount,
          'partner_payments'=>$partner_payments
      ];
      return view('partners/partner_payment',$data);
    }
    
    
  }
  
  public function getPaymentmode(Request $request){
    $payment_mode = $request->payment_mode;
    $data = [
        'payment_mode' =>$payment_mode
    ];
    echo view('/partners/payment_mode',$data);
    exit;
  }
  public function updatePartnerPayment(Request $request){
    
    $payment = new PartnerPayment();
    $payment->partner_id = $request->partner_id;
    $payment->partner_payment_mode = $request->payment_mode;
    $payment->partner_payment_amount = $request->payment_amount;
    $payment->partner_payment_date = $this->dateFormat($request->payment_date);
    if($request->payment_mode=="2"){
      $payment->partner_payment_bank = (isset($request->bank_name)==true)?$request->bank_name:"";
      $payment->partner_payment_cheque_number = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $payment->partner_payment_cheque_date = $this->dateFormat($request->cheque_date);
    }
    if($request->payment_mode=="3"){
      $payment->partner_payment_transaction_id = $request->transaction_id;
    }
    $payment->save();
    return back()->with('success',"Partner Payment updated."); 
  }
}
