$(".area").change(function(){
	getTotalCost();
});

$(".rate_per_sqft").change(function(){
	getTotalCost();
});

$(".total_cost").change(function(){
	getTotalCost();
});

function getTotalCost(){
	if($(".area").length && $(".rate_per_sqft").length){
		var area = $(".area").val();
		var rate_per_sqft = $(".rate_per_sqft").val();
		var total_cost = parseFloat(area) * parseInt(rate_per_sqft);
		if(isNumeric(total_cost)){
			$(".total_cost").val(total_cost);
		}
	}
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
