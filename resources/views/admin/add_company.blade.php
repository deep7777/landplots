@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Company</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/admin/listCompany')}}">Back</a>
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
        
        <form action ="{{url('/admin/createCompany')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('name') }}" type="text"  name="name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('email') }}" type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Mobile No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('mobile_no') }}" type="text" id="mobile_no" name="mobile_no" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Office No
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('office_no') }}" type="text" id="office_no" name="office_no"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pincode <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('pincode') }}" type="text" id="pincode" name="pincode" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="address" id="address" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ old('address') }}</textarea>
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