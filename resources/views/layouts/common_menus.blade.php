<li>
  <a><i class="fa fa-sellsy"></i>Reports<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/reports/listPlotBooking')}}">Plot Bookings</a></li>
    <li><a href="{{url('/reports/listPlotPayments')}}">Plot Payments</a></li>
    <li><a href="{{url('/reports/listPaymentReminders')}}"> Reminders </a></li>
    <li><a href="{{url('/reports/listEmployeeSalary')}}">Employee Salary</a></li>
    <li><a href="{{url('/reports/listSiteExpense')}}">Site Expense</a></li>
    <li><a href="{{url('/reports/listCompanyExpense')}}">Company Expense</a></li>
  </ul>
</li>
<li>
  <a><i class="fa fa-sellsy"></i>Sales<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/listPlotBooking')}}">Plot Booking</a></li>
  </ul>
</li>
<li>
  <a><i class="fa fa-user"></i>{{ trans('dashboard.company') }}<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/admin/listCompany')}}">{{ trans('dashboard.profile') }}</a></li>
    <li><a href="{{url('/admin/companyLogo')}}">{{ trans('dashboard.logo') }}</a></li>
  </ul>
</li>
<li>
  <a><i class="fa fa-globe"></i>{{ trans('dashboard.sites') }}<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/listSite')}}">{{ trans('dashboard.list') }}</a></li>
    <li><a href="{{url('/listSiteImages')}}">{{ trans('dashboard.images') }}</a></li>
  </ul>
</li>
<li>
  <a><i class="fa fa-hashtag"></i>Plot<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/listPlot')}}">List</a></li>
  </ul>
</li>
<li><a><i class="fa fa-users"></i> {{ trans('dashboard.visitors') }} <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li id="add_list"><a href="{{url('/listVisitor')}}">{{ trans('dashboard.list') }}</a></li>                    
  </ul>
</li>
<li><a><i class="fa fa-user"></i>{{ trans('dashboard.contractor') }}<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/listContractor')}}">{{ trans('dashboard.list') }}</a></li>
    <li><a href="{{url('/listContractorCustomer')}}">{{ trans('dashboard.assign_contractor') }}</a></li>
  </ul>
</li>
<li><a><i class="fa fa-money"></i>Expenses <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/siteexpenses')}}">Site Expenses</a></li>
    <li><a href="{{url('/expenses')}}">Company Expenses</a></li>
  </ul>
</li>
<li><a><i class="fa fa-money"></i>Salary <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/employees')}}">Employees</a></li>
    <li><a href="{{url('/salaries')}}">Employee Salary</a></li>
  </ul>
</li>
<li><a><i class="fa fa-retweet"></i>{{ trans('dashboard.message') }}<span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a href="{{url('/listMessage')}}">{{ trans('dashboard.list') }}</a></li>
  </ul>
</li>