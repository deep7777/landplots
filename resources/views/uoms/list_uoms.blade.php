@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<form id="frm_purchase_order_list" data-parsley-validate class="form-horizontal form-label-left">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="">
    <a type="button" class="btn btn-primary" href="{{url('/uoms/create')}}">Add Uom</a>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    
    <div class="x_content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card-box table-responsive">
            <table id="data-table-list" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Uom Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($uoms as $uom)
                  <tr>
                    <td>{{$uom->uom_name}}</td>
                    <td>
                      <a href="{{url('/uoms/'.$uom->uom_id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                      <a onclick="return delRecord(this)" data-url="{{url("/uoms/destroy")}}" data-token="{{ csrf_token() }}" data-id="{{$uom->uom_id}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
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
</form>
@endsection