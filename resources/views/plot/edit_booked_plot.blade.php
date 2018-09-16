@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_book_plot" action ="{{url('/updateBookedPlot')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input type="hidden" name="plot_booking_id" value="{{$booked_plot->plot_booking_id}}">
<input type="hidden" name="plot_payment_id" value="{{$plot_booking_payment->plot_payment_id}}">
<input type="hidden" name="owner_id" value="{{$booking_owner->owner_id}}">
<input type="hidden" name="site_id" value="{{$booked_plot->site_id}}">

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Book Plot</h2> &nbsp;
        <div class="pull-right"><a id="go_back" type="button" class="btn-sm btn-primary" href="{{url('/listPlot')}}">Back</a></div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_name">
           Site Name
          </label>
          <input name="site_name" value="{{ $booked_plot->site_name}}" readonly="readonly" class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="agent_name">
           Plot Number
          </label>
          <input name="plot_no" readonly="readonly" value="{{ $plot_no }}"  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
           <label class="control-label requiredField" for="plot_area">
            Plot Area (sqft)
           </label>
           <input name="plot_booking_area" readonly="readonly" value="{{$booked_plot->plot_booking_area}}" class="form-control"  type="text"/>
          </div>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Customer Details</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="site_name">
           First Name
          </label>
          <input required="" id="first_name" name="first_name" value="{{$booking_owner->owner_first_name}}" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="middle_name">
           Middle Name
          </label>
          <input id="middle_name" name="middle_name"  value="{{$booking_owner->owner_middle_name}}"  class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label" for="last_name">
            Last Name
           </label>
            <input id="last_name" name="last_name"  value="{{$booking_owner->owner_last_name}}" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="mobile_no">
           Mobile Number
          </label>
          <input required="" id="mobile_no" name="mobile_no" required="" value="{{$booking_owner->owner_mobile_no}}"  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="payment_date">
           Plot Booking Date
           </label>
          <input value="{{dmy($booked_plot->plot_booking_date)}}" name="plot_booking_date" required=""  class="form-control yellow date_class"  type="text" onkeydown="return false;" />
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="account_no">
            Email Id
           </label>
           <input type="email" id="email" name="email"  value="{{$booking_owner->owner_email}}"  class="form-control clear-all"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="address">
           Customer Address
          </label>
          <textarea name="address" id="address" class="form-control clear-all"  data-parsley-trigger="keyup"  data-parsley-maxlength="300">{{$booking_owner->owner_address}}</textarea>
          </div>
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="plot_address">
           Plot Address
          </label>
          <textarea name="plot_address" id="plot_address" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ $booked_plot->site_address}}</textarea>
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
          <input id="plot_area" name="plot_area" value="{{ $booked_plot->plot_booking_area}}" class="form-control plot_area total_cost"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="plot_rate">
           Rate
          </label>
          <input required="" data-parsley-pattern="[0-9]*(\.?[0-9]*$)?"  data-parsley-error-message="Not a valid number" id="plot_rate" name="plot_rate" value="{{$booked_plot->plot_booking_rate_per_sqft}}" class="form-control total_cost"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="plot_total_cost">
            Total Cost
           </label>
            <input style="background-color: yellow" id="plot_total_cost" name="plot_total_cost" required="" value="{{$booked_plot->plot_booking_cost}}" class="form-control total_cost"  type="text"/>
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
          <input required=""  id="down_payment_amount" name="down_payment_amount" value="{{$plot_booking_payment->plot_payment_amount}}" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3">
           <label class="control-label requiredField" for="payment_date">
           Down Payment Date
           </label>
            <input value="{{dmy($plot_booking_payment->plot_payment_date)}}" id="payment_date" name="payment_date" required=""  class="form-control date_class"  type="text" onkeydown="return false;"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="balance_amount">
          Balance Amount
          </label>
          <input value="{{$balance_amount}}" id="balance_amount" name="balance_amount" required="" value=""  class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="plot_next_payment_due_date">
          Next Payment Date
          </label>
          <input id="plot_next_payment_due_date" name="plot_next_payment_due_date" value="{{dmy($booked_plot->next_payment_date)}}"  class="form-control date_class"  type="text" onkeydown="return false;" />
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
             Select Payment Mode
            </label>
            <select id="payment_mode" name="payment_mode" class="form-control">
              <option value="">Select Payment Mode</option>
              @foreach($payment_mode as $payment)
              @if($plot_booking_payment->plot_payment_mode == $payment["id"])
              <option selected="selected" value="{{$payment['id']}}">{{ ucwords($payment['name']) }}</option>
              @else
              <option value="{{$payment['id']}}">{{ ucwords($payment['name']) }}</option>
              @endif
              @endforeach
            </select>
          </div>
          @if($plot_booking_payment->plot_payment_mode == "2")
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_number">
          Cheque Number
          </label>
          <input required="" id="cheque_number" name="cheque_number" value="{{$plot_booking_payment->plot_payment_cheque_number}}" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_date">
          Cheque Date
          </label>
          <input required="" id="cheque_date" name="cheque_date"  value="{{dmy($plot_booking_payment->plot_payment_cheque_date)}}"  class="form-control date_class"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
           <label class="control-label requiredField" for="bank_name">
           Bank Name
           </label>
            <input required=""  id="bank_name" name="bank_name"  class="form-control"  value="{{$plot_booking_payment->plot_payment_bank}}" type="text"/>
          </div>
          @endif
          @if($plot_booking_payment->plot_payment_mode == "3")
          <div class="form-group col-md-3 transaction payment_option_fields">
           <label class="control-label requiredField" for="payment_date">
           Transaction ID
           </label>
            <input value="{{$plot_booking_payment->plot_payment_transaction_id}}" id="transaction_id" name="transaction_id" required=""  class="form-control"  type="text"/>
          </div>
          @endif
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        @include("plot/edit_booked_plot_installments")
      </div>
    </div>
    
  </div>
  
</div>
</form>
@endsection