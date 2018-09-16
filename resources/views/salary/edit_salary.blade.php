@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Employee Salary</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/salaries')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_salary"  method="POST" action ="{{url('/salaries/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$salary->salary_id}}" name="salary_id">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="name">
           Employee
          </label>
          <select id="emp_id" name="emp_id" class="form-control" required="">
            <option value="">Choose Employee</option>
            @foreach($employees as $employee)
            @if($employee->emp_id==$salary->emp_id)
            <option selected value="{{$employee->emp_id}}">{{ $employee->emp_first_name." ".$employee->emp_last_name }}</option>
            @else
            <option value="{{$employee->emp_id}}">{{ $employee->emp_first_name." ".$employee->emp_last_name }}</option>
            @endif
            @endforeach
          </select>  
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="name">
          Salary Amount
          </label>
          <input required="" id="salary_amount" name="salary_amount" value="{{$salary->salary_amount}}" class="form-control "  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="date">
          Date
          </label>
          <input required="" id="salary_paid_date" name="salary_paid_date" value="{{dmy($salary->salary_paid_date)}}" class="form-control date_class" type="text" onkeydown="return false;"/>
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
            <label class="control-label requiredField" for="payment_mode">
            Payment Mode
            </label>
            <select id="payment_mode" name="payment_mode" class="form-control">
              @foreach($payment_mode as $payment)
              @if($payment->payment_mode_id == $salary->salary_payment_mode)
              <option selected value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @else
              <option value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @endif
              @endforeach
            </select>
          </div>
          @if($salary->salary_payment_mode == "2")
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_number">
          Cheque Number
          </label>
          <input required=""   id="cheque_number" name="cheque_number" value="{{$salary->salary_payment_cheque_number}}" class="form-control down_payment"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
          <label class="control-label requiredField" for="cheque_date">
          Cheque Date
          </label>
          <input required="" id="cheque_date" name="cheque_date"  value="{{dmy($salary->salary_payment_cheque_date)}}"  class="form-control date_class"  type="text"/>
          </div>
          <div class="form-group col-md-3 payment_option_fields cheque">
           <label class="control-label requiredField" for="bank_name">
           Bank Name
           </label>
            <input required="" value="{{$salary->salary_payment_bank}}"  id="bank_name" name="bank_name"  class="form-control"  type="text"/>
          </div>
          @endif
          @if($salary->salary_payment_mode == "3")
          <div class="form-group col-md-3 transaction payment_option_fields">
           <label class="control-label requiredField" for="payment_date">
           Transaction ID
           </label>
            <input value="{{$salary->salary_payment_transaction_id}}" id="transaction_id" name="transaction_id" required=""  class="form-control"  type="text"/>
          </div>
          @endif
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="form-group  col-xs-7 pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        </div>
      </div>
  </div>
</div>
@endsection