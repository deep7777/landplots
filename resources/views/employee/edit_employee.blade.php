@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Employee</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/employees')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_employee"  method="POST" action ="{{url('/employees/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$employee->emp_id}}" name="emp_id">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_first_name">
            First Name <span> * </span>
          </label>
          <input required="" id="emp_first_name" name="emp_first_name" value="{{$employee->emp_first_name}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_last_name">
           Last Name
          </label>
          <input  id="emp_last_name" name="emp_last_name" value="{{$employee->emp_last_name}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_mobile_no">
           Mobile No
          </label>
          <input id="emp_mobile_no" name="emp_mobile_no" value="{{$employee->emp_mobile_no}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_joining_date">
           Joining Date
          </label>
          <input  id="emp_joining_date" name="emp_joining_date" value="{{dmy($employee->emp_joining_date)}}" class="form-control date_class" type="text" onkeydown="return false;"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_site_id">
           Site Name
          </label>
          <select id="emp_site_id" name="emp_site_id" class="form-control">
            <option value="">Choose Site</option>
            @foreach($site_list as $site)
            @if($site->site_id == $employee->emp_site_id)
            <option selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
            @else
            <option value="{{$site->site_id}}">{{ $site->site_name }}</option>            
            @endif
            @endforeach
          </select>  
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_work">
           Employee Work
          </label>
          <input  id="emp_work" name="emp_work" value="{{$employee->emp_work}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_salary">
           Salary
          </label>
          <input  id="emp_salary" name="emp_salary" value="{{$employee->emp_salary}}" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="emp_address">
           Address
          </label>
          <textarea  class="form-control" cols="40" id="emp_address" name="emp_address" rows="2">{{$employee->emp_address}}</textarea>
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