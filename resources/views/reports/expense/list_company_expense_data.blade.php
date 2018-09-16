<div class="row">
  <div class="form-group col-xs-4 red">
    <label class="control-label requiredField" for="customer_id">
    Total : {{$total_company_expense}}
    </label>
  </div>
</div>
<div class="card-box table-responsive">
  <table id="data-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>To</th>
        <th>Date</th>
        <th>Bank</th>
        <th>Bill No</th>
        <th>Cheque No</th>
        <th>Cheque Date</th>
        <th>Transaction Id</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($company_expenses as $expense)
      <tr>
        <td>{{$expense->expense_name}}</td>
        <td>{{$expense->expense_given_to}}</td>
        <td>{{dmy($expense->expense_date)}}</td>
        <td>{{$expense->expense_bank_name}}</td>
        <td>{{$expense->expense_bill_no}}</td>
        <td>{{$expense->expense_cheque_no}}</td>
        <td>{{dmy($expense->expense_cheque_date)}}</td>
        <td>{{dmy($expense->expense_transaction_id)}}</td>
        <td>{{get_money_indian_format($expense->expense_amount)}}</td>
      </tr>
      @endforeach
      <tr>
        @for($i=1;$i<9;$i++)
        <td></td>
        @endfor
        <td>{{str_replace(',','',$total_company_expense)}}</td>
      </tr>
    </tbody>
    
  </table>
</div>