@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/addContractorCustomer')}}">Assign Contractor</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Contractor List</h2>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="site_id" data-url="{{url("/")}}" class="form-control select_contractor_site" required="">
          <option value="">Choose Site</option>
          @foreach($site_list as $site)
          @if($site_id == $site->site_id)
          <option selected=selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
          @else
          <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
          @endif
          @endforeach
        </select>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="contractor-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Work</th>
                  <th>Amount</th>
                  <th>Paid</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contractor_customers_list as $contractor_customer)
                  <tr>
                    <td>{{$contractor_customer->contractor_first_name}}</td>
                    <td>{{$contractor_customer->contractor_last_name}}</td>
                    <td>{{$contractor_customer->contractor_work}}</td>
                    <td>{{$contractor_customer->contractor_amount}}</td>
                    <td>{{$contractor_customer->contractor_paid_amount}}</td>
                    <td>{{date('d/m/Y', strtotime($contractor_customer->contractor_date))}}</td>
                    <td>
                      <a href="{{url('/'.$contractor_customer->customer_id.'/editContractorCustomer')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delContractorCustomer(this)" data-token="{{ csrf_token() }}" data-contractor-customer-id="{{$contractor_customer->customer_id}}" class="delContractor btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type='hidden' id="delete_url" value="{{ url('/deleteContractorCustomer') }}">
<input type='hidden' id="list_contractor_customer" value="{{ url('/listContractorCustomer') }}">
@endsection