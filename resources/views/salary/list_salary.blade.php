@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/salaries/create')}}">Pay Salary</a>
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
                  <th>Salary</th>
                  <th>Date</th>
                  <th>Cheque Number</th>
                  <th>Cheque Date</th>
                  <th>Bank</th>
                  <th>Transaction Id</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($salaries as $salary)
                  <tr>
                    <td>{{$salary->emp_first_name." ".$salary->emp_last_name}}</td>
                    <td>{{$salary->salary_amount}}</td>
                    <td>{{dmy($salary->salary_paid_date)}}</td>
                    <td>{{$salary->salary_payment_cheque_number}}</td>
                    <td>{{dmy($salary->salary_payment_cheque_date)}}</td>
                    <td>{{$salary->salary_payment_bank}}</td>
                    <td>{{$salary->salary_payment_transaction_id}}</td>
                    <td>
                      <a href="{{url('/salaries/'.$salary->salary_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/salaries/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$salary->salary_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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