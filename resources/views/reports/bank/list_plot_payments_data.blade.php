<div class="row">
  <div class="form-group col-xs-4 red">
    <label class="control-label requiredField" for="customer_id">
    Total : {{get_money_indian_format($total_payment)}}
    </label>
  </div>
</div>
<div class="card-box table-responsive">
  <table id="data-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Site</th>
        <th>Plot No</th>
        <th>Date</th>
        <th>Mode</th>
        <th>Amount</th>
        <th>Bank</th>
        <th>Cheque No</th>
        <th>Cheque Date</th>
        <th>Transaction Id</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($bank_payments as $payment)
      <tr>
        <td>{{$payment->plot_owner_name}}<br>{{$payment->mobile_number}}</td>
        <td>{{$payment->site_name}}</td>
        <td>{{$payment->plot_no}}</td>
        <td>{{dmy($payment->plot_payment_date)}}</td>
        <td>{{$payment->payment_mode}}</td>
        <td>{{$payment->plot_payment_amount}}</td>
        <td>{{$payment->plot_payment_bank}}</td>
        <td>{{$payment->plot_payment_cheque_number}}</td>
        <td>{{dmy($payment->plot_payment_cheque_date)}}</td>
        <td>{{$payment->plot_payment_transaction_id}}</td>
      </tr>
      @endforeach
      <tr>
        @for($i=1;$i<11;$i++)
        @if($i==6)
        <td>{{str_replace(',','',$total_payment)}}</td>
        @else
        <td></td>
        @endif
        @endfor
        
      </tr>
    </tbody>
    
  </table>
</div>