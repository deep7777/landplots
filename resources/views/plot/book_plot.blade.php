@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_book_plot" action ="{{url('/salePlot')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input type="hidden" name="site_id" value="{{$plot->site_id}}">
<input type="hidden" name="plot_id" value="{{$plot->plot_id}}">
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Book Plot => {{ $plot->site_name." / ".$plot->plot_no}}</h2> &nbsp;
        <div class="pull-right"><a id="go_back" type="button" class="btn-sm btn-primary" href="{{url('/listPlot')}}">Back</a></div>
        <div class="clearfix col-xs-12"></div>
      </div>
      <div class="x_content">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="book_site_plot">
           Select Visitor
          </label>
          <select id="visitor_id" name="visitor_id" class="form-control">
            <option value="">Select Customer</option>
            @foreach($visitors as $visitor)
            <option value="{{$visitor->id}}">{{ getVisitorName($visitor) }}</option>
            @endforeach
          </select>
          </div>
          <div class="form-group col-md-6 site_plots">
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="site_name">
           First Name
          </label>
          <input required="" id="first_name" name="first_name" value="" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="middle_name">
           Middle Name
          </label>
          <input id="middle_name" name="middle_name"  value=""  class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label" for="last_name">
            Last Name
           </label>
            <input id="last_name" name="last_name" value="" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="mobile_no">
           Mobile Number
          </label>
          <input required="" id="mobile_no" name="mobile_no" required="" value=""  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="payment_date">
           Plot Booking Date
           </label>
            <input id="plot_booking_date" name="plot_booking_date" required=""  class="form-control yellow date_class"  type="text" onkeydown="return false;" />
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="account_no">
            Email Id
           </label>
           <input type="email" id="email" name="email"  value=""  class="form-control clear-all"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="address">
           Customer Address
          </label>
          <textarea name="address" id="address" class="form-control clear-all"  data-parsley-trigger="keyup"  data-parsley-maxlength="300"></textarea>
          </div>
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="address">
           Plot Address
          </label>
          <textarea name="address" id="address" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ $plot->site_address}}</textarea>
          </div>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Plot Cost</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="plot_area">
          Plot Area (sqft)
          </label>
          <input id="plot_area" name="plot_area" value="{{ $plot->plot_area}}" class="form-control plot_area"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="plot_rate">
           Rate
          </label>
          <input required="" data-parsley-type="number" id="plot_rate" name="plot_rate" value="{{ $plot->plot_rate_per_sqft}}" class="form-control  total_cost"  type="text" />
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="plot_total_cost">
            Total Cost
           </label>
            <input required="" id="plot_total_cost" name="plot_total_cost"  value="{{$plot->plot_cost}}" class="form-control yellow total_cost"  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Payment</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="down_payment_amount">
          Down Payment Amount
          </label>
          <input required=""  id="down_payment_amount" name="down_payment_amount" value="" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3">
           <label class="control-label requiredField" for="payment_date">
           Down Payment Date
           </label>
            <input id="payment_date" name="payment_date" required=""  class="form-control date_class"  type="text" onkeydown="return false;"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="balance_amount">
          Balance Amount
          </label>
          <input  id="balance_amount" name="balance_amount" required="" value=""  class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="plot_next_payment_due_date">
          Next Payment Date
          </label>
          <input id="plot_next_payment_due_date" name="plot_next_payment_due_date" value=""  class="form-control date_class"  type="text" onkeydown="return false;" />
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Payment Mode</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3 payment_mode_fields">
            <label class="control-label requiredField" for="book_site_plot">
            Payment Mode
            </label>
            <select id="payment_mode" name="payment_mode" class="form-control">
              @foreach($payment_mode as $payment)
              <option value="{{$payment['id']}}">{{ ucwords($payment['name']) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        @include("plot/emi")
        <div class="clearfix col-xs-12"></div>
        <div class="pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection