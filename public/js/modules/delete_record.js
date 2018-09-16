function delRecord(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('id');
	var data = {_token :token,id:id,_method:"DELETE"};
	var url = $(obj).data('url');
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
								window.location.href = location;
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