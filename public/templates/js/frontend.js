var links = ["home","aboutus","projects","contactus"];
$.each(links,function(index,value){
	$("#"+value).removeClass("active");
});

$("#btn_contact_us").click(function(){
	var url = $("#url").val();
	url = url+"/sendContactEnquiry";
	var data = $("#main-contact-form").serialize();
	console.log(url,data);
	$.ajax({
		url:url,
		type: 'post',
		data:data,
		dataType: "html",
		success:function(resp){
			$("#contact_msg").html(resp);
			$("#contact_msg").show();
		}
	});
});