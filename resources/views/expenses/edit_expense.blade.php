@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Company Expense</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/expenses')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_expense"  method="POST" action ="{{url('/expenses/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$expense->expense_id}}" name="expense_id">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_name">
           Purpose/Work
          </label>
          <input required="" id="expense_name" name="expense_name" value="{{$expense->expense_name}}" class="form-control "  type="text"/>
          </div>
           <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_given_to">
          Amount Given To
          </label>
          <input required="" id="expense_given_to" name="expense_given_to" value="{{$expense->expense_given_to}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_date">
          Date
          </label>
            <input required="" id="expense_date" name="expense_date" value="{{dmy($expense->expense_date)}}" class="form-control date_class" type="text" onkeydown="return false;"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
         <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_bill_no">
          Bill No
          </label>
            <input id="expense_bill_no" name="expense_bill_no" value="{{$expense->expense_bill_no}}" class="form-control" type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_amount">
           Amount
          </label>
          <input required="" id="expense_amount" name="expense_amount" value="{{$expense->expense_amount}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_desc">
          Description
          </label>
          <input required="" id="expense_desc" name="expense_desc" value="{{$expense->expense_desc}}" class="form-control "  type="text"/>
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
              @if($payment->payment_mode_id == $expense->expense_payment_mode)
              <option selected value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @else
              <option value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @endif
              @endforeach
            </select>
          </div>
          @if($expense->expense_payment_mode == "2")
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_number">
          Cheque Number
          </label>
          <input required=""   id="cheque_number" name="cheque_number" value="{{$expense->expense_cheque_no}}" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_date">
          Cheque Date
          </label>
          <input required="" id="cheque_date" name="cheque_date"  value="{{dmy($expense->expense_cheque_date)}}"  class="form-control date_class"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
           <label class="control-label requiredField" for="bank_name">
           Bank Name
           </label>
            <input required="" value="{{$expense->expense_bank_name}}"  id="bank_name" name="bank_name"  class="form-control"  type="text"/>
          </div>
          @endif
          @if($expense->expense_payment_mode == "3")
          <div class="form-group col-md-3 transaction payment_option_fields">
           <label class="control-label requiredField" for="payment_date">
           Transaction ID
           </label>
            <input value="{{$expense->expense_transaction_id}}" id="transaction_id" name="transaction_id" required=""  class="form-control"  type="text"/>
          </div>
          @endif
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