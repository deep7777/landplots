if($('#data-keytable-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-keytable-list').DataTable({
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

if($('#data-list').length){
    /*$.fn.dataTable.moment( 'D/M/YYYY'); 
	var data_list = $('#data-list').DataTable({
		keys: true,
		"aaSorting": []
	});*/
}