@include("frontend/partials/header")
<body class="homepage">
    @include("frontend/partials/menus")
    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
                <li data-target="#main-slider" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image: url({{asset('templates/images/slider/gray.jpg')}})">
                    <div class="container">
                        <div class="row no-margin">
                            <div class="">
                              <div class="">
                                  <img src="{{asset("images/vakratunda/vk_phase_2.jpg")}}"  class="img-responsive">
                              </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url({{asset('templates/images/slider/gray.jpg')}})">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="">
                                <div class="">
                                  <img src="{{asset("images/vakratunda/vk_phase_2_1.jpg")}}"  class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url({{asset('templates/images/slider/gray.jpg')}})">
                    <div class="container">
                        <div class="row no-margin">
                            <div class="">
                                <div class="">
                                    <img src="{{asset("images/vakratunda/vk_phase_3.jpg")}}"  class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url({{asset('templates/images/slider/gray.jpg')}})">
                    <div class="container">
                        <div class="row no-margin">
                            <div class="">
                                <div class="">
                                  <img src="{{asset("images/vakratunda/vk_phase_3_4.jpg")}}" height="950" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->
    @include("frontend/partials/scripts")
</body>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111278950-1"></script>
<script type="text/javascript">
  $("#home").addClass("active");
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
  if(window.location.href.indexOf("vakratunda") > -1){
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-111278950-1');
  }
</script>
</html>