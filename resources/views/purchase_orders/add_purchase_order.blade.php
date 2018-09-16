@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Purchase Order</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/purchaseorders')}}">Back</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action ="{{url('/purchaseorders')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-xs-12">
              <div class="form-group col-xs-12">
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_number">
                 Purchase Order Number
                </label>
                <input readonly required="" id="po_number" name="po_number"  value="{{$po_no}}"  class="form-control clear-all"  type="text" />
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_site_id">
                 Site Name
                </label>
                <select id="po_site_id" name="po_site_id" class="form-control" required="">
                  <option value="">Choose Site</option>
                  @foreach($site_list as $site)
                  <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
                  @endforeach
                </select>
                </div>
                <div class="form-group col-md-3">
                 <label class="control-label requiredField" for="supplier_mobile_no">
                  Purchase Order Date
                 </label>
                  <input id="po_date" name="po_date" required="" value="" class="form-control date_class"  type="text" onkeydown="return false;"/>
                </div>
                <div class="form-group col-md-3">
                 <label class="control-label requiredField" for="po_prepared_by">
                  Purchase Order Created By
                 </label>
                  <input id="po_prepared_by" name="po_prepared_by" required="" value="" class="form-control"  type="text"/>
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
                  <option value="{{$supplier->supplier_id}}">{{ $supplier->supplier_name }}</option>
                  @endforeach
                </select>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="po_contact_person">
                 Supplier Contact Person
                </label>
                <input id="po_contact_person" name="po_contact_person" value="" class="form-control"  type="text"/>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="supplier_email">
                 Supplier Email Id
                </label>
                <input id="po_email" name="po_email"  value=""  class="form-control"  type="email"/>
                </div>
                <div class="form-group col-md-3">
                <label class="control-label requiredField" for="supplier_cst">
                 Supplier Mobile Number
                </label>
                <input   id="po_mobile" name="po_mobile" value="" class="form-control "  type="text"/>
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
              <input required="" id="po_contact_person" name="po_contact_person"  value=""  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_site_mobile">
               Site Mobile 
              </label>
              <input required="" id="po_site_mobile" name="po_site_mobile"  value=""  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_credit_days">
              Credit Days
              </label>
              <input type="number" required="" id="po_credit_days" name="po_credit_days"  value=""  class="form-control  "/> 
              </div>
              <div class="form-group col-md-3">
              <label class="control-label requiredField" for="po_required_by_date">
              Required By Date
              </label>
              <input required="" id="po_required_by_date" name="po_required_by_date"  value=""  class="form-control date_class" onkeydown="return false"/> 
              </div>
              </div>
              <div class="form-group col-xs-12">
                <div class="form-group col-md-6">
                   <label class="control-label requiredField" for="po_billing_address">
                    Billing Address
                   </label>
                   <textarea required="" class="form-control" cols="40" id="po_billing_address" name="po_billing_address" rows="4">{{$company->address}}</textarea>
                  </div>
                <div class="form-group col-md-6">
                  <label class="control-label requiredField" for="po_delivery_address">
                   Delivery Address
                  </label>
                  <textarea required="" class="form-control" cols="40" id="po_delivery_address" name="po_delivery_address" rows="4"></textarea>
                 </div>
              </div>
              </div>
              </div>
          <div class="clearfix col-xs-12"></div>
          <div class="pull-right">
          <button class="btn btn-primary">Submit</button>
          </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</div>  
@endsection