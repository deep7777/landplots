@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/employees/create')}}">Add Employee</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-table-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Mobile Number</th>
                  <th>Salary</th>
                  <th>Joining Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $employee)
                  <tr>
                    <td>{{$employee->emp_first_name." ".$employee->emp_last_name}}</td>
                    <td>{{$employee->emp_mobile_no}}</td>
                    <td>{{$employee->emp_salary}}</td>
                    <td>{{dmy($employee->emp_joining_date)}}</td>
                    <td>
                      <a href="{{url('/employees/'.$employee->emp_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/employees/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$employee->emp_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection