@extends('layouts.main')
@section('content')
<form id="frm_book_plot" class="form-horizontal form-label-left">
{{ csrf_field() }}
<div class="row">
  <div class="x_title">
    <div class="form-group col-xs-12">
      <div class="form-group col-md-6">
      <label class="control-label requiredField" for="book_site_plot">
       Select Site to Book Plot
      </label>
      <select id="site_id" name="site_id" data-url="{{url("/")}}" class="form-control book_site_plot" required="">
        <option value="">Choose Site</option>
        @foreach($site_list as $site)
        <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @endforeach
      </select>
      </div>
      <div class="form-group col-md-6 site_plots">
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-table-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Site</th>
                  <th>Plot</th>
                  <th>Booking Date</th>
                  <th>Info</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selled_plots as $plot)
                  <tr>
                    <td>
                    <a  class="btn-link" href="{{url('/editBookedPlot'.'/'.$plot->plot_booking_id)}}"> {{$plot->plot_owner_name}} </a>
                    <br>{{$plot->mobile_number}}
                    </td>
                    <td>{{$plot->site_name}}</td>
                    <td>{{$plot->plot_no}}</td>
                    <td>{{dmy($plot->plot_booking_date)}}</td>
                    <td class="blue">
                    <b>Booking Cost : {{get_money_indian_format($plot->plot_booking_cost)}}</b><br>
                    <b class="green">Paid Amount : {{get_money_indian_format($plot->paid_amount)}}</b><br>
                    <b class="red">Balance Amount : {{get_money_indian_format($plot->balance_amount)}}</b>
                    </td>
                    <td>
                      @if($plot->plot_emi_taken)
                      <a href="{{url('/plotBookingEmi/'.$plot->plot_booking_id)}}" class="active btn btn-xs btn-warning" booking-id="{{$plot->plot_booking_id}}">EMI Taken </a>
                      @else
                      <a href="{{url('/plotBookingEmi/'.$plot->plot_booking_id)}}" class="btn btn-xs btn-warning" booking-id="{{$plot->plot_booking_id}}">EMI </a>
                      @endif
                      <a onclick="return showSmsModal(this)" data-token="{{ csrf_token() }}" data-site-name="{{$plot->site_name}}" data-plot-no="{{$plot->plot_no}}" data-plot-owner="{{$plot->plot_owner_name}}" data-plot-owner-mobile-number="{{$plot->mobile_number}}" class="btn btn-success btn-xs"> SMS </a>
                      <a onclick="return showInvoiceModal(this)" data-token="{{ csrf_token() }}" data-booking-id="{{$plot->plot_booking_id}}"  class="btn btn-primary btn-xs"> Invoice </a>
                      <a class="btn btn-info btn-xs" href="{{url('/plotPayment'.'/'.$plot->plot_booking_id)}}"> Payment </a>
                      <a onclick="return delBookedPlot(this)" data-token="{{ csrf_token() }}" data-plot-booking-id="{{$plot->plot_booking_id}}" class="btn btn-danger btn-xs"> Delete </a>
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
</form>  
@include("modal/invoiceModal")
@include("modal/smsOwnerModal")
@endsection