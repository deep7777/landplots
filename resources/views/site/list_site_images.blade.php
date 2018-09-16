@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-xs-6">
    <div class="form-group green">
      <select name="site_id" data-url="{{url("/")}}" class="form-control select_site_image" required="">
        <option value="">Select Site To Add Image</option>
        @foreach($site_list as $site)
        <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
        @endforeach
      </select>
    </div> 
  </div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title ">
      <div>Site Images</div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="site-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Site Name</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Active Image Of Site</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($site_images as $site)
                  <tr>
                    <td>{{ $site->site_name }} </td>
                    <td class="text-center"><img width="50" height="50" src="{{url('/uploads/sites/'.$site->image_name) }}"></td>
                    @if($site->image_set_active==0)
                    <td class="text-center"><a onclick="return setSiteImageActive(this)" data-token="{{ csrf_token() }}" data-url="{{url('/')}}" data-image-id="{{$site->image_id}}" class="setSiteImageActive btn btn-default btn-xs">Set Site Default Image</a></td>
                    @else
                    <td class="text-center"><button class="btn btn-success">Site Default Image</button></td>
                    @endif
                    <td>
                      <a onclick="return delSiteImage(this)" data-token="{{ csrf_token() }}" data-url="{{url('/')}}" data-image-id="{{$site->image_id}}" class="delSiteImage btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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