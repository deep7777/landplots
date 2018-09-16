@include("frontend/partials/header")
<body class="homepage">
@include("frontend/partials/menus")
<div class="row ">
  <div class="text-center" style=""><h2>{{$site_status->site_status_name." Projects" }}</h2></div>
</div>
<div style="padding:5px;">
@foreach($sites as $key=>$site)
@if($key%3==0)</div><div class="row" style="padding: 5px;">@endif 
<div class="col-md-12 col-lg-4">
  <div class="thumbnail">
    <a target="_blank" href="{{url("/siteimages/".$site->site_id)}}">
      <img src="{{url("/uploads/sites/".$site->image_name)}}" alt="{{$site->image_name}}" style="width: 260px; height: 120px;">
    </a>
    <div class="text-center" style="background-color:#E2E2E2;padding:10px;">
      <a href="{{url("/siteimages/".$site->site_id)}}" class="btn btn-info">{{$site->site_name}}</a>
    </div>
  </div>
</div> 
@endforeach

@if(count($sites)>0)</div> @endif

@include("frontend/partials/scripts")
<script type="text/javascript" charset="utf-8">
  $("#projects").addClass("active");
</script>
</body>
</html>