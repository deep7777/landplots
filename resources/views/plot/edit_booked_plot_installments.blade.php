@if(count($installments)>0)
    <div class="form-group col-xs-12">
    <div class="x_title">
      <span>Total EMI Installments</span>
      <div class="clearfix"></div>
    </div>
    </div>
    <div class="col-sm-12">
    <div class="card-box table-responsive">
      <table id="data-list" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>EMI Date</th>
            <th>Payment Amount</th>
            <th>EMI Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($installments as $key=> $installment)
            <tr>
              <td>{{dmy($installment->emi_date)}}</td>
              <td>{{get_money_indian_format($installment->emi_amount)}}</td>
              <td>
              @if($installment->emi_status==1)
              <a class="btn btn-success">Paid</a>
              @else
              <a class="btn btn-warning">UnPaid</a>
              @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif