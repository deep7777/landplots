@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Add Partner</h2>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select id="site_id_partner" name="site_id_partner" data-url="{{url("/")}}" class="form-control select_site" required="">
          <option value="">Choose Site</option>
          @foreach($site_list as $site)
          <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-table-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Partner Name</th>
                  <th>Site Name</th>
                  <th>Mobile Number</th>
                  <th>Percentage</th>
                  <th>Amount</th>
                  <th>Payment</th>
                  <th>Actions</th>
                </tr>
              </thead>
              @foreach ($partners as $partner)
                <tr>
                  <td>{{$partner->partner_first_name." ".$partner->partner_last_name}}</td>
                  <td>{{$partner->site_name}}</td>
                  <td>{{$partner->partner_mobile_no}}</td>
                  <td>{{$partner->partner_percentage}}</td>
                  <td>{{get_money_indian_format($partner->partner_amount)}}</td>
                  <td><a  class="btn-link" href="{{url('/partnerPayment'.'/'.$partner->partner_id)}}"> Make Payment </a></td>
                  <td>
                    <a href="{{url('/editSitePartner/'.$partner->partner_id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                    <a onclick="return delSitePartner(this)" data-token="{{ csrf_token() }}" data-id="{{$partner->partner_id}}" class="delPartner btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                  </td>
                </tr>
              @endforeach
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection