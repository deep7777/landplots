@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Plot</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/listPlot')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('shared/showmsg')
        @include('plot/frm_create_plot')
      </div>
    </div>
  </div>
</div>
@endsection