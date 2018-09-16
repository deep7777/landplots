@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 pull-right">
  <div class="">
    @if ($count > 0)
      <a type="button" class="btn btn-success" href="{{url('/admin/'.$company->id.'/editCompany')}}"><i class="fa fa-edit m-right-xs"></i>Edit Company</a>
    @else
      <a type="button" class="btn btn-primary" href="{{url('/admin/addCompany')}}">Add Company</a>
    @endif
  </div>
</div>
</div>
@if($count > 0)
<div class="clearfix"></div>
<div class="">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ $company->name}} </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
              <!-- end of image cropping -->
              <div id="crop-avatar">
                <!-- Current avatar -->
                @if($company->logo!='')
                <img class="img-responsive avatar-view" src="{{url('/uploads/logo/'.$company->logo) }}" alt="{{$company->name}}" title="{{$company->name}}">
                @else
                <img class="img-responsive avatar-view" src="{{url('/uploads/logo/profile-default-pic.png') }}" alt="{{$company->name}}" title="{{$company->name}}">
                @endif
              </div>
              <!-- end of image cropping -->
            </div>
            <br />
            <a href="{{url('/admin/companyLogo')}}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Logo</a>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->name }}</div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->email }}</div>
              </div>
            </div>
            <div class="row ">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile No:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->mobile_no }}</div>
              </div>
            </div>
            @if($company->office_no!='')
            <div class="row">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Office No:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->office_no }}</div>
              </div>
            </div>
            @endif
            <div class="row">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pincode:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->pincode }}</div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">{{ $company->address }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection