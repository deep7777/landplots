@extends('layouts.main')
@section('content')
<form id="frm_payment_reminder" class="form-horizontal form-label-left">
{{ csrf_field() }}
<div class="row">
  <div class="x_title ">
    <span class="red">Plot Payment Reminders : </span>
    <div class="pull-right">
    <a type="button" class="btn btn-info btn-sm go-back" href="http://localhost:9050/">Back</a>
    <div class="clearfix"></div>
  </div>
    <div class="clearfix"></div>
  </div>

  <div class="form-group col-xs-4">
      <div class="form-group">
      <label class="control-label requiredField" for="site_id">
       Select Site
      </label>
      <select id="site_id" name="site_id"  class="form-control get_site_plot_payment_reminder" required="">
        <option value="">All Sites</option>
        @foreach($site_list as $site)
        <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @endforeach
      </select>
      </div>
  </div>
  <div class="form-group col-md-4">
    <label class="control-label requiredField" for="month">
     Month
    </label>
    <input id="month" value="{{date('m/Y')}}" name="month" class="form-control month-picker"  onkeydown="return false">
  </div>
  <div class="form-group col-xs-12">
    <button id="get_payment_reminder_report" type="button" class="btn btn-success btn-large">Get Report</button>
    <button id="get_payment_reminder_report_reset" type="button" class="btn btn-info btn-large reset">Reset</button>
  </div>
</div>  
<div class="x_content">
  <div class="clearfix"></div>
  <div class="row">
      <div class="col-sm-12 payment_reminder_report_data">
      </div>
    </div>
</div>
</form>  
@endsection