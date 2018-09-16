function delSite(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('site-id');
	var data = {_token :token,id:id};
	var url = $("#url").val()+"/deleteSite";
	var list_site = $("#list_site").val();
	BootstrapDialog.show({
		type: BootstrapDialog.TYPE_DANGER,
		title: 'Delete Record',
		message: 'Are you sure you want to delete record ?',
		buttons: [
			 {
				label: 'Yes',
				cssClass: 'btn-danger btn-sm',
				action: function(dialogItself){
					dialogItself.close();
					$.ajax({
						url:url,
						type: 'post',
						data: data,
						success:function(resp){
							if(resp=="success"){
								window.location.href = list_site;
							}else{
								//https://nakupanda.github.io/bootstrap3-dialog/
								BootstrapDialog.show({
									 type: BootstrapDialog.TYPE_WARNING,
									 title: 'Warning',
									 message: resp
								}); 
							}
						}
					});
				}
			 }
		 ]
	});
}
//set site Image active
function setSiteImageActive(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('image-id');
	var data = {_token :token,id:id};
	var url = $(obj).data('url')+"/setSiteImageActive";
	BootstrapDialog.show({
		type: BootstrapDialog.TYPE_INFO,
		title: 'Set Site Image Active',
		message: 'Are you sure you want to set image active ?',
		buttons: [
			 {
				label: 'Yes',
				cssClass: 'btn-info btn-sm',
				action: function(dialogItself){
					dialogItself.close();
					$.ajax({
						url:url,
						type: 'post',
						data: data,
						success:function(resp){
							if(resp=="success"){
								url = $(obj).data('url');
								window.location.href = url+"/listSiteImages";
							}else{
								BootstrapDialog.show({
									 type: BootstrapDialog.TYPE_WARNING,
									 title: 'Warning',
									 message: resp
								}); 
							}
						}
					});
				}
			 }
		 ]
	});
}

//Delete site Image
function delSiteImage(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('image-id');
	var data = {_token :token,id:id};
	var url = $(obj).data('url')+"/deleteSiteImage";
	BootstrapDialog.show({
		type: BootstrapDialog.TYPE_DANGER,
		title: 'Delete Record',
		message: 'Are you sure you want to delete record ?',
		buttons: [
			 {
				label: 'Yes',
				cssClass: 'btn-danger btn-sm',
				action: function(dialogItself){
					dialogItself.close();
					$.ajax({
						url:url,
						type: 'post',
						data: data,
						success:function(resp){
							if(resp=="success"){
								url = $(obj).data('url');
								window.location.href = url+"/listSiteImages";
							}else{
								BootstrapDialog.show({
									 type: BootstrapDialog.TYPE_WARNING,
									 title: 'Warning',
									 message: resp
								}); 
							}
						}
					});
				}
			 }
		 ]
	});
}

// sites list
if($('#site-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#site-list').DataTable({
		keys: true,
		"aaSorting": [],
		aoColumnDefs: [
			{
				 bSortable: false,
				 aTargets: [ -1 ]
			}
		]
	});
}

//panorama viewer
if($(".panorama").length){
	$(".panorama").panorama_viewer({
		repeat:false,
		direction:"horizontal",
		overlay:true,
		animationTime:700,
		easing:"ease-in"
	});
}

$('[data-toggle="tooltip"]').tooltip({
		placement : 'top'
});
