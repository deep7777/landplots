@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/addPlot')}}">Add Plot</a>
  </div>
</div>  
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Select Site </h2>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="site_id" data-url="{{url("/")}}" class="form-control select_site" required="">
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
            <table id="data-table-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Site Name</th>
                  <th>Plot Name</th>
                  <th>Book Plot</th>
                  <th>Area</th>
                  <th>Rate/Sqft</th>
                  <th>Cost</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($plot_list as $plot)
                  <tr>
                    <td>{{$plot->site_name}}</td>
                    <td>{{$plot->plot_name}}</td>
                    @if($plot->plot_booked==1)
                    <td><a class="btn btn-success btn-xs"><i class="fa fa-delicious"></i> Plot Booked </a></td>
                    @else
                    <td><a href="{{url('/bookPlot/'.$plot->site_id)}}" class="btn btn-default btn-xs"><i class="fa fa-delicious"></i> Book Plot </a></td>
                    @endif
                    <td>{{get_money_indian_format($plot->plot_area)}}</td>
                    <td>{{get_money_indian_format($plot->plot_rate_per_sqft)}}</td>
                    <td>{{get_money_indian_format($plot->plot_cost)}}</td>
                    <td>
                      <a href="{{url('/'.$plot->plot_id.'/editPlot')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delPlot(this)" data-token="{{ csrf_token() }}" data-plot-id="{{$plot->plot_id}}" class="delPlot btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/deletePlot') }}">
<input type='hidden' id="list_plot" value="{{ url('/listPlot') }}">
<input type='hidden' id="site_plots_url" value="{{ url('/sitePlots') }}">

@endsection