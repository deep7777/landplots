@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/addVisitor')}}">Add Visitor</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Visitor List</h2>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="site_id" data-url="{{url("/")}}" class="form-control select_visitor_site" required="">
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
            <table id="visitor-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Site</th>
                  <th>Mobile</th>
                  <th>Media</th>
                  <th>Visited On</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($visitor_list as $visitor)
                  <tr>
                    <td>{{$visitor->first_name}}</td>
                    <td>{{$visitor->last_name}}</td>
                    <td>{{($visitor->site_name)}}</td>
                    <td>{{$visitor->mobile_no}}</td>
                    <td>{{$visitor->media_name}}</td>
                    <td>{{dmy($visitor->visited_on)}}</td>
                    <td>
                      <a href="{{url('/'.$visitor->id.'/editVisitor')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delVisitor(this)" data-token="{{ csrf_token() }}" data-visitor-id="{{$visitor->id}}" class="delVisitor btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/deleteVisitor') }}">
<input type='hidden' id="list_visitor" value="{{ url('/listVisitor') }}">
<input type='hidden' id="visitor_site_url" value="{{ url('/siteVisitor') }}">

@endsection