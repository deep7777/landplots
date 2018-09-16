@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Pay Salary</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/salaries')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="frm_salary" action ="{{url('/salaries')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="expense_name">
           Employee
          </label>
          <select id="emp_id" name="emp_id" class="form-control" required="">
            <option value="">Choose Employee</option>
            @foreach($employees as $employee)
            <option value="{{$employee->emp_id}}">{{ $employee->emp_first_name." ".$employee->emp_last_name }}</option>
            @endforeach
          </select>  
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="expense_name">
          Salary Amount
          </label>
          <input required="" id="salary_amount" name="salary_amount" value="" class="form-control "  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-6">
          <label class="control-label requiredField" for="expense_date">
          Date
          </label>
            <input required="" id="salary_paid_date" name="salary_paid_date" value="" class="form-control date_class" type="text" onkeydown="return false;"/>
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
        <div class="form-group  col-xs-7 pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection