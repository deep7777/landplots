@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Plot</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listPlot')}}">Back</a>
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
        <form action ="{{url('/updatePlot')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" value="{{$plot->plot_id}}" name="id">
          <input type="hidden" value="{{$plot->site_id}}" name="site_id">
          <input type="hidden" value="{{$plot->plot_booked}}" name="plot_booked">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Site
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label  red">{{ $plot->site_name }}
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plot_no">Plot Number <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Plot Number" value="{{ $plot->plot_no }}" type="text" id="plot_no" name="plot_no" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Area
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="plot_area" value="{{ $plot->plot_area }}" type="text" name="plot_area" class="form-control col-md-7 col-xs-12 area">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cost">Rate/Sqft
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="plot_rate_per_sqft" value="{{ $plot->plot_rate_per_sqft }}" type="text" name="plot_rate_per_sqft"  class="form-control col-md-7 col-xs-12 rate_per_sqft">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cost">Cost
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="cost" value="{{ $plot->plot_cost }}" type="text" name="cost"  class="form-control col-md-7 col-xs-12 total_cost">
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