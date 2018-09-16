if($("#site_id_partner").length){
	$("#site_id_partner").change(function(){
		var url = $("#url").val();
		window.location.href = url+"/addPartner/"+$(this).val();
	});
}

$("#frm_partner_payment #payment_mode").change(function(){
	var url = $("#url").val()+"/partner/getPaymentmode";
	var data = $("#frm_partner_payment").serialize();
	var payment_mode = $(this).val();
	$(".payment_option_fields").remove();
	if(payment_mode > 1){
		$.ajax({
			url:url,
			data:data,
			type: 'post',
			dataType: "html",
			success:function(data){
				$(".payment_mode_fields").after(data);
				bindDate();
			}
		});
	}else{
		$(".payment_option_fields").remove();
	}
});

if($("#frm_partner #partner_amount").length){
	$("#frm_partner #partner_amount").change(function(){
		var url = $("#url").val()+"/getPartnerPercentage";
		var data = $("#frm_partner").serialize("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			success:function(resp){
				$("#partner_percentage").val(resp);
			}
		});
	});	
}

if($("#frm_partner #partner_percentage").length){
	$("#frm_partner #partner_percentage").change(function(){
		var url = $("#url").val()+"/getPartnerAmount";
		var data = $("#frm_partner").serialize("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			success:function(resp){
				$("#partner_amount").val(resp);
			}
		});
	});	
}

function delSitePartner(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('id');
	var data = {_token :token,id:id};
	var url = $("#url").val()+"/delSitePartner";
	var listPartners = $("#url").val()+"/listPartners";
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
								window.location.href = listPartners;
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