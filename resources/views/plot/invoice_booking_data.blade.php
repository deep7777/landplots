<table style="padding-left: 10px;" class="blue" width="90%" border="0" cellpadding="1">
    <tr>
      	<td colspan="2" align="center" width="50%">
      		@if($company->logo!='')
            <img width="300" height="300" class="img-responsive avatar-view" src="{{url('/uploads/logo/'.$company->logo) }}" alt="{{$company->name}}" title="{{$company->name}}">
            @else
            <img  width="300" height="300" class="img-responsive avatar-view" src="{{url('/uploads/logo/profile-default-pic.png') }}" alt="{{$company->name}}" title="{{$company->name}}">
            @endif
      	</td>
  	</tr>
  	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td width="50%" cellpadding="20">
        	<table>
				<tr>
				<td>
					<label for="smsName">Name : <span id="smsName" class="required"> {{$booked_plot->plot_owner_name}}</span>
					</label>
				</td>  
				</tr>
				<tr>
					<td>
					<label for="smsSiteName">Site Name : <span id="smsSiteName" class="required"> {{$booked_plot->site_name}}</span>
					</label>
					</td>  
				</tr>
				<tr>
					<td>
					<label for="smsPlotNo">Plot No : <span id="smsPlotNo" class="required"> {{$booked_plot->plot_no}}</span>
					</label>
					</td>  
				</tr>
				<tr>
					<td>
					<label for="smsTo">Mobile No : <span id="smsTo" class="required"> {{$booked_plot->mobile_number}}</span>
					</label>
					</td>  
				</tr>
				<tr>
					<td>
					<label for="smsTo">Booking Date : <span id="smsTo" class="required"> {{dmy($booked_plot->plot_booking_date)}}</span>
					</label>
					</td>  
				</tr>
		    </table>		
        </td>
        <td width="50%" cellpadding="20">
        	<table width="100%">
			<tr>
				<td>
				<label for="smsName">Area : <span id="smsName" class="required"> {{$booked_plot->plot_booking_area}} </span>
				</label>
				</td>  
			</tr>
			<tr>
				<td>
				<label for="smsSiteName">Rate Per Sqft : <span id="smsSiteName" class="required"> {{$booked_plot->plot_booking_rate_per_sqft}}</span>
				</label>
				</td>  
			</tr>
			<tr>
				<td>
				<label for="smsPlotNo">Booking Amount : <span id="smsPlotNo" class="required">{{get_money_indian_format($booked_plot->plot_booking_cost)}}</span>
				</label>
				</td>  
			</tr>
			<tr>
				<td>
				<label for="smsTo">Paid Amount : <span id="smsTo" class="required">{{get_money_indian_format($booked_plot->paid_amount)}}</span>
				</label>
				</td>  
			</tr>
			<tr>
				<td>
				<label for="smsTo">Balance Amount : <span id="smsTo" class="required">{{get_money_indian_format($booked_plot->balance_amount)}}</span>
				</label>
				</td>  
			</tr>
			
			</table>
		</td>
  	</tr>
  	<tr>
  		<td colspan="2" style="padding-left: 20px;" width="100%">
  			<b>Customer Address : {{$booked_plot->owner_address}}</b>
  		</td>
  	</tr>
  	<tr>
  	    <td colspan="2"  style="padding-left: 20px;" width="100%" class="purple">
	        <table id="data-list" class="table table-striped table-bordered">
	          <thead>
	            <tr>
	              <th>Date</th>
	              <th>Amount</th>
	              <th>Cheque Number</th>
	              <th>Transaction Id</th>
	            </tr>
	          </thead>
	          <tbody>
	            @foreach ($plot_payments as $plot)
	              <tr>
	                <td>{{dmy($plot->plot_payment_date)}}</td>
	                <td>{{get_money_indian_format($plot->plot_payment_amount)}}</td>
	                <td>{{$plot->plot_payment_cheque_number}}</td>
	                <td>{{$plot->plot_payment_transaction_id}}</td>
	              </tr>
	            @endforeach
	          </tbody>
	        </table>
	    </td>
	</tr>
  	<tr>
		<td style="padding-left: 20px;" width="50%">
			<svg width="200" height="120" stroke="">
	          <rect width="150" height="90" stroke="grey" stroke-width="0.5" fill="white"></rect>
	          <text x="5%" y="85%" text-anchor="left" stroke="grey" stroke-width="0.5" dx=".5em" dy=".5em">Customer Signature</text>
	        </svg>
		</td>
		<td style="padding-left: 20px;" width="50%">
			<svg width="220" height="120" stroke="">
	          <rect width="180" height="90" stroke="grey" stroke-width="0.5" fill="white"></rect>
	          <text x="1%" y="85%" text-anchor="left" stroke="grey" stroke-width="0.5" dx=".5em" dy=".5em">Vakratunda Land Developers</text>
	        </svg>
		</td>
	</tr>
</table>
       
<style>

table td{
  padding-left: 10px;
}
</style>