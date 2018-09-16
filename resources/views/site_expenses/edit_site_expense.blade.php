@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Site Expense</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/siteexpenses')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_site_expense"  method="POST" action ="{{url('/siteexpenses/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$site_expense->site_expense_id}}" name="site_expense_id">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
            <label class="control-label requiredField" for="expense_name">
            Site
            </label>
            <select name="site_id" class="form-control" required="">
              <option value="">Choose Site</option>
              @foreach($site_list as $site)
              @if($site_expense->site_id== $site->site_id)
              <option selected=selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
              @else
              <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="site_expense_given_to">
          Amount Given To
          </label>
          <input required="" id="site_expense_given_to" name="site_expense_given_to" value="{{$site_expense->site_expense_given_to}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_date">
          Date
          </label>
            <input required="" id="expense_date" name="expense_date" value="{{dmy($site_expense->site_expense_date)}}" class="form-control date_class" type="text" onkeydown="return false;"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="site_expense_bill_no">
          Bill No
          </label>
          <input id="site_expense_bill_no" name="site_expense_bill_no" value="{{$site_expense->site_expense_bill_no}}" class="form-control" type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_name">
           Purpose/Work
          </label>
          <input required="" id="expense_name" name="expense_name" value="{{$site_expense->site_expense_name}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_amount">
           Amount
          </label>
          <input required="" id="expense_amount" name="expense_amount" value="{{$site_expense->site_expense_amount}}" class="form-control "  type="text"/>
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
              @if($payment->payment_mode_id == $site_expense->site_expense_payment_mode)
              <option selected value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @else
              <option value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @endif
              @endforeach
            </select>
          </div>
          @if($site_expense->site_expense_payment_mode == "2")
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_number">
          Cheque Number
          </label>
          <input required=""   id="cheque_number" name="cheque_number" value="{{$site_expense->site_expense_cheque_no}}" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_date">
          Cheque Date
          </label>
          <input required="" id="cheque_date" name="cheque_date"  value="{{dmy($site_expense->site_expense_cheque_date)}}"  class="form-control date_class"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
           <label class="control-label requiredField" for="bank_name">
           Bank Name
           </label>
            <input required="" value="{{$site_expense->site_expense_bank_name}}"  id="bank_name" name="bank_name"  class="form-control"  type="text"/>
          </div>
          @endif
          @if($site_expense->site_expense_payment_mode == "3")
          <div class="form-group col-md-3 transaction payment_option_fields">
           <label class="control-label requiredField" for="payment_date">
           Transaction ID
           </label>
            <input value="{{$site_expense->site_expense_transaction_id}}" id="transaction_id" name="transaction_id" required=""  class="form-control"  type="text"/>
          </div>
          @endif
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_desc">
          Description
          </label>
          <textarea  class="form-control" cols="40" id="expense_desc" name="expense_desc" rows="2">{{$site_expense->site_expense_desc}}</textarea>  
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
@endsection