@extends('layouts.main')
@section('content')
<form id="frm_booked_plot_report" class="form-horizontal form-label-left">
{{ csrf_field() }}
<div class="row">
  <div class="x_title ">
    <span class="red">Plot Bookings : </span>
    <div class="clearfix"></div>
  </div>
  <div class="form-group col-xs-4">
      <div class="form-group">
      <label class="control-label requiredField" for="book_site_plot">
       Select Site
      </label>
      <select id="site_id" name="site_id"  class="form-control get_site_plot_bookings" required="">
        <option value="">All Sites</option>
        @foreach($site_list as $site)
        <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @endforeach
      </select>
      </div>
  </div>
  <div class="form-group col-md-4">
    <label class="control-label requiredField" for="from_date">
     From Date
    </label>
    <input id="from_date" value="" name="from_date" class="form-control date_class"  onkeydown="return false">
  </div>
  <div class="form-group col-md-4">
    <label class="control-label requiredField" for="to_date">
     To Date
    </label>
    <input id="to_date" value="" name="to_date" class="form-control date_class"  onkeydown="return false">
  </div>
  <div class="form-group col-xs-12">
    <button id="get_plot_booking_report" type="button" class="btn btn-success btn-large">Get Report</button>
    <button id="plot_booking_report_reset" type="button" class="btn btn-info btn-large reset">Reset</button>
  </div>
</div>  
<div class="x_content">
  <div class="clearfix"></div>
  <div class="row">
      <div class="col-sm-12 plot_booking_report_data">
      </div>
    </div>
</div>
</form>  
@endsection