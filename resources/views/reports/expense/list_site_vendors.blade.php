<label class="control-label requiredField" for="site_vendor">
  Vendors
</label>
<select id="site_vendor" name="site_vendor" class="form-control" required="">
  <option value="">Choose Vendor</option>
  @foreach($vendors as $vendor)
  <option value="{{$vendor->site_expense_given_to}}">{{ $vendor->site_expense_given_to }}</option>
  @endforeach
</select> 