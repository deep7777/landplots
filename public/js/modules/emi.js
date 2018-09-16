$("#frm_book_plot #btn_emi").click(function(){
	var url = $("#url").val()+"/plots/getEmiInstallments";
	var data = $("#frm_book_plot").serialize();
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "html",
		success:function(data){
			$(".emi_installments").html(data);
		}
	});
});

function updateEmiStatus(emi_id){
	console.log($("#frm_emi_"+emi_id).serialize());
	var url = $("#url").val()+"/updateEmiStatus";
	var data = $("#frm_emi_"+emi_id).serialize();
	var booking_id = $("#frm_emi_"+emi_id).find("#booking_id").val();
	var goto_url = $("#url").val()+"/plotPayment/"+booking_id;
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "html",
		success:function(data){
			window.location.href = goto_url;
		}
	});
}

function bindAddEmi(){
	$("#frm_booking_emi #btn_add_emi").click(function(){
		var url = $("#url").val()+"/setEmi";
		var data = $("#frm_booking_emi").serialize();
		$.ajax({
			url:url,
			data:data,
			type: 'post',
			dataType: "json",
			success:function(data){
				$("#btn_add_emi").hide();
				$("#emi-added").show();
				window.location.href = location.href;
			}
		});
	});
}

$("#go_back_emi").click(function(){
	var url = $("#url").val()+"/listPlotBooking";
	window.location.href = url;
});

$("#frm_booking_emi #btn_emi").click(function(){
	var url = $("#url").val()+"/plots/getBookingEmiInstallments";
	var data = $("#frm_booking_emi").serialize();
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "html",
		success:function(data){
			$(".emi_installments").html(data);
			bindAddEmi();
		}
	});
});