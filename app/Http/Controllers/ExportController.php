<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Visitor;
class ExportController extends Controller
{
  public function __construct(Request $row){
    //$this->middleware('userAuth');    
  }
  
  public function index(Request $request){
    echo "Exporting File Started ...... \n";
    echo "Exporting File end ......";
    $fName = "visitors.csv";
    $file_name = public_path("exports/$fName");
    echo $file_name;
    Excel::load($file_name, function($reader) {
      $reader->each(function($row) {
        $vistior = new Visitor;
        $vistior->visitor_site_id = $row->visitor_site_id;
        $vistior->visitor_media_id = $row->visitor_media_id;
        $vistior->first_name = ucwords($row->first_name);
        $vistior->middle_name = ucwords($row->middle_name);
        $vistior->last_name = ucwords($row->last_name);
        $vistior->mobile_no = $row->mobile_no;
        $vistior->address = $row->address;
        $vistior->visited_on = $this->dateFormat($row->visited_on);
        $vistior->save();
        echo "<br>\n";
      });
    });

   
  }
  
  public function dateFormat($date){    
      if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  } 
  
  
}
