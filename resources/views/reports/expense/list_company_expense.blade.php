@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <span>Company Expense : </span>
      <div class="clearfix"></div>
    </div>
    <div class="x_content blue">
      <form id="frm_company_expense_report">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_id">
          Select Expense
          </label>
          <select id="expense_name" name="expense_name" class="form-control" required="">
            <option value="">All Expenses</option>
            @foreach($expenses as $expense)
            <option value="{{$expense->expense_name}}">{{ $expense->expense_name }}</option>
            @endforeach
          </select>  
        </div>
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="from_date">
           From Date
          </label>
          <input id="from_date" value="" name="from_date" class="form-control date_class"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="to_date">
           To Date
          </label>
          <input id="to_date" value="" name="to_date" class="form-control date_class"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3 vendors">
           
        </div>
      </div>
      <div class="form-group col-md-3 row">
        <button id="company_expense_report" type="button" class="btn btn-success btn-large">Get Report</button>
        <button id="company_expense_report_reset" type="button" class="btn btn-info btn-large reset">Reset</button>
      </div>
      <div class="col-sm-12 company_expense_report_data">

      </div>
      </form>  
    </div>
  </div>
</div>
</div>  
@endsection