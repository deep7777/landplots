@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Uom</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/uoms')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_uom"  method="POST" action ="{{url('/uoms/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$uom->uom_id}}" name="uom_id">
        <div class="row">
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
            <label class="control-label requiredField" for="uom_name">
             Uom Name
            </label>
            <input required="" id="uom_name" name="uom_name" value="{{$uom->uom_name}}" class="form-control clear-all"  type="text"/>
            </div>
          </div>
          </div>
        <div class="clearfix col-xs-12"></div>
        <div class="pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        </div>
      </div>
  </div>
</div>
@endsection