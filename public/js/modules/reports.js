function datalist(){
	$.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-list').DataTable({
		"lengthMenu": [100,500],
		keys: true,
		"aaSorting": [],
		responsive: true,
		dom: "Blfrtip",
		buttons: [
			{
				extend: "print",
				text: 'Print Report',
				className: "btn-sm btn-info"
			}
		]
	});
}

//Employee Salart Report
$("#employee_salary_report").click(function(){
	var url = $("#url").val()+"/reports/getEmployeeSalaryReport";
	var data = $("#frm_employee_salary_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".employee_salary_report_data").html(data);
			datalist();
		}
	});
});


//Site Expense Report Reset
if($("#frm_employee_salary_report .reset").length){
	$("#frm_employee_salary_report .reset").click(function(){
		$("#frm_employee_salary_report")[0].reset();
		$(".employee_salary_report_data").html("");
	});
}

//Site Expense Report
$("#frm_site_expense_report #site_expense_report").click(function(){
	var url = $("#url").val()+"/reports/getSiteExpenseReport";
	var data = $("#frm_site_expense_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".site_expense_report_data").html(data);
			datalist();
		}
	});
});

//Site Expense Report Reset
if($("#frm_site_expense_report .reset").length){
	$("#frm_site_expense_report .reset").click(function(){
		$("#frm_site_expense_report")[0].reset();
		$(".vendors").html("");
	});
}

//Site Vendors
if($("#frm_site_expense_report #site_id").length){
	$("#frm_site_expense_report #site_id").change(function(){
		var url = $("#url").val()+"/reports/getSiteVendors";
		var data = $("#frm_site_expense_report").serialize();
		$(".vendors").html("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'html',
			success:function(data){
				$(".vendors").html(data);
				$(".site_expense_report_data").html("");
				datalist();
			}
		});
	});
}


if($("#frm_site_expense_report .reset").length){
	$("#frm_site_expense_report .reset").click(function(){
		$("#frm_site_expense_report")[0].reset();
		$(".vendors").html("");
	});
}

//Plot Payments Report Reset
if($("#frm_plot_payments_report .reset").length){
	$("#frm_plot_payments_report .reset").click(function(){
		$("#frm_plot_payments_report")[0].reset();
	});
}

//Plot Payments Report
$("#frm_plot_payments_report #plot_payments_report").click(function(){
	var url = $("#url").val()+"/reports/getPlotPaymentsReport";
	var data = $("#frm_plot_payments_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".plot_payments_report_data").html(data);
			datalist();
		}
	});
});

//Company Expense Report
$("#frm_company_expense_report #company_expense_report").click(function(){
	var url = $("#url").val()+"/reports/getCompanyExpenseReport";
	var data = $("#frm_company_expense_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".company_expense_report_data").html(data);
			datalist();
		}
	});
});

//Company Expense Report Reset
if($("#frm_company_expense_report .reset").length){
	$("#frm_company_expense_report .reset").click(function(){
		$("#frm_company_expense_report")[0].reset();
		$("#frm_company_expense_report .vendors").html("");
	});
}

//Plot Booking Report Reset
if($("#frm_booked_plot_report .reset").length){
	$("#frm_booked_plot_report .reset").click(function(){
	  $("#frm_booked_plot_report")[0].reset();
	  $("#frm_booked_plot_report .plot_booking_report_data").html("");
	});
}

//Plot Booking Report
$("#frm_booked_plot_report #get_plot_booking_report").click(function(){
	var url = $("#url").val()+"/reports/getPlotBookingReport";
	var data = $("#frm_booked_plot_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".plot_booking_report_data").html(data);
			datalist();
		}
	});
});


if($('#data-list-sold-plots').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	var data_list_sp = $('#data-list-sold-plots').DataTable({
		keys: true,
		"aaSorting": [],
		"aoColumnDefs" : [
		 {
		   'bSearchable':false,
		   'bSortable' : false,
		   'aTargets' : [2,3,4]
		 }],
	});

	$(".search-plot-owner").click(function(){
		var plot_no = $(this).attr("plot-no");
		$("input[type=search]").val(plot_no).focus();
		data_list_sp.search(plot_no).draw();
	});
}

//Payment Reminder Report
$("#frm_payment_reminder #get_payment_reminder_report").click(function(){
	getPaymentReminderReport();
});

function getPaymentReminderReport(){
	var url = $("#url").val()+"/reports/getPaymentRemindersReport";
	var data = $("#frm_payment_reminder").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".payment_reminder_report_data").html(data);
			datalist();
		}
	});
}

if($(".payment_reminder_report_data").length){
	getPaymentReminderReport();
}

//Reminder Report Reset
if($("#frm_payment_reminder .reset").length){
	$("#frm_payment_reminder .reset").click(function(){
	  $("#frm_payment_reminder")[0].reset();
	  $("#frm_payment_reminder .payment_reminder_report_data").html("");
	});
}