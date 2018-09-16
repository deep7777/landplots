<!DOCTYPE html>
<html lang="en">
  @include('layouts/common_css')
  <body class="nav-md">
    <input id="url" name="url" type="hidden" value="{{url("/")}}">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a title="Vakratunda Land Developers" href="{{url('/admin')}}" class="site_title"><i class="fa fa-home"></i> <span>VakratundaLD</span></a>
            </div>
            <div class="clearfix"></div>
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 style="cursor:pointer"><span id="go_to_dashboard" data-url="{{ url('/admin')}}">{{ trans('dashboard.dashboard_name') }}</span></h3>
                <ul class="nav side-menu">
                  @include('layouts/common_menus')
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{ucwords(Session::get('staff')->first_name." ".Session::get('staff')->last_name) }}
                    <span class="fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{url('/staff/profile')}}"> Profile </a></li>
                    <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                <li role="presentation" class="dropdown">
                  <a title="Plot Payment Reminder" href="{{url('/reports/listPaymentReminders')}}" >
                    <i class="fa fa-bell-o"></i>
                    <span title="Plot Payment Reminder" class="badge bg-red">R</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('content') 
        </div>
        
      </div>
    </div>
    
    @include('layouts/common_js')
    <script src="{{ asset('/build/js/admin_scripts.min.js') }}"></script>
    <script src="{{ asset('/build/js/modules.min.js') }}"></script>
  </body>
</html>