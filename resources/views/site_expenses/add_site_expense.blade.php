@extends('layouts.main')
@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Expense</h2>
        <div class="pull-right">
          <a type="button" class="btn btn-primary" href="{{url('/siteexpenses')}}">Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="frm_site_expense" action ="{{url('/siteexpenses')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
            <label class="control-label requiredField" for="site_expense_name">
            Site
            </label>
            <select name="site_id" class="form-control" required="">
              <option value="">Choose Site</option>
              @foreach($site_list as $site)
              <option value="{{$site->site_id}}">{{ $site->site_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="site_expense_given_to">
          Amount Given To
          </label>
          <input required="" id="site_expense_given_to" name="site_expense_given_to" value="" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_date">
          Date
          </label>
            <input required="" id="expense_date" name="expense_date" value="" class="form-control date_class" type="text" onkeydown="return false;"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="site_expense_bill_no">
          Bill No
          </label>
            <input id="site_expense_bill_no" name="site_expense_bill_no" value="" class="form-control" type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_name">
           Purpose/Work
          </label>
          <input required="" id="expense_name" name="expense_name" value="" class="form-control "  type="text"/>
          </div>
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_amount">
           Amount
          </label>
          <input required="" id="expense_amount" name="expense_amount" value="" class="form-control "  type="text"/>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="x_title">
            <span>Payment Mode</span>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-3 payment_mode_fields">
            <label class="control-label requiredField" for="book_site_plot">
            Payment Mode
            </label>
            <select id="payment_mode" name="payment_mode" class="form-control">
              @foreach($payment_mode as $payment)
              <option value="{{$payment->payment_mode_id}}">{{ ucwords($payment->payment_mode_name) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group col-xs-12">
          <div class="form-group col-md-4">
          <label class="control-label requiredField" for="expense_desc">
            Desc
          </label>
          <textarea  class="form-control" cols="40" id="expense_desc" name="expense_desc" rows="2"></textarea>
          </div>
        </div>
        <div class="clearfix col-xs-12"></div>
        <div class="pull-right">
        <button class="btn btn-primary">Submit</button>
        </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection