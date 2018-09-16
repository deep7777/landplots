@if(sizeof($plot_list) > 0)
<label class="control-label">Select Plot</label>
<select id="book_site_plot"  name="book_site_plot" class="form-control book_plot" required="">
  <option value="">Choose Plot</option>
  @foreach($plot_list as $plot)
  <option value="{{$plot->plot_id}}">{{ $plot->plot_no }}</option>
  @endforeach
</select>
@else
<span class="">No plots for this site.</span>
@endif

