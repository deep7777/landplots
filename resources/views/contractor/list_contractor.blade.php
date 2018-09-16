@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/addContractor')}}">Add Contractor</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Contractor List</h2>
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
                  <th>Email</th>
                  <th>Mobile No</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contractor_list as $contractor)
                  <tr>
                    <td>{{$contractor->contractor_first_name}}</td>
                    <td>{{$contractor->contractor_last_name}}</td>
                    <td>{{$contractor->contractor_email}}</td>
                    <td>{{$contractor->contractor_mobile_no}}</td>
                    <td>
                      <a href="{{url('/'.$contractor->contractor_id.'/editContractor')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delContractor(this)" data-token="{{ csrf_token() }}" data-contractor-id="{{$contractor->contractor_id}}" class="delContractor btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
<input type='hidden' id="delete_url" value="{{ url('/deleteContractor') }}">
<input type='hidden' id="list_contractor" value="{{ url('/listContractor') }}">
@endsection