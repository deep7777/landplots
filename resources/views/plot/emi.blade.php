<div class="form-group col-xs-12">
  <div class="x_title" style="color:red">
    <span style="color:red">EMI Calculated On the basis of Balance Amount to be paid</span>
    <div class="clearfix"></div>
  </div>
</div>
<div class="form-group col-xs-12">
  <div class="form-group col-md-3">
  <label class="control-label requiredField" for="plot_emi_taken">
  EMI Scheme
  </label>
  <input id="plot_emi_taken" name="plot_emi_taken"  value="1"  class="form-control"  type="checkbox"/>
  </div>
  <div class="form-group col-md-3">  
  <label class="control-label requiredField" for="emi_date">
  EMI Starting Date
  </label>
  <input id="plot_emi_start_date" name="plot_emi_start_date" value="" class="form-control date_class"  type="text" onkeydown="return false;"/>
  </div>
  <div class="form-group col-md-3">
  <label class="control-label requiredField" for="plot_rate">
  Number of EMI Installments
  </label>
  <input data-parsley-type="number" id="plot_emi_installments" name="plot_emi_installments" value="" class="form-control down_payment"  type="text"/>
  </div>
  <div class="form-group col-md-3">
    <label class="control-label requiredField" for="">&nbsp;</label>
    <button type="button" id="btn_emi" name="btn_emi" class="form-control btn btn-warning">EMI SCHEDULE</button>
  </div>
</div>
<div class="emi_installments"></div>