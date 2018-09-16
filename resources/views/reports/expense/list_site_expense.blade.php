@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title blue">
      <span>Site Expense : </span>
      <div class="clearfix"></div>
    </div>
    <div class="x_content blue">
      <form id="frm_site_expense_report">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="site_id">
          Select Site
          </label>
          <select id="site_id" name="site_id" class="form-control" required="">
            <option value="">All Sites</option>
            @foreach($sites as $site)
            <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
            @endforeach
          </select>  
        </div>
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="from_date">
           From Date
          </label>
          <input id="from_date" value="" name="from_date" class="form-control date_class"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3">
          <label class="control-label requiredField" for="to_date">
           To Date
          </label>
          <input id="to_date" value="" name="to_date" class="form-control date_class"  onkeydown="return false">
        </div>
        <div class="form-group col-md-3 vendors">
           
        </div>
      </div>
      <div class="form-group col-md-3 row">
        <button id="site_expense_report" type="button" class="btn btn-success btn-large">Get Report</button>
        <button id="site_expense_report_reset" type="button" class="btn btn-info btn-large reset">Reset</button>
      </div>
      <div class="col-sm-12 site_expense_report_data">

      </div>
      </form>  
    </div>
  </div>
</div>
</div>  
@endsection