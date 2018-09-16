@extends('layouts.main')
@section('content')
<style>
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 25px;
}
.btn-circle.btn-xl {
  width: 70px;
  height: 70px;
  padding: 10px 16px;
  font-size: 24px;
  line-height: 1.33;
  border-radius: 35px;
}
</style>
<div class="clearfix"></div>
<div class="row">
  <div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ $site->site_name }}</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="col-xs-12">
            <div class="col-md-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Total Plots - {{count($site_list)}}</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="available-tab" data-toggle="tab" aria-expanded="false">Available Plots - {{count($available_plots)}}</a>
                  </li>
                  <li role="presentation"><a href="#tab_content3" id="sold-tab" role="tab" data-toggle="tab" aria-expanded="true">Sold Plots - {{count($sold_plots)}}</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                  <div>
                    <svg width="50" height="50" stroke="pink">
                    <rect width="60" height="60" stroke="black" stroke-width="1" fill="#0ED7BF" />
                    <text x="40%" y="20%" text-anchor="middle" stroke="black" stroke-width="1px" dy=".5em">Area</text>
                      <text x="40%" y="65%" text-anchor="middle" stroke="blue" stroke-width="1px" dy=".5em">Num</text>
                    </svg>
                    <svg width="50" height="50" stroke="pink">
                      <rect width="60" height="50" stroke="black" stroke-width="1" fill="#D7778C" />
                      <text x="40%" y="15%" text-anchor="middle" stroke="yellow" stroke-width="1px" dy=".5em">Area</text>
                      <text x="40%" y="65%" text-anchor="middle" stroke="white" stroke-width="1px" dy=".5em">Num</text>
                    </svg>
                  </div>
                    <div class="form-group" id="all_plots" style="padding:1px;">
                      @foreach($site_list as $plot)
                      <tr>
                        @if($plot->plot_booked=="0")
                        <td>
                        <svg width="50" height="50" stroke="pink">
                          <rect width="60" height="60" stroke="black" stroke-width="1" fill="#0ED7BF" />
                         <text x="40%" y="20%" text-anchor="middle" stroke="black" stroke-width="1px" dy=".5em">{{$plot->plot_area}}</text>
                          <text x="40%" y="65%" text-anchor="middle" stroke="blue" stroke-width="1px" dy=".5em">{{$plot->plot_no}}</text>
                        </svg>
                        </td>
                        @else
                        <svg width="50" height="50" stroke="pink">
                          <rect width="60" height="50" stroke="black" stroke-width="1" fill="#D7778C" />
                          <text x="40%" y="15%" text-anchor="middle" stroke="yellow" stroke-width="1px" dy=".5em">{{$plot->plot_area}}</text>
                          <text x="40%" y="65%" text-anchor="middle" stroke="white" stroke-width="1px" dy=".5em">{{$plot->plot_no}}</text>
                        </svg>
                        @endif
                      </tr>
                      @endforeach
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="available-tab">
                    <div id="available_plots" style="background-color: #F9DCCB;">
                      @foreach($site_list as $plot)
                      <tr>
                        @if($plot->plot_booked=="0")
                        <td><button type="button" class="btn btn-success btn-circle"><i class="glyphicon glyphicon"></i>{{$plot->plot_no}}</button></td>
                        @endif
                      </tr>
                      @endforeach
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="sold-tab">
                    <div id="sold_plots" style="background-color: #F9DCCB;color:black;padding: 10px;">
                      <div class="text-center alert alert-warning col-xs-12"> Click on plot no to find plot details. </div>
                      @foreach($site_list as $plot)
                      <tr>
                        @if($plot->plot_booked=="1")
                        <td><button plot-no="{{$plot->plot_no}}" title="{{$plot->owner_name}}" type="button" class="btn btn-danger btn-circle search-plot-owner"><i class="glyphicon glyphicon"></i>{{$plot->plot_no}}</button></td>
                        @endif
                      </tr>
                      @endforeach
                    </div>
                    <div class="x_panel">                    
                      <div class="card-box table-responsive">
                        <table id="data-list-sold-plots" class="table table-striped table-bordered blue">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Plot No</th>
                              <th>Plot Area</th>
                              <th>Mobile Number</th>
                              <th>Booking Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($sold_plots as $plot)
                            <tr>
                              <td>{{$plot->owner_name}}</td>
                              <td>{{$plot->plot_no}}</td>
                              <td>{{$plot->plot_area}}</td>
                              <td>{{$plot->owner_mobile_no}}</td>
                              <td>{{dmy($plot->plot_booking_date)}}</td>
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="product-image panorama">
      @if($active_image)
      <img src="{{url("/uploads/sites/".$active_image->image_name)}}" alt="...">
      @else
      <a class="btn btn-xs" href="{{url("/listSiteImages")}}" alt="Set Default Site Image">Set Site Default Image</a>
      @endif
    </div>
  </div>
</div>  
 

@endsection