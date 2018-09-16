@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_partner" action ="{{url('/updateSitePartner')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
{{ csrf_field() }}
<input type="hidden" name="id" value="{{$partner->partner_id}}">
<input type="hidden" name="site_id" value="{{$partner->site_id}}">
<input type="hidden" name="cal_site_cost" value="{{$total_site_cost}}">

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="form-group col-xs-12">
        <div class="x_title">
          <span>Edit Partner</span>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="form-group col-xs-12">
      <div class="x_content">
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_name">
           Site Name
          </label>
          <input name="site_name" value="{{ $site->site_name}}" readonly="readonly" class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_name">
           Site Cost
          </label>
          <input name="site_cost" value="{{ get_money_indian_format($site->site_cost)}}" readonly="readonly" class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_name">
           Site Contract Amount
          </label>
          <input name="site_contractor_amount" value="{{ get_money_indian_format($site_contractor_amount)}}" readonly="readonly" class="form-control"  type="text"/>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label requiredField" for="total_site_cost">
           Total Site Cost
          </label>
          <input name="total_site_cost" value="{{ get_money_indian_format($total_site_cost)}}" readonly="readonly" class="form-control"  type="text"/>
          </div>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Partner Contact Information</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="site_name">
           First Name
          </label>
          <input required="" id="partner_first_name" name="partner_first_name" value="{{$partner->partner_first_name}}" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="middle_name">
           Middle Name
          </label>
          <input id="partner_middle_name" name="partner_middle_name"  value="{{$partner->partner_middle_name}}"  class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-4">
           <label class="control-label requiredField" for="last_name">
            Last Name
           </label>
            <input id="partner_last_name" name="partner_last_name" required="" value="{{$partner->partner_last_name}}" class="form-control clear-all"  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="partner_mobile_no">
           Mobile Number
          </label>
          <input required="" id="partner_mobile_no" name="partner_mobile_no" value="{{$partner->partner_mobile_no}}" class="form-control clear-all"  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="partner_email_id">
           Email Id
          </label>
          <input id="partner_email_id" name="partner_email_id"  value="{{$partner->partner_email}}"  class="form-control clear-all"  type="email"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="partner_percentage">
           Percentage
          </label>
          <input required=""  id="partner_percentage" name="partner_percentage" value="{{$partner->partner_percentage}}" class="form-control red clear-all partner_amount"  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="partner_amount">
           Amount
          </label>
          <input id="partner_amount" name="partner_amount"  value="{{$partner->partner_amount}}"  class="form-control blue clear-all partner_amount"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
        <div class="form-group col-md-4">
           <label class="control-label requiredField" for="partner_address">
            Address
           </label>
           <textarea required="" class="form-control" cols="40" id="partner_address" name="partner_address" rows="4">{{$partner->partner_address}}</textarea>
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
</form>
@endsection