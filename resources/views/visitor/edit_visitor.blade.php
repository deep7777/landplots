@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Visitor</h2>
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
        <br />
        <form action ="{{url('/updateVisitor')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$visitor->id}}" name="id">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Site
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="visitor_site_id" name="visitor_site_id" class="form-control visitor_site_id">
                <option value="">Select Site</option>
                @foreach($sites_list as $site)
                @if($visitor->visitor_site_id== $site->site_id)
                <option selected="selected" value="{{ $site->site_id }}">{{ $site->site_name }}</option>
                @else
                <option value="{{ $site->site_id }}">{{ $site->site_name }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->first_name }}" type="text" id="first_name" name="first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="middle_name">Middle Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->middle_name }}" type="text" id="middle_name" name="middle_name"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->last_name }}" type="text" id="last_name" name="last_name"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Date <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="visited_on" value="{{ date('d/m/Y', strtotime($visitor->visited_on))}}" type="text" required="required" name="visited_on"  class="form-control col-md-7 col-xs-12" onkeydown="return false">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->email }}" type="email" id="email" name="email"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Media
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select  id="visitor_media_id" name="visitor_media_id" class="form-control visitor_media_id">
                <option value="">Select Media</option>
                @foreach($media_list as $media)
                @if($visitor->visitor_media_id == $media->media_id )
                <option selected=selected value="{{$media->media_id}}">{{ $media->media_name }}</option>
                @else
                <option value="{{$media->media_id}}">{{ $media->media_name }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Mobile No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->mobile_no }}" type="text" id="mobile_no" name="mobile_no" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="address" id="address"  class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ $visitor->address }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vehicle No
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $visitor->vehicle_no }}" type="text" id="vehicle_no" name="vehicle_no"  class="form-control col-md-7 col-xs-12">
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