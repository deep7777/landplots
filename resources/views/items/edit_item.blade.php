@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Item</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/items')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        <form id="frm_item"  method="POST" action ="{{url('/items/update')}}"  data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="{{$item->item_id}}" name="item_id">
        <div class="row">
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="item_code">
              Item Code
             </label>
              <input readonly id="item_code" name="item_code" required="" value="{{$item->item_code}}" class="form-control clear-all"  type="text"/>
            </div>
            <div class="form-group col-md-6">
            <label class="control-label requiredField" for="item_name">
             Item Name
            </label>
            <input required="" id="item_name" name="item_name" value="{{$item->item_name}}" class="form-control clear-all"  type="text"/>
            </div>
          </div>
          <div class="form-group col-xs-12">
            <div class="form-group col-md-6">
             <label class="control-label requiredField" for="item_desc">
              Description
             </label>
             <textarea class="form-control" cols="40" id="item_desc" name="item_desc" rows="4">{{$item->item_desc}}</textarea>
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