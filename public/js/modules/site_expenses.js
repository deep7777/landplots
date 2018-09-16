$("#frm_site_expense #payment_mode").change(function(){
	var url = $("#url").val()+"/getSiteExpensePaymentMode";
	var payment_mode = $(this).val();
	$(".payment_option_fields").remove();
	var data = {};
	data.payment_mode = payment_mode;
	data["_token"] = $("input[name=_token]").val();
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

$("#frm_expense #payment_mode").change(function(){
	var url = $("#url").val()+"/getExpensePaymentMode";
	var payment_mode = $(this).val();
	$(".payment_option_fields").remove();
	var data = {};
	data.payment_mode = payment_mode;
	data["_token"] = $("input[name=_token]").val();
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