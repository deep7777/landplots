var chart = c3.generate({
    data: {
        x : 'x',
        columns: [
            ['x', 'Site A', 'Site B', 'Site C', 'Site D','Site E','Site F','Site G','Site H',"Site M"],
            ['Total Plots', 100, 200, 200, 400,200,300,400,200,100],
            ['Sold Plots', 30, 100, 140, 200,100,200,300,100,20],
						['Available Plots', 70, 100, 60, 200,100,100,100,100,80]
        ],
				labels: {
					format: {
						'Total Plots': function (v, id) {return v; },
						'Sold Plots': function (v, id) { return v; },
						'Available Plots': function (v, id) { return v; }
					}
				},
        type: 'bar',
				onclick:function(d,element){
					console.log(d,element,d.data_columns);
					console.log(d,element);
				}
    },
    axis: {
        x: {
					  label: 'Sites',
            type: 'category'
        },
				y: {
					label: 'Plots'
        }
    }
});
if($("#go_to_dashboard").length){
	$("#go_to_dashboard").click(function(){
		var url = $(this).data("url");
		window.location.href = url;
	});
}