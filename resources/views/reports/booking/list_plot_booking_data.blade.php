<div class="card-box table-responsive blue">
  <table id="data-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Site</th>
        <th>Plot</th>
        <th>Booking Date</th>
        <th>Paid</th>
        <th>Balance</th>
        <th>Cost</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($selled_plots as $plot)
        <tr>
          <td>{{$plot->plot_owner_name}} <br> {{$plot->mobile_number}}</td>
          <td>{{$plot->site_name}}</td>
          <td>{{$plot->plot_no}}</td>
          <td>{{dmy($plot->plot_booking_date)}}</td>
          <td>{{get_money_indian_format($plot->paid_amount)}}</td>
          <td>{{get_money_indian_format($plot->balance_amount)}}</td>
          <td>{{get_money_indian_format($plot->plot_booking_cost)}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>