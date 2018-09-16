if($("#visited_on").length){
	$('#visited_on').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}

if($('#visitor-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#visitor-list').DataTable({
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

if($(".visitor_site_id").length){
	$( ".visitor_site_id" )
  .change(function () {
    var visitor_site_id = $( ".visitor_site_id option:selected" ).val();
    $("#visitor_site_id").val(visitor_site_id);
  });
}

if($(".visitor_media_id").length){
	$( ".visitor_media_id" )
  .change(function () {
    var media_id = $( ".visitor_media_id option:selected" ).val();
    $("#visitor_media_id").val(media_id);
  });
}


function delVisitor(obj){
	console.log("delete visitor");
	var token = $(obj).data('token');
	var id = $(obj).data('visitor-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_visitor = $("#list_visitor").val();
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
								window.location.href = list_visitor;
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
