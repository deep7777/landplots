@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Visitor</h2>
        <div class="col-md-6 col-sm-6 col-xs-12">
        </div>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listVisitor')}}">Back</a>
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
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <strong>{{ $message }}</strong>
        </div>
        @endif
        <br />
        <form action ="{{url('/createVisitor')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Site <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="visitor_site_id" class="form-control" required="">
                <option value="">Select Site</option>
                @foreach($sites_list as $site)
                @if(old('contractor_site_id')== $site->site_id && count($errors) > 0)
                <option selected=selected value="{{$site->contractor_site_id}}">{{ $site->site_name }}</option>
                @else
                <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('first_name') }}" type="text" id="first_name" name="first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="middle_name">Middle Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="" type="text" id="middle_name" name="middle_name"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('last_name') }}" type="text" id="last_name" name="last_name" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Date <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="visited_on"  value="{{ old('visited_on') }}" type="text" required="required" name="visited_on"  class="form-control col-md-7 col-xs-12" onkeydown="return false">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile_no">Mobile No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('mobile_no') }}" type="text" id="mobile_no" name="mobile_no" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Media
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="visitor_media_id" class="form-control visitor_media_id">
                <option value="">Select Media</option>
                @foreach($media_list as $media)
                @if(old('visitor_media_id')== $media->media_id && count($errors) > 0)
                <option selected=selected value="{{$media->visitor_media_id}}">{{ $media->media_name }}</option>
                @else
                <option value="{{$media->media_id}}">{{ $media->media_name }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('email') }}" type="email" id="email" name="email"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="address" id="address" class="form-control"  data-parsley-trigger="keyup" >{{ old('address') }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_no">Vehicle No
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('vehicle_no') }}" type="text" id="vehicle_no" name="vehicle_no"  class="form-control col-md-7 col-xs-12">
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