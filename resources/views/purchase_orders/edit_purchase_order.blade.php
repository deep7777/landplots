@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Purchase Order</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/purchaseorders')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="frm_partner"  method="POST" action ="{{url('/purchaseorders/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$po->po_id}}" name="po_id">
        <div class="row">
            <div class="form-group col-xs-12">
              <div class="form-group col-xs-12">
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_number">
                 Purchase Order Number
                </label>
                <input readonly required="" id="po_number" name="po_number"  value="{{$po->po_number}}"  class="form-control clear-all"  type="text" />
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="supplier_name">
                 Site Name
                </label>
                <select id="po_site_id" name="po_site_id" class="form-control" required="">
                  <option value="">Choose Site</option>
                  @foreach($site_list as $site)
                  @if($site->site_id==$po->po_site_id)
                  <option selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
                  @else
                  <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
                  @endif
                  @endforeach
                </select>
                </div>
                <div class="form-group col-md-3">
                 <label class="control-label requiredField" for="po_date">
                  Purchase Order Date
                 </label>
                  <input id="po_date" name="po_date" required="" value="{{dmy($po->po_date)}}" class="form-control date_class"  type="text" onkeydown="return false;"/>
                </div>
                <div class="form-group col-md-3">
                 <label class="control-label requiredField" for="po_prepared_by">
                  Purchase Order Created By
                 </label>
                  <input id="po_prepared_by" name="po_prepared_by" required="" value="{{$po->po_prepared_by}}" class="form-control"  type="text"/>
                </div>
              </div>
              <div class="clearfix col-xs-12"></div>
              <div class="x_title blue">
                <h2>Supplier Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="form-group col-xs-12">
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_supplier_id">
                 Supplier
                </label>
                <select id="po_supplier_id" name="po_supplier_id" class="form-control" required="">
                  <option value="">Select Supplier</option>
                  @foreach($suppliers as $supplier)
                  @if($supplier->supplier_id==$po->po_supplier_id)
                  <option selected value="{{$supplier->supplier_id}}">{{ $supplier->supplier_name }}</option>
                  @else
                  <option value="{{$supplier->supplier_id}}">{{ $supplier->supplier_name }}</option>
                  @endif
                  @endforeach
                </select>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_contact_person">
                 Supplier Contact Person
                </label>
                <input readonly id="po_contact_person" name="po_contact_person" value="{{$supplier->supplier_contact_person}}" class="form-control"  type="text"/>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="supplier_email">
                 Supplier Email Id
                </label>
                <input readonly  id="po_supplier_email" name="po_supplier_email"  value="{{$supplier->supplier_email}}"  class="form-control"  type="email"/>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="supplier_cst">
                 Supplier Mobile Number
                </label>
                <input readonly  id="po_supplier_mobile" name="po_mobile" value="{{$supplier->supplier_mobile_no}}" class="form-control "  type="text"/>
                </div>
              </div>
              <div class="clearfix col-xs-12"></div>
              <div class="x_title blue">
                <h2>Order Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="form-group col-xs-12">
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_contact_person">
               Site Contact Person
              </label>
              <input required="" id="po_contact_person" name="po_contact_person"  value="{{$po->po_contact_person}}"  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_site_mobile">
               Site Mobile 
              </label>
              <input required="" id="po_site_mobile" name="po_site_mobile"  value="{{$po->po_site_mobile}}"  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_credit_days">
              Credit Days
              </label>
              <input type="number" required="" id="po_credit_days" name="po_credit_days"  value="{{$po->po_credit_days}}"  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_required_by_date">
              Required By Date
              </label>
              <input required="" id="po_required_by_date" name="po_required_by_date"  value="{{dmy($po->po_required_by_date)}}"  class="form-control date_class" onkeydown="return false"/> 
              </div>
              </div>
              <div class="form-group col-xs-12">
                <div class="form-group col-md-6">
                   <label class="control-label requiredField" for="po_billing_address">
                    Billing Address
                   </label>
                   <textarea required="" class="form-control" cols="40" id="po_billing_address" name="po_billing_address" rows="4">{{$po->po_billing_address}}</textarea>
                  </div>
                <div class="form-group col-md-6">
                  <label class="control-label requiredField" for="po_delivery_address">
                   Delivery Address
                  </label>
                  <textarea required="" class="form-control" cols="40" id="po_delivery_address" name="po_delivery_address" rows="4">{{$po->po_delivery_address}}</textarea>
                 </div>
              </div>
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