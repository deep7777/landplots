@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/addSite')}}">Add Site</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Site List</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      @if (count($errors) > 0)
        <br />
        <div class="alert alert-danger text-center">
          <div>
            @foreach ($errors->all() as $error)
              <div class="">{{ $error }}</div>
            @endforeach
          </div>
        </div>
        <br />
      @endif
      
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="site-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Add Plot</th>
                  <th>Status</th>
                  <th>Area</th>
                  <th>Rate/Sqft</th>
                  <th>Cost</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($site_list as $site)
                  <tr>
                    <td>{{ $site->site_name}}</td>
                    <td><a href="{{url('/addSitePlot/'.$site->site_id)}}" class="btn btn-default btn-xs"><i class="fa fa-delicious"></i> Add Plot </a></td>
                    <td>{{ $site->site_status_name}}</td>
                    <td>{{ $site->site_area }}</td>
                    <td>{{ get_money_indian_format($site->site_plot_rate_per_sqft) }}</td>
                    <td>{{ get_money_indian_format($site->site_cost) }}</td>
                    <td>
                      <a href="{{url('/siteLayout/'.$site->site_id)}}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Layout </a>
                      <a href="{{url('/addSiteImage/'.$site->site_id)}}" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Site Image </a>
                      <a href="{{url('/'.$site->site_id.'/editSite')}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delSite(this)" data-token="{{ csrf_token() }}" data-site-id="{{$site->site_id}}" class="delSite btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/deleteSite') }}">
<input type='hidden' id="list_site" value="{{ url('/listSite') }}">
@endsection