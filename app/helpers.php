<?php

function dmy($date){
  if($date!='' && $date!=NULL && $date!="0000-00-00"){
    $date = date('d/m/Y', strtotime($date));
  }else{
    return "";
  }
  return $date;
}

function getCurrentMonthYear(){
  $my = date('m/Y'); //month year
  return $my;
}

function getCurrentDate(){
  $date = date('d/m/Y'); //current date
  return $date;
}

function getDay($i,$year_month){
  $date_str = $year_month."-".$i;
  $date = date('D', strtotime($date_str));
  return $date;
}

function getMYName($date){
  $date_str = $date."-01";
  $year_month = date('M Y', strtotime($date_str));
  return $year_month;
}

function get_money_indian_format($amount, $suffix = 1){
    if($amount!=''){
      setlocale(LC_MONETARY, 'en_IN');
      if (ctype_digit($amount) ) {
        // is whole number
        // if not required any numbers after decimal use this format
        $amount = money_format('%!.0n', $amount);
      }
      else {
        // is not whole number
        $amount = money_format('%!i', $amount);
      }
      return $amount;
    }else{
      return $amount;
    }
}

function getVisitorName($visitor){
  $str = '';
  if($visitor){
    $str = $visitor->first_name." ".$visitor->last_name;
  }
  return $str;
}

function getOwnerName($obj){
  $str = '';
  if($obj){
    $str = $obj->owner_first_name." ".$obj->owner_last_name;
  }
  return $str;
}

function required_str(){
  echo $html = '<span class="required">*</span>';
}

