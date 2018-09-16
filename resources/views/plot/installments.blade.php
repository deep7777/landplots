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
              <form id="frm_emi_{{$installment->emi_id}}" action="{{url("/updateEmiStatus")}}" method="post" >
              {{ csrf_field() }} 
              <input type="hidden" id="booking_id" name="booking_id" value="{{$booked_plot->plot_booking_id}}">
              <input type="hidden" name="emi_id" value="{{$installment->emi_id}}">
              <select onchange="updateEmiStatus('{{$installment->emi_id}}')" id="emi_status" name="emi_status" class="form-control">
                <option value="">Update EMI Status</option>
                @foreach($emi_status as $key=>$status)
                @if($installment->emi_status==$key)
                <option selected value="{{$key}}">{{ $status }}</option>
                @elseif($installment->emi_status==$key )
                <option selected value="{{$key}}">{{ $status }}</option>
                @else
                <option value="{{$key}}">{{ $status }}</option>
                @endif
                @endforeach
              </select>
              </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif