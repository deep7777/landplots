@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Site</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listSite')}}">Back</a>
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
        <form action ="{{url('/updateSite')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$site->site_id}}" name="id">
                    <div class="form-group col-xs-12">
            <div class="form-group col-xs-4">  
              <label class="control-label" for="name">Name <span class="required">*</span>
              </label>
              <input value="{{ $site->site_name }}" type="text" id="site_name" name="site_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
              <label class="control-label" for="site_email">Email
              </label>
              <input value="{{ $site->site_email }}" type="email" id="site_email" name="site_email" class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_contact_person">Contact Person
            </label>
              <input id="site_contact_person" value="{{ $site->site_contact_person }}" type="text" name="site_contact_person" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-xs-4">  
              <label class="control-label" for="site_mobile_no">Mobile No
              </label>
              <input value="{{ $site->site_mobile_no }}" type="text" id="site_mobile_no" name="site_mobile_no" class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
              <label class="control-label" for="site_telephone_no">Telephone No
              </label>
              <input value="{{ $site->site_telephone_no }}" type="text" name="site_telephone_no"  class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_status_id">Project status
            </label>
            <select name="site_status_id" class="form-control">
            @foreach($site_status as $status)
            @if($status->site_status_id == $site->site_status_id)
            <option selected value="{{$status->site_status_id}}">{{ $status->site_status_name }}</option>
            @else
            <option value="{{$status->site_status_id}}">{{ $status->site_status_name }}</option>
            @endif
            @endforeach
            </select>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-xs-4">  
            <label class="control-label" for="site_plots_area">Plot Area</label>
            <input placeholder="Area in sqft" id="site_plots_area" value="{{ $site->site_plots_area }}" type="text" name="site_plots_area"  class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_road_area">Road Area</label>
            <input placeholder="Area in sqft" id="site_road_area" value="{{ $site->site_road_area }}" type="text" name="site_road_area"  class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">  
            <label class="control-label" for="site_total_plots">Total Plots</label>
              <input id="site_total_plots" value="{{ $site->site_total_plots }}" type="text" name="site_total_plots"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-xs-4">  
            <label class="control-label" for="site_mobile_no">Total Area</label>
              <input id="site_area" value="{{ $site->site_area }}" type="text" name="site_area"  class="form-control col-md-7 col-xs-12 area">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_telephone_no">Rate per Sqft</label>
              <input id="site_plot_rate_per_sqft" value="{{ $site->site_plot_rate_per_sqft }}" type="text" name="site_plot_rate_per_sqft"  class="form-control col-md-7 col-xs-12 rate_per_sqft">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_contact_person">Cost
            </label>
              <input id="site_cost" value="{{ $site->site_cost }}" type="text" name="site_cost"  class="form-control col-md-7 col-xs-12 total_cost">
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_telephone_no">Pincode</label>
              <input id="site_pincode" value="{{ $site->site_pincode }}" type="text" name="site_pincode"  class="form-control col-md-7 col-xs-12">
            </div>
            <div class="form-group col-xs-4">
            <label class="control-label" for="site_contact_person">Address
            </label>
              <textarea rows="5" name="site_address" id="site_address" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ $site->site_address }}</textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="text-right">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection