<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="name">Site <span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-3 col-xs-3">
    <select name="site_id" class="form-control" required="">
      <option value="">Choose Site</option>
      @foreach($site_list as $site)
      <option value="{{$site->id}}">{{ $site->name }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="name">Plot Name <span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-3 col-xs-3">
    <input placeholder="Name" value="{{ old('name') }}" type="text" id="name" name="name" required="required" class="form-control col-xs-3">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="name">Plot Number <span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-3 col-xs-3">
    <input value="{{ old('plot_no') }}" type="plot_no" id="plot_no" name="plot_no" required="required" class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="area">Area
  </label>
  <div class="col-md-6 col-sm-3 col-xs-3">
    <input value="{{ old('area') }}" type="text" id="area" name="area" class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="district">District
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input value="{{ old('mobile_no') }}" type="text" id="district" name="district" class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="taluka">Taluka
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input value="{{ old('telephone_no') }}" type="text" id="taluka"  name="taluka"  class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="ri">RI
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input value="{{ old('district') }}" type="text"  id="ri" name="ri"  class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="last-name">Village
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input  value="{{ old('village') }}" type="text" id="village" name="village"  class="form-control col-md-7 col-xs-12" >
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="rate">Rate
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input value="{{ old('area') }}" type="text" name="rate"  class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="pincode">Pincode
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input value="{{ old('pincode') }}" type="text" name="pincode"  class="form-control col-md-7 col-xs-12">
  </div>
</div>
<div class="col-sm-5 col-md-6 form-group">
  <label class="control-label col-md-4 col-sm-3 col-xs-3" for="address" >Address
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <textarea name="address" id="address" class="form-control"  data-parsley-trigger="keyup"  data-parsley-maxlength="300" >{{ old('address') }}</textarea>
  </div>
</div>
<div class="ln_solid"></div>
<div class="col-sm-5 col-md-6 form-group">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <button type="submit" class="btn btn-success">Submit</button>
  </div>
</div>