@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Contractor Customer</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listContractorCustomer')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        @if (count($errors) > 0)
          <div class="alert alert-danger text-center">
            <div>
              @foreach ($errors->all() as $error)
                <div class="">{{ $error }}</div>
              @endforeach
            </div>
          </div>
        @endif
        <br />
        <form action ="{{url('/updateContractorCustomer')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$contractor_customer->customer_id}}" name="id">
          <input type="hidden" value="{{$contractor_customer->contractor_id}}" name="contractor_id">
          <input type="hidden" value="{{$contractor_customer->contractor_site_id}}" name="contractor_site_id">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contractor
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label  red">{{ $contractor_customer->contractor_first_name." ".$contractor_customer->contractor_last_name }}
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Site <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label green">{{ $contractor_customer->site_name }}
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_work"> Work <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor_customer->contractor_work }}" type="text" id="contractor_work" name="contractor_work" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_amount">Amount <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor_customer->contractor_amount }}" type="text" id="contractor_amount" name="contractor_amount" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_paid_amount">Paid Amount <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor_customer->contractor_paid_amount }}" type="text" id="contractor_paid_amount" name="contractor_paid_amount" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Date <span class="contractor_date">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="contractor_date"  value="{{ date('d/m/Y', strtotime($contractor_customer->contractor_date))}}" type="text" required="required" name="contractor_date"  class="form-control col-md-7 col-xs-12" onkeydown="return false">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-9 text-right">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection