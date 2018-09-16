<header id="header">
  <nav class="navbar navbar-inverse" role="banner">
    <div class="container">
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            <img src="{{asset("templates/images/project/logo.jpg")}}" width="115" height="70" alt="logo">
            <i class="fa fa-phone-square"></i> {{$company->mobile_no}}
            @if($company->office_no!='')/ {{$company->office_no}}@endif
          </a>
      </div>
      <div class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav">
            <li id="home" class="active"><a href="/">Home</a></li>
            <li id="aboutus" style="display:none;"><a href="/">About Us</a></li>
            <li id="projects" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <i class="fa fa-angle-down"></i></a>
              <ul class="dropdown-menu">
                <li><a href="{{url("/projects/1")}}">COMPLETED PROJECTS</a></li>
                <li><a href="{{url("/projects/2")}}">ONGOING PROJECTS</a></li>
                <li style="display:none;"><a href="{{url("/projects/3")}}">FUTURE PROJECTS</a></li>
              </ul>
            </li>
            <li id="contactus" class=""><a href="/contactus">Contact Us</a></li>                        
        </ul>
      </div>
    </div><!--/.container-->
  </nav><!--/nav-->
</header><!--/header-->