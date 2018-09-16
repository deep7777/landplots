@include("frontend/partials/header")
<body class="homepage">
    @include("frontend/partials/menus")
    <section id="main-slider" class="no-margin">
      <div class="col-xs-12 text-center" style="background-color:#E2E2E2;padding:10px;">
      <strong>{{$site->site_name}}</strong>
      </div>
      <div class="carousel slide">
          <div class="carousel-inner">
            @foreach($site_images as $key=>$siteimage)
            <div class="item {{$status=($key==0)?"active":""}}" style="background-image: url({{asset('templates/images/slider/gray.jpg')}})">
                <div class="container">
                    <div class="row no-margin">
                        <div class="">
                          <div class="">
                              <img src="{{asset("uploads/sites/".$siteimage->image_name)}}"  class="img-responsive">
                          </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
            @endforeach
          </div><!--/.carousel-inner-->
      </div><!--/.carousel-->
      @if(count($site_images)>1)
      <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
          <i class="fa fa-chevron-left"></i>
      </a>
      <a class="next hidden-xs" href="#main-slider" data-slide="next">
          <i class="fa fa-chevron-right"></i>
      </a>
      @endif
    </section><!--/#main-slider-->
    @include("frontend/partials/scripts")
</body>
<script type="text/javascript">
  $("#projects").addClass("active");
</script>
</html>