if($(".select_site").length){
	$( ".select_site" )
  .change(function () {
    var site_id = $( ".select_site option:selected" ).val();
		var site_plots_url = $(this).data('url')+"/listPlot"; //default plots
		if(site_id!==''){
			site_plots_url = $(this).data('url')+"/sitePlots/"+site_id;
		}
		window.location.href = site_plots_url;
  });
}

if($(".select_site_image").length){
	$( ".select_site_image" )
  .change(function () {
    var site_id = $( ".select_site_image option:selected" ).val();
		var site_plots_url = $(this).data('url')+"/listSiteImages"; //default plots
		if(site_id!==''){
			site_plots_url = $(this).data('url')+"/addSiteImage/"+site_id;
		}
		window.location.href = site_plots_url;
  });
}

if($(".select_visitor_site").length){
	$( ".select_visitor_site" )
  .change(function () {
    var site_id = $( ".select_visitor_site option:selected" ).val();
    var site_visitor_site_url = $(this).data('url')+"/listVisitor";
		if(site_id!==''){
			site_visitor_site_url = $("#visitor_site_url").val()+"/"+site_id;
		}
		window.location.href = site_visitor_site_url;
  });
}

if($(".select_contractor_site").length){
	$( ".select_contractor_site" )
  .change(function () {
    var site_id = $( ".select_contractor_site option:selected" ).val();
    var site_contractor_site_url = $(this).data('url')+"/listContractorCustomer";
		if(site_id!==''){
			site_contractor_site_url = $(this).data('url')+"/siteContractorCustomer"+"/"+site_id;
		}
		window.location.href = site_contractor_site_url;
  });
}