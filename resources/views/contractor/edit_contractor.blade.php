@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Contractor</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listContractor')}}">Back</a>
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
        <form action ="{{url('/updateContractor')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$contractor->contractor_id}}" name="id">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_first_name">First Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor->contractor_first_name }}" type="text" id="contractor_first_name" name="contractor_first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_last_name">Last Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor->contractor_last_name }}" type="text" id="contractor_last_name" name="contractor_last_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_email">Email
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor->contractor_email }}" type="email" id="contractor_email" name="contractor_email"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_mobile_no">Mobile No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $contractor->contractor_mobile_no }}" type="text" id="contractor_mobile_no" name="contractor_mobile_no" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contractor_address">Address 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="contractor_address" id="contractor_address" class="form-control"  data-parsley-trigger="keyup">{{ $contractor->contractor_address }}</textarea>
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