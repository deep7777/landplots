if($('#staff-list').length){
	$('#staff-list').DataTable({
		keys: true,
		aoColumnDefs: [
			{
				 bSortable: false,
				 aTargets: [ -1 ]
			}
		]
	});
}

$(".delStaff").click(function(){
	var token = $(this).data('token');
	var id = $(this).data('staff-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_staff = $("#list_staff").val();
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
								window.location.href = list_staff;
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
});