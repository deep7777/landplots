<form action ="{{url('/createPlot')}}" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Site <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <select name="site_id" class="form-control" required="">
        <option value="">Choose Site</option>
        @foreach($site_list as $site)
        @if(($site_id== $site->site_id && count($errors) > 0)|| ($site_id == $site->site_id))
        <option selected=selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @else
        <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @endif
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group" style="padding:6px;"></div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plot_no">For Multiple Plots
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12 ">
      <input name="plotNumberSlider-enabled" id="plotNumberSlider-enabled" type="checkbox" value="1" /><strong class=""> Enable checkbox </strong>
      <b>1</b> <input name="plotNumberSlider" id="plotNumberSlider" type="text" class="span2" value="" data-slider-enabled="false" data-slider-min="1" data-slider-max="1000" data-slider-step="1" data-slider-value="[150,450]" /> <b>1000</b>    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plot_no">Plot Number<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input placeholder="Plot No"  type="text" id="plot_no" name="plot_no" required="required" class="form-control col-md-7 col-xs-12">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Area
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input placeholder="Area in sqft" id="plot_area" value="{{ old('plot_area') }}" type="text" name="plot_area" class="form-control col-md-7 col-xs-12 area">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plot_rate_per_sqft">Rate/Sqft
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input value="{{ old('plot_rate_per_sqft') }}" type="text" id="plot_rate_per_sqft" name="plot_rate_per_sqft" class="form-control col-md-7 col-xs-12 rate_per_sqft">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plot_cost">Cost
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input id="plot_cost" value="{{ old('plot_cost') }}" type="text" name="plot_cost"  class="form-control col-md-7 col-xs-12 total_cost">
    </div>
  </div>
  <div class="ln_solid"></div>
  <div class="form-group">
    <div class="col-md-9 text-right">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</form>