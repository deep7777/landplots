function delPlot(obj){
	var token = $(obj).data('token');
	var id = $(obj).data('plot-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_plot = $("#list_plot").val();
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
								window.location.href = list_plot;
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

if($('#data-table-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-table-list').DataTable({
		keys: true,
		"aaSorting": [],
		responsive: true,
		aoColumnDefs: [
			{
				 bSortable: false,
				 aTargets: [ -1 ]
			}
		]
	});
}


if($("#frm_book_plot #site_id").length){
	$("#frm_book_plot #site_id").change(function(){
		var url = $("#url").val();
		var site_id = $(this).val();
		if(site_id!=''){
			url = url+"/bookPlot/"+site_id;
			
		}else{
			url = url+"/listPlotBooking";
		}
		window.location.href = url;
	});
}

if($("#frm_book_plot #visitor_id").length){
	$("#frm_book_plot #visitor_id").change(function(){
		var url = $("#url").val();
		var visitor_id = $(this).val();
		url = url+"/getVisitorInfo/"+visitor_id;
		if(visitor_id!==''){
			$.ajax({
				url:url,
				type: 'get',
				dataType: "json",
				success:function(data){
					$.each(data,function(index,val){
						if($("#"+index).length > 0){
							$("#"+index).val(val);
						}
					});
				}
			});
		}else{
			$(".clear-all").val("");
		}
	});
}

function bindBookPlots(){
	$("#frm_book_plot #book_site_plot").change(function(){
		var url = $("#url").val();
		var site_id = $("#frm_book_plot #site_id").val();
		var plot_id = $("#frm_book_plot #book_site_plot").val();
		url = url+"/bookPlot/"+site_id+"/"+plot_id;
		if(site_id!==''&&plot_id!==''){
			window.location.href = url;
			return false
		}
	});
}

$("#frm_book_plot .total_cost").change(function(){
	var url = $("#url").val()+"/plots/getPlotCost";
	var data = $("#frm_book_plot").serialize();
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "json",
		success:function(data){
			$("#plot_basic_cost").val(data.plot_basic_cost);
			$("#plot_total_cost").val(data.plot_total_cost);
			getDownPayment();
		}
	});
});

$("#frm_book_plot #payment_mode").change(function(){
	var url = $("#url").val()+"/plots/getPaymentmode";
	var data = $("#frm_book_plot").serialize();
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

$("#frm_book_plot .down_payment").change(function(){
	getDownPayment();
});

function getDownPayment(){
	var url = $("#url").val()+"/plots/getDownPaymentAmount";
	var data = $("#frm_book_plot").serialize();
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "json",
		success:function(data){
			$("#down_payment_amount").val(data.down_payment_amount);
			$("#balance_amount").val(data.balance_amount);
		}
	});
}

// http://seiyria.com/bootstrap-slider/
function plotNumberSlider(){
	if($) {
			var namespace = $.fn.slider ? 'bootstrapSlider' : 'slider';
			$.bridget(namespace, Slider);
			console.log("slider declarate");
	}else{
		console.log("slider not declared ....");
	}
	
	$("#plotNumberSlider").bootstrapSlider({
    	natural_arrow_keys:"true",
		tooltip:'always',
		scale:'linear',
		focus:'true'
	});
	enableSlider();
}

function enableSlider(){
	$("#plotNumberSlider-enabled").click(function() {
		if(this.checked) {
			$("#plotNumberSlider").bootstrapSlider("enable");
			$("#plot_no").attr("disabled","disabled");
			$("#plot_no").val("0");
		}
		else {
			$("#plotNumberSlider").bootstrapSlider("disable");
			$("#plot_no").removeAttr("disabled");
			$("#plot_no").val("");
		}
	});
}
if($("#plotNumberSlider").length > 0){
	console.log("enable plot number slide ..");
	plotNumberSlider();
}

$("#go_back").click(function(){
	window.history.back();
});

//Invoice
function showInvoiceModal(obj){
	var token = $(obj).data('token');
	var booking_id =  $(obj).data('booking-id');
	var data = {
		_token :token,
		booking_id:booking_id
	};
	var url = $("#url").val()+"/getBookingInvoice";
	$.ajax({
		url:url,
		data:data,
		type: 'post',
		dataType: "html",
		success:function(data){
			$('#invoiceModal').modal("show");
			setTimeout(function(){ 
				$("#frm_invoice").html(data);
				$("#print-invoice").unbind("click");
				$("#print-invoice").click(function(){
					bindInvoice();
				});
				bindInvoiceClose();
			}, 100);
		}
	});	
}

function bindInvoiceClose(){
	$("#close-print-invoice").click(function(){
		$('#invoiceModal').modal('toggle');
		$('.modal-backdrop').remove();
	});
}

function bindInvoice(){
	var divname = $("#frm_invoice");
	var printContents = document.getElementById("frm_invoice").innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    $("#print-invoice").click(function(){
		bindInvoice();
	});
	bindInvoiceClose();
}

function showSmsModal(obj){
	var token = $(obj).data('token');
	var plot_owner =  $(obj).data('plot-owner');
	var plot_owner_mobile_number =  $(obj).data('plot-owner-mobile-number');
	var site_name =  $(obj).data('site-name');
	var plot_no =  $(obj).data('plot-no');
	var data = {
		_token :token,
		site_name:site_name,
		plot_no:plot_no,
		plot_owner:plot_owner,
		mobile_number:plot_owner_mobile_number
	};
	
	$('#smsOwnerModal').modal("show");
	setTimeout(function(){ 
		$("#frm_sms")[0].reset();
		$("#frm_sms #smsName").val(data.plot_owner);
		$("#frm_sms #smsTo").val(data.mobile_number);
		$("#frm_sms #smsSiteName").val(data.site_name);
		$("#frm_sms #smsPlotNo").val(data.plot_no);
	}, 100);
}

function sendSmsToOwner(){
	var data = $("#frm_sms").serialize();
	//console.log("smsToOwner",data);
	$('#smsOwnerModal').modal("hide");
}

$("#frm_sms #sms-to-owner").click(function(){
	//console.log("sms to owner");
	$('#frm_sms').parsley();
	sendSmsToOwner();
	
});

function delBookedPlot(obj){
	var token = $(obj).data('token');
	var plot_booking_id = $(obj).data('plot-booking-id');
	var data = {_token :token,plot_booking_id:plot_booking_id};
	var url = $("#url").val()+"/deleteBookingPlot";
	var list_booking = $("#url").val()+"/listPlotBooking";
	BootstrapDialog.show({
		type: BootstrapDialog.TYPE_WARNING,
		title: 'Delete Record',
		message: '<b>Are you sure you want to delete Booking? Your Booking Record Will be deleted.<br>Click Yes to delete.<b>',
		buttons: [
			{
			 label: 'Yes',
			 action: function(dialogItself){
				 dialogItself.close();
				 $.ajax({
					 url:url,
					 type: 'post',
					 data: data,
					 success:function(resp){
						 if(resp=="success"){
							 window.location.href = list_booking;
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

function delPlotPayment(obj){
	var token = $(obj).data('token');
	var plot_booking_id = $(obj).data('plot-booking-id');
	var plot_payment_id = $(obj).data('plot-payment-id');
	var data = {_token :token,plot_payment_id:plot_payment_id};
	var url = $("#url").val()+"/deletePlotPayment";
	var list_booking = $("#url").val()+"/plotPayment/"+plot_booking_id;
	BootstrapDialog.show({
		type: BootstrapDialog.TYPE_DANGER,
		title: 'Delete Record',
		message: 'Are you sure you want to delete Plot Payment ?',
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
								window.location.href = list_booking;
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

$(".plot_id").click(function(){
	var token = $(this).data('token');
	var plot_id = $(this).val();
	console.log("sddf",$(this).val(),token);
	var data = {_token :token,plot_id:plot_id};
  	var url = $("#url").val()+"/getPlotArea";
	if(plot_id!=''){
		$.ajax({
			url:url,
			type: 'post',
			data: data,
			success:function(resp){
				$("#plot_area").val(resp);
			}
		});
	}else{
		$("#plot_area").val("");
	}
});


$(".plot-emi").click(function(){
	var booking_id = $(this).attr("booking-id");
	var url = $("#url").val()+"/plotBookingEmi/"+booking_id
	window.location.href= url;
});

if($("#pieChartOfSoldPlots").length){
	getSiteSoldPlotsStats();
}

function getSiteSoldPlotsStats(){
 	var url = $("#url").val()+"/getSiteSoldPlotsStats";
 	var data = [];
	$.ajax({
		url:url,
		type: 'get',
		data: data,
		dataType:'json',
		success:function(resp){
			var data = resp['columns'];
			var site = [];
			$.each(data,function(index,val){
				site.push([index,val]);
			});
			var chart = c3.generate({
				size: {
				  width: 300,
				  height: 300
				},
				bindto: '#pieChartOfSoldPlots',
				legend: {
				  show: true,
				  position:"right"
				},
				tooltip: {
				  show: false
				},
			     data: {
			        columns: site,
			        type: 'pie',
			        labels: true
			    },
			    type:"pie",
			    pie: {
			        label: {
			            format: function (value, ratio, id) {
			                return d3.format("")(value);
			            }
			        }
			    },
			    'mouseover':function (id) {
			        chart.focus(id);
			    }
			});

		}
	});
};
