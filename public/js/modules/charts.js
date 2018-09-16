var cols = [1,2,3,4,5,6,7,8,9,10,11,12];
var data = [
    { name: '1', data: cols },
    { name: '2', data: cols },
		{ name: '3', data: cols },
    { name: '4', data: cols },
		{ name: '5', data: cols },
    { name: '6', data: cols },
		{ name: '7', data: cols },
		{ name: '8', data: cols },
    { name: '9', data: cols },
		{ name: '10', data: cols },
    { name: '11', data: cols },
		{ name: '12', data: cols },
    { name: '13', data: cols }
]

var colourScale = ['#5FB65F','#FF7F0E','#1F77B4']
var svg = d3.select('#plot_chart').append('svg').attr('width', 800).attr('height', 700);
svg.selectAll('rect')
    .data(data)
		.enter().append('g')
    .each(function(d,i){
        d3.select(this).selectAll('rect')
        .data(d.data)
				.enter().append('rect')
        .attr('x', function(d,j) { return j*50; })
        .attr('y', function() { return i*50; })
        .attr('width', function() { return 30; })
        .attr('height', function() { return 30; })
        .attr('fill', function(d,j) { console.log(d); return '#5FB65F'; })
			  .append("text")
				.on('click', function(d, i){
					console.log("X:" + d.x, "Y:" + d.y+" "+d)
					//d3.select(this).style("fill", "red");
					//return
				}) ;
    });
		
var cols_sold = [1,2,3,4,5,6,7,8,9,10];
var data_sold = [
    { name: '1', data: cols_sold },
    { name: '2', data: cols_sold },
		{ name: '3', data: cols_sold },
    { name: '4', data: cols_sold }
]

var colourScale = ['#5FB65F','#FF7F0E','#1F77B4']
var svg = d3.select('#plot_sold').append('svg').attr('width', 800).attr('height', 300);
svg.selectAll('rect')
    .data(data_sold)
		.enter().append('g')
    .each(function(d,i){
        d3.select(this).selectAll('rect')
        .data(d.data)
				.enter().append('rect')
        .attr('x', function(d,j) { return j*50; })
        .attr('y', function() { return i*50; })
        .attr('width', function() { return 30; })
        .attr('height', function() { return 30; })
        .attr('fill', function(d,j) { console.log(d); return '#FF7F0E'; })
			  .append("text")
				.on('click', function(d, i){
					console.log("X:" + d.x, "Y:" + d.y+" "+d)
					//d3.select(this).style("fill", "red");
					//return
				}) ;
    });
		
//svg.on("click", function() {
//  console.log("rect");
//  console.log($(this));
//});		
				
//svg.on("click", function() {
//  console.log("rect");
//  console.log($(this));
//});		
		