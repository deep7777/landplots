@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Send SMS Message</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        @if (count($errors) > 0)
          <div class="alert alert-danger text-center">
            <div>
              @foreach ($errors->all() as $error)
                <div class="">{{ $error }}</div>
              @endforeach
            </div>
          </div>
        @endif
        <br />
        <form action ="{{url('/sendMessage')}}" method="POST"  data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="to">To <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ old('to') }}" type="text" id="to" name="to" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smsMessage">Message <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea rows="5" required="" name="smsMessage" id="smsMessage" class="form-control"  data-parsley-trigger="keyup">{{ old('contractor_address') }}</textarea>
            </div>
            <div>
              (Limit <span id="smsMessageCounter" class="input-counter count red"></span> out of <span class="text-primary">160</span> characters)</span>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-9 text-right">
              <button type="button" class="btn btn-success">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection