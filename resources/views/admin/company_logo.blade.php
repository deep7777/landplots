@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Upload Company Logo </h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Choose File</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
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
            <img src="{{url('/uploads/logo/'.Session::get('path')) }}">
            </div>
            @elseif($count > 0 && $company->logo!='')
            <div class="text-center">
            <img src="{{url('/uploads/logo/'.$company->logo) }}">
            </div>
            @endif
            
            <form action="{{ url('/admin/uploadCompanyLogo') }}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            @if($count > 0)
            <input type="hidden" value="{{$company->id}}" name="id">
            <div class="col-lg-3">
              <div class="input-group">
                <input type="file" name="image" />
                <button type="submit" class="btn btn-success">Upload</button>
              </div>  
            </div>
            @else
            <div class="alert alert-success alert-block text-center">
              <a class="btn btn-default"  href='/admin/listCompany'>Create Company to upload logo.</a>
            </div>
            @endif
            <br />
            <br />
            <br />
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection