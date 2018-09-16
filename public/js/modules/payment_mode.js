$("#frm_salary #payment_mode").change(function(){
	var url = $("#url").val()+"/plots/getPaymentmode";
	if($('#frm_salary input[name=_method]').length){
		$('#frm_salary input[name=_method]').val("POST");
	}
	var data = $("#frm_salary").serialize();
	if(data["_method"] == "PUT"){
		data["_method"] == "POST";
	}
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
				if($('#frm_salary input[name=_method]').length){
					$('#frm_salary input[name=_method]').val("PUT");
				}
			}
		});
	}else{
		$(".payment_option_fields").remove();
		if($('#frm_salary input[name=_method]').length){
			$('#frm_salary input[name=_method]').val("PUT");
		}
	}
});
