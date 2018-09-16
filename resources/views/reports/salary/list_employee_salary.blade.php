@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <span>Salary : </span>
      <div class="clearfix"></div>
    </div>
    <div class="x_content blue">
      <form id="frm_employee_salary_report">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_id">
          Select Employee
          </label>
          <select id="emp_id" name="emp_id" class="form-control" required="">
            <option value="">All Employees</option>
            @foreach($employees as $employee)
            <option value="{{$employee->emp_id}}">{{ $employee->emp_first_name." ".$employee->emp_last_name }}</option>
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
      </div>
      <div class="form-group col-md-3 row">
          <button id="employee_salary_report" type="button" class="btn btn-success btn-large">Get Report</button>
          <button id="employee_salary_report_reset" type="button" class="btn btn-info btn-large reset">Reset</button>
        </div>
      <div class="col-sm-12 employee_salary_report_data">
          
      </div>
      
      </form>  
    </div>
  </div>
</div>
</div>  
@endsection