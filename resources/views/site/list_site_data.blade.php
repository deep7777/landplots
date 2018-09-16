<table id="data-table-list" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Site Name</th>
      <th class="text-center">Layout</th>
      <th class="text-center">Total Plots</th>
      <th class="text-center">Available Plots</th>
      <th class="text-center">Sold Plots</th>
      <th class="text-center">Sold Plots Collected Amount</th>
      <th class="text-center">Sold Plots Pending Amount</th>
      <th class="text-center">Sold Plots Total Amount</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sites as $site)
      <tr>
        <td class="blue">{{$site['site_name']}}</td>
        <td align="center"><a href="{{url('siteLayout/'.$site['site_id'])}}" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a></td>
        <td class="text-center purple"> {{$site['site_total_plots']}} </td>
        <td class="text-center green"><b>{{$site['site_available_plots']}}</b></td>
        <td class="text-center red">{{$site['site_sold_plots']}}</td>
        <td class="text-center blue">{{get_money_indian_format($site['sold_plots_collected_amount'])}}</td>
        <td class="text-center purple">{{get_money_indian_format($site['sold_plots_pending_amount'])}}</td>
        <td class="text-center" style="color:orange">{{get_money_indian_format($site['sold_plots_total_amount'])}}</td>
      </tr>
    @endforeach
  </tbody>
</table>