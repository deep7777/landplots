function delContractor(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('contractor-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_contractor = $("#list_contractor").val();
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
								window.location.href = list_contractor;
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

function delContractorCustomer(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('contractor-customer-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_contractor_customer = $("#list_contractor_customer").val();
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
								window.location.href = list_contractor_customer;
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

if($('#contractor-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#contractor-list').DataTable({
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

if($("#contractor_date").length){
	$('#contractor_date').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}