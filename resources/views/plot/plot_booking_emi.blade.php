@extends('layouts.main')
@section('content')
<div class="form-group col-xs-12">
  <div class="x_title">
    <div class="alert alert-info text-center">EMI calculated on the basis of Balance Amount to be paid.</div>    
    <div class="row col-xs-12">
    	<div class="col-md-6">
	    	<div class="blue">{{ getOwnerNAme($booking_owner)}} : Site => {{ $booked_plot->site_name}} , Plot No => {{$plot_no}} </div>
	    </div>
	    <div class="col-md-6">
	    	<div class="pull-right"><a id="go_back_emi" type="button" class="btn-sm btn-primary">Back</a></div>
	    </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<form id="frm_booking_emi" action ="{{url('/salePlot')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input id="plot_emi_taken" name="plot_emi_taken"  value="1"  class="form-control"  type="hidden"/>
<input id="plot_emi_taken" name="plot_booking_id"  value="{{$booked_plot->plot_booking_id}}"  class="form-control"  type="hidden"/>
<div class="form-group col-xs-12">
	<div class="form-group col-md-3">
	  <label class="control-label requiredField" for="balance_amount">
	  Balance Amount
	  </label>
	  <input  id="balance_amount" name="balance_amount" required="" value="{{$balance_amount}}"  class="form-control yellow"  type="text"/>
	</div>
	<div class="form-group col-md-3">
	  <label class="control-label requiredField" for="booking_amount">
	  Booking  Amount
	  </label>
	  <input  id="booking_amount" name="booking_amount" required="" value="{{$booked_plot->plot_booking_cost}}"  class="form-control"  type="text"/>
	</div>
</div>
<div class="form-group col-xs-12">
  <div class="form-group col-md-3">  
  <label class="control-label requiredField" for="emi_date">
  EMI Starting Date
  </label>
  <input id="plot_emi_start_date" name="plot_emi_start_date" value="" class="form-control date_class"  type="text" onkeydown="return false;"/>
  </div>
  <div class="form-group col-md-3">
  <label class="control-label requiredField" for="plot_rate">
  Number of EMI Installments
  </label>
  <input data-parsley-type="number" id="plot_emi_installments" name="plot_emi_installments" value="" class="form-control"  type="text"/>
  </div>
  <div class="form-group col-md-3">
    <label class="control-label requiredField" for="">&nbsp;</label>
    <button type="button" id="btn_emi" name="btn_emi" class="form-control btn btn-success">GET EMI SCHEDULE</button>
  </div>
</div>
<div class="emi_installments">
	@include("plot/edit_booked_plot_installments")
</div>
@endsection
