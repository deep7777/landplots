@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/purchaseorders/create')}}">Create Purchase Order</a>
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
                @foreach($purchase_orders as $po)
                  <tr>
                    <td>{{$po->po_number}}</td>
                    <td>{{$po->site_name}}</td>
                    <td>{{$po->supplier_name}}</td>
                    <td>{{$po->supplier_contact_person}}</td>
                    <td>{{$po->supplier_contact_person_no}}</td>
                    <td>
                      <a href="{{url('/purchaseorders/'.$po->po_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/purchaseorders/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$po->po_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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