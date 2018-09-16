@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Upload Image </h3>
      </div>
      <div class="pull-right">
        <a type="button" class="btn btn-primary" href="{{url('/listSiteImages')}}">Back</a>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel" style="background-color:#DCDCDC ">
          <div class="x_content" >
            <form action="{{ url('/uploadSiteImage') }}" enctype="multipart/form-data" method="POST">
              {{ csrf_field() }}
              <div class="from-group col-xs-12">
              <div class="from-group col-xs-4">
                <select name="site_id" data-url="{{url("/")}}" class="form-control" required="">
                  <option value="">Choose Site</option>
                  @foreach($site_list as $site)
                  @if($site_id == $site->site_id)
                  <option selected value="{{$site->site_id}}">{{ $site->site_name }}</option>
                  @else
                  <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group col-xs-4">
                <input type="file" name="image" accept="image/*" />
              </div>
              <div class="form-group col-xs-4">
                <button type="submit" class="btn btn-default">Upload</button>
              </div>  
              </div>
          </form>    
          </div>
        </div>
        @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
            </div>
            <div class="text-center">
            <img width="300" height="300" src="{{url('/uploads/sites/'.Session::get('path')) }}">
            </div>
            @endif
      </div>
    
  </div>
@endsection