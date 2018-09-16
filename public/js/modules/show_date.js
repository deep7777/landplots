if ($(".date_class").length) {
	$('.date_class').datetimepicker({
		format: 'd/m/Y',
		timepicker: false,
		scrollInput : false,
		autoclose: true
	});
}

function bindDate(){
	if ($(".date_class").length) {
		$('.date_class').datetimepicker({
			format: 'd/m/Y',
			timepicker: false,
			scrollInput : false,
			autoclose: true
		});
	}
}

if($('input.month-picker').length){
	$('input.month-picker').monthpicker({
		changeYear: true,
		onClose:""
	});
	//https://www.npmjs.com/package/jquery-ui-monthpicker
}

if ($(".year_class").length) {
		$('.year_class').datetimepicker({
			format: 'Y',
			dateFormat: 'yy',
			timepicker: false,
			scrollInput : false,
			autoclose: true
		});
	}