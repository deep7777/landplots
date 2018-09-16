if($("#frm_purchase_order_list #purchase_order_site_id").length >0){
	$("#frm_purchase_order_list #purchase_order_site_id").change(function(){
		var site_id = $(this).val();
		if(site_id!==""){
			var url = $("#url").val()+"/addPurchaseOrder/"+site_id;
			window.location.href=url;
		}
	});
}