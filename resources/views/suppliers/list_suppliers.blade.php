@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/suppliers/create')}}">Add Supplier</a>
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
                  <th>Supplier Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Contact Person</th>
                  <th>Contact Person No</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($suppliers as $supplier)
                  <tr>
                    <td>{{$supplier->supplier_name}}</td>
                    <td>{{$supplier->supplier_mobile_no}}</td>
                    <td>{{$supplier->supplier_email}}</td>
                    <td>{{$supplier->supplier_contact_person}}</td>
                    <td>{{$supplier->supplier_contact_person_no}}</td>
                    <td>
                      <a href="{{url('/suppliers/'.$supplier->supplier_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/suppliers/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$supplier->supplier_id}}" class="delSupplier btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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