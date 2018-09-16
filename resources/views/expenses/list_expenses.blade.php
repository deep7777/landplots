@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/expenses/create')}}">Add Expense</a>
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
                  <th>Expense Name</th>
                  <th>Expense Amount</th>
                  <th>Expense Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($expenses as $expense)
                  <tr>
                    <td>{{$expense->expense_name}}</td>
                    <td>{{$expense->expense_amount}}</td>
                    <td>{{dmy($expense->expense_date)}}</td>
                    <td>
                      <a href="{{url('/expenses/'.$expense->expense_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/expenses/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$expense->expense_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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