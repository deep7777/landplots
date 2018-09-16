@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_book_plot" action ="{{url('/updateBookedPlotPayment')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input type="hidden" name="plot_booking_id" value="{{$booked_plot->plot_booking_id}}">

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="blue">
          <span style="color:royalblue;">Customer Name : {{$owner}} &nbsp;</span>
          <span style="color:blueviolet;">Plot No : {{$plot_no}} &nbsp;</span>
          <span style="color:red;">Site : {{$site_name}}</span>
        </div> &nbsp;
        
        <div class="pull-right"><a id="go_back" type="button" class="btn-sm  btn-success" href="{{url('/listPlot')}}">Back</a></div>
      </div>
      <div class="x_content">
        @include('validate/success')
        <div class="clearfix col-xs-12"></div>
        <div class="clearfix col-xs-12"></div>
        
        <div class="form-group col-xs-12">
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="plot_total_cost">
            Total Cost
           </label>
            <input style="background-color: yellow" id="plot_total_cost" name="plot_total_cost" required="" value="{{$booked_plot->plot_booking_cost}}" class="form-control total_cost"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="balance_amount">
          Balance Amount
          </label>
          <input value="{{$balance_amount}}" id="balance_amount" name="balance_amount" required="" value=""  class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-2">
          <label class="control-label requiredField" for="balance_amount">
          Payment Amount
          </label>
          <input value="" id="plot_payment_amount" name="plot_payment_amount" required="" value=""  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-2">
           <label class="control-label requiredField" for="payment_date">
           Payment Date
           </label>
            <input value="" id="payment_date" name="payment_date" required=""  class="form-control date_class"  type="text" onkeydown="return false;"/>
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
            <select id="payment_mode" name="payment_mode" class="form-control" required="">
              <option value="">Select Payment Mode</option>
              @foreach($payment_mode as $payment)
              <option value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Payment Paid</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Payment Date</th>
                  <th>Payment Amount</th>
                  <th>Cheque Number</th>
                  <th>Transaction Id</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($plot_payments as $plot)
                  <tr>
                    <td>{{dmy($plot->plot_payment_date)}}</td>
                    <td>{{get_money_indian_format($plot->plot_payment_amount)}}</td>
                    <td>{{$plot->plot_payment_cheque_number}}</td>
                    <td>{{$plot->plot_payment_transaction_id}}</td>
                    @if($plot->plot_payment_type!="down_payment")
                    <td>Installment</td>
                    <td>
                      <a onclick="return delPlotPayment(this)" data-token="{{ csrf_token() }}" data-plot-booking-id="{{$plot->plot_booking_id}}" data-plot-payment-id="{{$plot->plot_payment_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                    </td>
                    @else
                    <td>Down Payment</td>
                    <td></td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </form>
    @include("plot/installments")  
    </div>
  </div>
</div>
</div>
@endsection