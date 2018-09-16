@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_partner_payment" action ="{{url('/updatePartnerPayment')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input type="hidden" name="partner_id" value="{{$partner->partner_id}}">
<input type="hidden" name="site_id" value="{{$partner->site_id}}">
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="blue">Customer Name:<div class="red"> {{ $partner->partner_first_name ."  ".$partner->partner_last_name." - ".$partner->site_name }} </div> </div> &nbsp;
        <div class="pull-right"><a id="go_back" type="button" class="btn-sm  btn-success" href="{{url('/listPartners')}}">Back</a></div>
      </div>
      <div class="x_content">
        @include('validate/success')
        <div class="clearfix col-xs-12"></div>
        <div class="clearfix col-xs-12"></div>
        
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
           <label class="control-label requiredField" for="partner_total_amount">
            Total Cost
           </label>
            <input style="background-color: yellow" id="partner_total_amount" name="partner_total_amount" required="" value="{{$partner->partner_amount}}" class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="balance_amount">
          Balance Amount
          </label>
          <input value="{{$balance_amount}}" id="balance_amount" name="balance_amount" required="" value=""  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="balance_amount">
          Payment Amount
          </label>
          <input value="" id="payment_amount" name="payment_amount" required="" value=""  class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="balance_amount">
          Payment Date
          </label>
          <input value="" id="payment_date" name="payment_date" required="" value=""  class="form-control date_class"  type="text"/>
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
      </div>
    </div>
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
              <th>Bank</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($partner_payments as $partner_payment)
              <tr>
                <td>{{dmy($partner_payment->partner_payment_date)}}</td>
                <td>{{get_money_indian_format($partner_payment->partner_payment_amount)}}</td>
                <td>{{$partner_payment->partner_payment_cheque_number}}</td>
                <td>{{$partner_payment->partner_payment_transaction_id}}</td>
                <td>{{$partner_payment->partner_payment_bank}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>
@endsection