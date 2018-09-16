@if($payment_mode == "2")
<div class="form-group col-md-3 payment_option_fields cheque">
<label class="control-label requiredField" for="cheque_number">
Cheque Number
</label>
<input required=""   id="cheque_number" name="cheque_number" value="" class="form-control down_payment"  type="text"/>
</div>
<div class="form-group col-md-3 payment_option_fields cheque">
<label class="control-label requiredField" for="cheque_date">
Cheque Date
</label>
<input required="" id="cheque_date" name="cheque_date"  value=""  class="form-control date_class"  type="text"/>
</div>
<div class="form-group col-md-3 payment_option_fields cheque">
 <label class="control-label requiredField" for="bank_name">
 Bank Name
 </label>
  <input required=""  id="bank_name" name="bank_name"  class="form-control"  type="text"/>
</div>
@endif
@if($payment_mode == "3")
<div class="form-group col-md-3 transaction payment_option_fields">
 <label class="control-label requiredField" for="payment_date">
 Transaction ID
 </label>
  <input id="transaction_id" name="transaction_id" required=""  class="form-control"  type="text"/>
</div>
@endif