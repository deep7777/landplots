@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Supplier</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/suppliers')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="frm_partner" action ="{{url('/suppliers')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-xs-12">
              <div class="form-group col-xs-12">
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_name">
                 Supplier Name
                </label>
                <input required="" id="supplier_name" name="supplier_name" value="" class="form-control clear-all"  type="text"/>
                </div>
                <div class="form-group col-md-4">
                 <label class="control-label requiredField" for="supplier_mobile_no">
                  Supplier Mobile Number
                 </label>
                  <input id="supplier_mobile_no" name="supplier_mobile_no" required="" value="" class="form-control clear-all"  type="text"/>
                </div>
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_contact_person">
                 Contact Person
                </label>
                <input id="supplier_contact_person" name="supplier_contact_person"  value=""  class="form-control clear-all"  type="text"/>
                </div>
              </div>
              <div class="form-group col-xs-12">
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_contact_person_no">
                 Contact Person Phone
                </label>
                <input  id="supplier_contact_person_no" name="supplier_contact_person_no" value="" class="form-control clear-all"  type="text"/>
                </div>
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_email">
                 Email Id
                </label>
                <input id="supplier_email" name="supplier_email"  value=""  class="form-control clear-all"  type="email"/>
                </div>
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_pincode">
                 Pincode
                </label>
                <input required=""  id="supplier_pincode" name="supplier_pincode" value="" class="form-control blue clear-all"  type="text"/>
                </div>
              </div>
              <div class="form-group col-xs-12">
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_cst">
                 CST
                </label>
                <input   id="supplier_cst" name="supplier_cst" value="" class="form-control blue clear-all"  type="text"/>
                </div>
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_pan">
                 PAN
                </label>
                <input id="supplier_pan" name="supplier_pan"  value=""  class="form-control blue"/> 
                </div>
                <div class="form-group col-md-4">
                <label class="control-label requiredField" for="supplier_vat">
                 VAT
                </label>
                <input id="supplier_vat" name="supplier_vat"  value=""  class="form-control blue"/>
                </div>
              </div>
              <div class="form-group col-xs-12">
              <div class="form-group col-md-4">
              <label class="control-label requiredField" for="supplier_service_tax_no">
               Service Tax No
              </label>
              <input id="supplier_service_tax_no" name="supplier_service_tax_no"  value=""  class="form-control blue clear-all"/> 
              </div>
              <div class="form-group col-md-4">
                 <label class="control-label requiredField" for="supplier_address">
                  Address
                 </label>
                 <textarea required="" class="form-control" cols="40" id="supplier_address" name="supplier_address" rows="4"></textarea>
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
@endsection