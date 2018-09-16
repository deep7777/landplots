@if(count($installments)>0)
  <div class="form-group col-xs-12">
  <div class="x_title">
    <span>Total EMI Installments</span>
    <div class="clearfix"></div>
  </div>
  </div>
  @foreach($installments as $key=> $installment)
  <div class="form-group col-xs-12">
    <div class="form-group col-md-3">
    <label class="control-label requiredField" for="plot_rate">
    Installment Number
    </label>
    <div class="text-center">{{$key}}</div>  
    </div>
    <div class="form-group col-md-2">
    <label class="control-label requiredField" for="emi_date_{{$key}}">
    EMI Date
    </label>
    <input id="emi_date" name="{{"emi_date_".$key}}" value="{{dmy($installment["emi_date_".$key])}}" class="form-control date_class"  type="text" onkeydown="return false;" />
    </div>
    <div class="form-group col-md-2">
    <label class="control-label requiredField" for="emi_amount_{{$key}}">
    EMI Amount
    </label>
    <input id="emi_amount" name="{{"emi_amount_".$key}}" value="{{$installment["emi_amount_".$key]}}" class="form-control date_class"  type="text" onkeydown="return false;"/>
    </div>
  </div>
  @endforeach
@endif