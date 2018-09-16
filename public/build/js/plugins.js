/*!
 * d3pie
 * @author Ben Keen
 * @version 0.1.9
 * @date June 17th, 2015
 * @repo http://github.com/benkeen/d3pie
 */

// UMD pattern from https://github.com/umdjs/umd/blob/master/returnExports.js
(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module
    define([], factory);
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but only CommonJS-like environments that support module.exports,
    // like Node
    module.exports = factory();
  } else {
    // browser globals (root is window)
    root.d3pie = factory(root);
  }
}(this, function() {

	var _scriptName = "d3pie";
	var _version = "0.2.1";

	// used to uniquely generate IDs and classes, ensuring no conflict between multiple pies on the same page
	var _uniqueIDCounter = 0;


	// this section includes all helper libs on the d3pie object. They're populated via grunt-template. Note: to keep
	// the syntax highlighting from getting all messed up, I commented out each line. That REQUIRES each of the files
	// to have an empty first line. Crumby, yes, but acceptable.
	//// --------- _default-settings.js -----------/**
/**
 * Contains the out-the-box settings for the script. Any of these settings that aren't explicitly overridden for the
 * d3pie instance will inherit from these. This is also included on the main website for use in the generation script.
 */
var defaultSettings = {
	header: {
		title: {
			text:     "",
			color:    "#333333",
			fontSize: 18,
			font:     "arial"
		},
		subtitle: {
			text:     "",
			color:    "#666666",
			fontSize: 14,
			font:     "arial"
		},
		location: "top-center",
		titleSubtitlePadding: 8
	},
	footer: {
		text: 	  "",
		color:    "#666666",
		fontSize: 14,
		font:     "arial",
		location: "left"
	},
	size: {
		canvasHeight: 500,
		canvasWidth: 500,
		pieInnerRadius: "0%",
		pieOuterRadius: null
	},
	data: {
		sortOrder: "none",
		ignoreSmallSegments: {
			enabled: false,
			valueType: "percentage",
			value: null
		},
		smallSegmentGrouping: {
			enabled: false,
			value: 1,
			valueType: "percentage",
			label: "Other",
			color: "#cccccc"
		},
		content: []
	},
	labels: {
		outer: {
			format: "label",
			hideWhenLessThanPercentage: null,
			pieDistance: 30
		},
		inner: {
			format: "percentage",
			hideWhenLessThanPercentage: null
		},
		mainLabel: {
			color: "#333333",
			font: "arial",
			fontSize: 10
		},
		percentage: {
			color: "#dddddd",
			font: "arial",
			fontSize: 10,
			decimalPlaces: 0
		},
		value: {
			color: "#cccc44",
			font: "arial",
			fontSize: 10
		},
		lines: {
			enabled: true,
			style: "curved",
			color: "segment"
		},
		truncation: {
			enabled: false,
			truncateLength: 30
		},
    formatter: null
	},
	effects: {
		load: {
			effect: "default",
			speed: 1000
		},
		pullOutSegmentOnClick: {
			effect: "bounce",
			speed: 300,
			size: 10
		},
		highlightSegmentOnMouseover: true,
		highlightLuminosity: -0.2
	},
	tooltips: {
		enabled: false,
		type: "placeholder", // caption|placeholder
    string: "",
    placeholderParser: null,
		styles: {
      fadeInSpeed: 250,
			backgroundColor: "#000000",
      backgroundOpacity: 0.5,
			color: "#efefef",
      borderRadius: 2,
      font: "arial",
      fontSize: 10,
      padding: 4
		}
	},
	misc: {
		colors: {
			background: null,
			segments: [
				"#2484c1", "#65a620", "#7b6888", "#a05d56", "#961a1a", "#d8d23a", "#e98125", "#d0743c", "#635222", "#6ada6a",
				"#0c6197", "#7d9058", "#207f33", "#44b9b0", "#bca44a", "#e4a14b", "#a3acb2", "#8cc3e9", "#69a6f9", "#5b388f",
				"#546e91", "#8bde95", "#d2ab58", "#273c71", "#98bf6e", "#4daa4b", "#98abc5", "#cc1010", "#31383b", "#006391",
				"#c2643f", "#b0a474", "#a5a39c", "#a9c2bc", "#22af8c", "#7fcecf", "#987ac6", "#3d3b87", "#b77b1c", "#c9c2b6",
				"#807ece", "#8db27c", "#be66a2", "#9ed3c6", "#00644b", "#005064", "#77979f", "#77e079", "#9c73ab", "#1f79a7"
			],
			segmentStroke: "#ffffff"
		},
		gradient: {
			enabled: false,
			percentage: 95,
			color: "#000000"
		},
		canvasPadding: {
			top: 5,
			right: 5,
			bottom: 5,
			left: 5
		},
		pieCenterOffset: {
			x: 0,
			y: 0
		},
		cssPrefix: null
	},
	callbacks: {
		onload: null,
		onMouseoverSegment: null,
		onMouseoutSegment: null,
		onClickSegment: null
	}
};

	//// --------- validate.js -----------
var validate = {

	// called whenever a new pie chart is created
	initialCheck: function(pie) {
		var cssPrefix = pie.cssPrefix;
		var element = pie.element;
		var options = pie.options;

		// confirm d3 is available [check minimum version]
		if (!window.d3 || !window.d3.hasOwnProperty("version")) {
			console.error("d3pie error: d3 is not available");
			return false;
		}

		// confirm element is either a DOM element or a valid string for a DOM element
		if (!(element instanceof HTMLElement || element instanceof SVGElement)) {
			console.error("d3pie error: the first d3pie() param must be a valid DOM element (not jQuery) or a ID string.");
			return false;
		}

		// confirm the CSS prefix is valid. It has to start with a-Z and contain nothing but a-Z0-9_-
		if (!(/[a-zA-Z][a-zA-Z0-9_-]*$/.test(cssPrefix))) {
			console.error("d3pie error: invalid options.misc.cssPrefix");
			return false;
		}

		// confirm some data has been supplied
		if (!helpers.isArray(options.data.content)) {
			console.error("d3pie error: invalid config structure: missing data.content property.");
			return false;
		}
		if (options.data.content.length === 0) {
			console.error("d3pie error: no data supplied.");
			return false;
		}

		// clear out any invalid data. Each data row needs a valid positive number and a label
		var data = [];
		for (var i=0; i<options.data.content.length; i++) {
			if (typeof options.data.content[i].value !== "number" || isNaN(options.data.content[i].value)) {
				console.log("not valid: ", options.data.content[i]);
				continue;
			}
			if (options.data.content[i].value <= 0) {
				console.log("not valid - should have positive value: ", options.data.content[i]);
				continue;
			}
			data.push(options.data.content[i]);
		}
		pie.options.data.content = data;

		// labels.outer.hideWhenLessThanPercentage - 1-100
		// labels.inner.hideWhenLessThanPercentage - 1-100

		return true;
	}
};

	//// --------- helpers.js -----------
var helpers = {

	// creates the SVG element
	addSVGSpace: function(pie) {
		var element = pie.element;
		var canvasWidth = pie.options.size.canvasWidth;
		var canvasHeight = pie.options.size.canvasHeight;
		var backgroundColor = pie.options.misc.colors.background;

		var svg = d3.select(element).append("svg:svg")
			.attr("width", canvasWidth)
			.attr("height", canvasHeight);

		if (backgroundColor !== "transparent") {
			svg.style("background-color", function() { return backgroundColor; });
		}

		return svg;
	},

	whenIdExists: function(id, callback) {
		var inc = 1;
		var giveupIterationCount = 1000;

		var interval = setInterval(function() {
			if (document.getElementById(id)) {
				clearInterval(interval);
				callback();
			}
			if (inc > giveupIterationCount) {
				clearInterval(interval);
			}
			inc++;
		}, 1);
	},

	whenElementsExist: function(els, callback) {
		var inc = 1;
		var giveupIterationCount = 1000;

		var interval = setInterval(function() {
			var allExist = true;
			for (var i=0; i<els.length; i++) {
				if (!document.getElementById(els[i])) {
					allExist = false;
					break;
				}
			}
			if (allExist) {
				clearInterval(interval);
				callback();
			}
			if (inc > giveupIterationCount) {
				clearInterval(interval);
			}
			inc++;
		}, 1);
	},

	shuffleArray: function(array) {
		var currentIndex = array.length, tmpVal, randomIndex;

		while (0 !== currentIndex) {
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;

			// and swap it with the current element
			tmpVal = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = tmpVal;
		}
		return array;
	},

	processObj: function(obj, is, value) {
		if (typeof is === 'string') {
			return helpers.processObj(obj, is.split('.'), value);
		} else if (is.length === 1 && value !== undefined) {
            obj[is[0]] = value;
			return obj[is[0]];
		} else if (is.length === 0) {
			return obj;
		} else {
			return helpers.processObj(obj[is[0]], is.slice(1), value);
		}
	},

	getDimensions: function(id) {
		var el = document.getElementById(id);
		var w = 0, h = 0;
		if (el) {
			var dimensions = el.getBBox();
			w = dimensions.width;
			h = dimensions.height;
		} else {
			console.log("error: getDimensions() " + id + " not found.");
		}
		return { w: w, h: h };
	},

	/**
	 * This is based on the SVG coordinate system, where top-left is 0,0 and bottom right is n-n.
	 * @param r1
	 * @param r2
	 * @returns {boolean}
	 */
	rectIntersect: function(r1, r2) {
		var returnVal = (
			// r2.left > r1.right
			(r2.x > (r1.x + r1.w)) ||

			// r2.right < r1.left
			((r2.x + r2.w) < r1.x) ||

			// r2.top < r1.bottom
			((r2.y + r2.h) < r1.y) ||

			// r2.bottom > r1.top
			(r2.y > (r1.y + r1.h))
		);

		return !returnVal;
	},

	/**
	 * Returns a lighter/darker shade of a hex value, based on a luminance value passed.
	 * @param hex a hex color value such as “#abc” or “#123456″ (the hash is optional)
	 * @param lum the luminosity factor: -0.1 is 10% darker, 0.2 is 20% lighter, etc.
	 * @returns {string}
	 */
	getColorShade: function(hex, lum) {

		// validate hex string
		hex = String(hex).replace(/[^0-9a-f]/gi, '');
		if (hex.length < 6) {
			hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
		}
		lum = lum || 0;

		// convert to decimal and change luminosity
		var newHex = "#";
		for (var i=0; i<3; i++) {
			var c = parseInt(hex.substr(i * 2, 2), 16);
			c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
			newHex += ("00" + c).substr(c.length);
		}

		return newHex;
	},

	/**
	 * Users can choose to specify segment colors in three ways (in order of precedence):
	 * 	1. include a "color" attribute for each row in data.content
	 * 	2. include a misc.colors.segments property which contains an array of hex codes
	 * 	3. specify nothing at all and rely on this lib provide some reasonable defaults
	 *
	 * This function sees what's included and populates this.options.colors with whatever's required
	 * for this pie chart.
	 * @param data
	 */
	initSegmentColors: function(pie) {
		var data   = pie.options.data.content;
		var colors = pie.options.misc.colors.segments;

		// TODO this needs a ton of error handling

		var finalColors = [];
		for (var i=0; i<data.length; i++) {
			if (data[i].hasOwnProperty("color")) {
				finalColors.push(data[i].color);
			} else {
				finalColors.push(colors[i]);
			}
		}

		return finalColors;
	},

	applySmallSegmentGrouping: function(data, smallSegmentGrouping) {
		var totalSize;
		if (smallSegmentGrouping.valueType === "percentage") {
			totalSize = math.getTotalPieSize(data);
		}

		// loop through each data item
		var newData = [];
		var groupedData = [];
		var totalGroupedData = 0;
		for (var i=0; i<data.length; i++) {
			if (smallSegmentGrouping.valueType === "percentage") {
				var dataPercent = (data[i].value / totalSize) * 100;
				if (dataPercent <= smallSegmentGrouping.value) {
					groupedData.push(data[i]);
					totalGroupedData += data[i].value;
					continue;
				}
				data[i].isGrouped = false;
				newData.push(data[i]);
			} else {
				if (data[i].value <= smallSegmentGrouping.value) {
					groupedData.push(data[i]);
					totalGroupedData += data[i].value;
					continue;
				}
				data[i].isGrouped = false;
				newData.push(data[i]);
			}
		}

		// we're done! See if there's any small segment groups to add
		if (groupedData.length) {
			newData.push({
				color: smallSegmentGrouping.color,
				label: smallSegmentGrouping.label,
				value: totalGroupedData,
				isGrouped: true,
				groupedData: groupedData
			});
		}

		return newData;
	},

	// for debugging
	showPoint: function(svg, x, y) {
		svg.append("circle").attr("cx", x).attr("cy", y).attr("r", 2).style("fill", "black");
	},

	isFunction: function(functionToCheck) {
		var getType = {};
		return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
	},

	isArray: function(o) {
		return Object.prototype.toString.call(o) === '[object Array]';
	}
};


// taken from jQuery
var extend = function() {
	var options, name, src, copy, copyIsArray, clone, target = arguments[0] || {},
		i = 1,
		length = arguments.length,
		deep = false,
		toString = Object.prototype.toString,
		hasOwn = Object.prototype.hasOwnProperty,
		class2type = {
			"[object Boolean]": "boolean",
			"[object Number]": "number",
			"[object String]": "string",
			"[object Function]": "function",
			"[object Array]": "array",
			"[object Date]": "date",
			"[object RegExp]": "regexp",
			"[object Object]": "object"
		},

		jQuery = {
			isFunction: function (obj) {
				return jQuery.type(obj) === "function";
			},
			isArray: Array.isArray ||
				function (obj) {
					return jQuery.type(obj) === "array";
				},
			isWindow: function (obj) {
				return obj !== null && obj === obj.window;
			},
			isNumeric: function (obj) {
				return !isNaN(parseFloat(obj)) && isFinite(obj);
			},
			type: function (obj) {
				return obj === null ? String(obj) : class2type[toString.call(obj)] || "object";
			},
			isPlainObject: function (obj) {
				if (!obj || jQuery.type(obj) !== "object" || obj.nodeType) {
					return false;
				}
				try {
					if (obj.constructor && !hasOwn.call(obj, "constructor") && !hasOwn.call(obj.constructor.prototype, "isPrototypeOf")) {
						return false;
					}
				} catch (e) {
					return false;
				}
				var key;
				for (key in obj) {}
				return key === undefined || hasOwn.call(obj, key);
			}
		};
	if (typeof target === "boolean") {
		deep = target;
		target = arguments[1] || {};
		i = 2;
	}
	if (typeof target !== "object" && !jQuery.isFunction(target)) {
		target = {};
	}
	if (length === i) {
		target = this;
		--i;
	}
	for (i; i < length; i++) {
		if ((options = arguments[i]) !== null) {
			for (name in options) {
				src = target[name];
				copy = options[name];
				if (target === copy) {
					continue;
				}
				if (deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = jQuery.isArray(copy)))) {
					if (copyIsArray) {
						copyIsArray = false;
						clone = src && jQuery.isArray(src) ? src : [];
					} else {
						clone = src && jQuery.isPlainObject(src) ? src : {};
					}
					// WARNING: RECURSION
					target[name] = extend(deep, clone, copy);
				} else if (copy !== undefined) {
					target[name] = copy;
				}
			}
		}
	}
	return target;
};
	//// --------- math.js -----------
var math = {

	toRadians: function(degrees) {
		return degrees * (Math.PI / 180);
	},

	toDegrees: function(radians) {
		return radians * (180 / Math.PI);
	},

	computePieRadius: function(pie) {
		var size = pie.options.size;
		var canvasPadding = pie.options.misc.canvasPadding;

		// outer radius is either specified (e.g. through the generator), or omitted altogether
		// and calculated based on the canvas dimensions. Right now the estimated version isn't great - it should
		// be possible to calculate it to precisely generate the maximum sized pie, but it's fussy as heck. Something
		// for the next release.

		// first, calculate the default _outerRadius
		var w = size.canvasWidth - canvasPadding.left - canvasPadding.right;
		var h = size.canvasHeight - canvasPadding.top - canvasPadding.bottom;

		// now factor in the footer, title & subtitle
		if (pie.options.header.location !== "pie-center") {
			h -= pie.textComponents.headerHeight;
		}

		if (pie.textComponents.footer.exists) {
			h -= pie.textComponents.footer.h;
		}

		// for really teeny pies, h may be < 0. Adjust it back
		h = (h < 0) ? 0 : h;

		var outerRadius = ((w < h) ? w : h) / 3;
		var innerRadius, percent;

		// if the user specified something, use that instead
		if (size.pieOuterRadius !== null) {
			if (/%/.test(size.pieOuterRadius)) {
				percent = parseInt(size.pieOuterRadius.replace(/[\D]/, ""), 10);
				percent = (percent > 99) ? 99 : percent;
				percent = (percent < 0) ? 0 : percent;

				var smallestDimension = (w < h) ? w : h;

				// now factor in the label line size
				if (pie.options.labels.outer.format !== "none") {
					var pieDistanceSpace = parseInt(pie.options.labels.outer.pieDistance, 10) * 2;
					if (smallestDimension - pieDistanceSpace > 0) {
						smallestDimension -= pieDistanceSpace;
					}
				}

				outerRadius = Math.floor((smallestDimension / 100) * percent) / 2;
			} else {
				outerRadius = parseInt(size.pieOuterRadius, 10);
			}
		}

		// inner radius
		if (/%/.test(size.pieInnerRadius)) {
			percent = parseInt(size.pieInnerRadius.replace(/[\D]/, ""), 10);
			percent = (percent > 99) ? 99 : percent;
			percent = (percent < 0) ? 0 : percent;
			innerRadius = Math.floor((outerRadius / 100) * percent);
		} else {
			innerRadius = parseInt(size.pieInnerRadius, 10);
		}

		pie.innerRadius = innerRadius;
		pie.outerRadius = outerRadius;
	},

	getTotalPieSize: function(data) {
		var totalSize = 0;
		for (var i=0; i<data.length; i++) {
			totalSize += data[i].value;
		}
		return totalSize;
	},

	sortPieData: function(pie) {
		var data                 = pie.options.data.content;
		var sortOrder            = pie.options.data.sortOrder;

		switch (sortOrder) {
			case "none":
				// do nothing
				break;
			case "random":
				data = helpers.shuffleArray(data);
				break;
			case "value-asc":
				data.sort(function(a, b) { return (a.value < b.value) ? -1 : 1; });
				break;
			case "value-desc":
				data.sort(function(a, b) { return (a.value < b.value) ? 1 : -1; });
				break;
			case "label-asc":
				data.sort(function(a, b) { return (a.label.toLowerCase() > b.label.toLowerCase()) ? 1 : -1; });
				break;
			case "label-desc":
				data.sort(function(a, b) { return (a.label.toLowerCase() < b.label.toLowerCase()) ? 1 : -1; });
				break;
		}

		return data;
	},

	// var pieCenter = math.getPieCenter();
	getPieTranslateCenter: function(pieCenter) {
		return "translate(" + pieCenter.x + "," + pieCenter.y + ")";
	},

	/**
	 * Used to determine where on the canvas the center of the pie chart should be. It takes into account the
	 * height and position of the title, subtitle and footer, and the various paddings.
	 * @private
	 */
	calculatePieCenter: function(pie) {
		var pieCenterOffset = pie.options.misc.pieCenterOffset;
		var hasTopTitle    = (pie.textComponents.title.exists && pie.options.header.location !== "pie-center");
		var hasTopSubtitle = (pie.textComponents.subtitle.exists && pie.options.header.location !== "pie-center");

		var headerOffset = pie.options.misc.canvasPadding.top;
		if (hasTopTitle && hasTopSubtitle) {
			headerOffset += pie.textComponents.title.h + pie.options.header.titleSubtitlePadding + pie.textComponents.subtitle.h;
		} else if (hasTopTitle) {
			headerOffset += pie.textComponents.title.h;
		} else if (hasTopSubtitle) {
			headerOffset += pie.textComponents.subtitle.h;
		}

		var footerOffset = 0;
		if (pie.textComponents.footer.exists) {
			footerOffset = pie.textComponents.footer.h + pie.options.misc.canvasPadding.bottom;
		}

		var x = ((pie.options.size.canvasWidth - pie.options.misc.canvasPadding.left - pie.options.misc.canvasPadding.right) / 2) + pie.options.misc.canvasPadding.left;
		var y = ((pie.options.size.canvasHeight - footerOffset - headerOffset) / 2) + headerOffset;

		x += pieCenterOffset.x;
		y += pieCenterOffset.y;

		pie.pieCenter = { x: x, y: y };
	},


	/**
	 * Rotates a point (x, y) around an axis (xm, ym) by degrees (a).
	 * @param x
	 * @param y
	 * @param xm
	 * @param ym
	 * @param a angle in degrees
	 * @returns {Array}
	 */
	rotate: function(x, y, xm, ym, a) {

        a = a * Math.PI / 180; // convert to radians

        var cos = Math.cos,
			sin = Math.sin,
		// subtract midpoints, so that midpoint is translated to origin and add it in the end again
		xr = (x - xm) * cos(a) - (y - ym) * sin(a) + xm,
		yr = (x - xm) * sin(a) + (y - ym) * cos(a) + ym;

		return { x: xr, y: yr };
	},

	/**
	 * Translates a point x, y by distance d, and by angle a.
	 * @param x
	 * @param y
	 * @param dist
	 * @param a angle in degrees
	 */
	translate: function(x, y, d, a) {
		var rads = math.toRadians(a);
		return {
			x: x + d * Math.sin(rads),
			y: y - d * Math.cos(rads)
		};
	},

	// from: http://stackoverflow.com/questions/19792552/d3-put-arc-labels-in-a-pie-chart-if-there-is-enough-space
	pointIsInArc: function(pt, ptData, d3Arc) {
		// Center of the arc is assumed to be 0,0
		// (pt.x, pt.y) are assumed to be relative to the center
		var r1 = d3Arc.innerRadius()(ptData), // Note: Using the innerRadius
			r2 = d3Arc.outerRadius()(ptData),
			theta1 = d3Arc.startAngle()(ptData),
			theta2 = d3Arc.endAngle()(ptData);

		var dist = pt.x * pt.x + pt.y * pt.y,
			angle = Math.atan2(pt.x, -pt.y); // Note: different coordinate system

		angle = (angle < 0) ? (angle + Math.PI * 2) : angle;

		return (r1 * r1 <= dist) && (dist <= r2 * r2) &&
			(theta1 <= angle) && (angle <= theta2);
	}
};

	//// --------- labels.js -----------
var labels = {

	/**
	 * Adds the labels to the pie chart, but doesn't position them. There are two locations for the
	 * labels: inside (center) of the segments, or outside the segments on the edge.
	 * @param section "inner" or "outer"
	 * @param sectionDisplayType "percentage", "value", "label", "label-value1", etc.
	 * @param pie
	 */
	add: function(pie, section, sectionDisplayType) {
		var include = labels.getIncludes(sectionDisplayType);
		var settings = pie.options.labels;

		// group the label groups (label, percentage, value) into a single element for simpler positioning
		var outerLabel = pie.svg.insert("g", "." + pie.cssPrefix + "labels-" + section)
			.attr("class", pie.cssPrefix + "labels-" + section);

		var labelGroup = outerLabel.selectAll("." + pie.cssPrefix + "labelGroup-" + section)
			.data(pie.options.data.content)
			.enter()
			.append("g")
			.attr("id", function(d, i) { return pie.cssPrefix + "labelGroup" + i + "-" + section; })
			.attr("data-index", function(d, i) { return i; })
			.attr("class", pie.cssPrefix + "labelGroup-" + section)
			.style("opacity", 0);

		var formatterContext = { section: section, sectionDisplayType: sectionDisplayType };

		// 1. Add the main label
		if (include.mainLabel) {
			labelGroup.append("text")
				.attr("id", function(d, i) { return pie.cssPrefix + "segmentMainLabel" + i + "-" + section; })
				.attr("class", pie.cssPrefix + "segmentMainLabel-" + section)
				.text(function(d, i) {
					var str = d.label;

					// if a custom formatter has been defined, pass it the raw label string - it can do whatever it wants with it.
					// we only apply truncation if it's not defined
					if (settings.formatter) {
						formatterContext.index = i;
						formatterContext.part = 'mainLabel';
						formatterContext.value = d.value;
						formatterContext.label = str;
						str = settings.formatter(formatterContext);
					} else if (settings.truncation.enabled && d.label.length > settings.truncation.truncateLength) {
						str = d.label.substring(0, settings.truncation.truncateLength) + "...";
					}
					return str;
				})
				.style("font-size", settings.mainLabel.fontSize + "px")
				.style("font-family", settings.mainLabel.font)
				.style("fill", settings.mainLabel.color);
		}

		// 2. Add the percentage label
		if (include.percentage) {
			labelGroup.append("text")
				.attr("id", function(d, i) { return pie.cssPrefix + "segmentPercentage" + i + "-" + section; })
				.attr("class", pie.cssPrefix + "segmentPercentage-" + section)
				.text(function(d, i) {
					var percentage = d.percentage;
					if (settings.formatter) {
						formatterContext.index = i;
						formatterContext.part = "percentage";
						formatterContext.value = d.value;
						formatterContext.label = d.percentage;
						percentage = settings.formatter(formatterContext);
					} else {
						percentage += "%";
					}
					return percentage;
				})
				.style("font-size", settings.percentage.fontSize + "px")
				.style("font-family", settings.percentage.font)
				.style("fill", settings.percentage.color);
		}

		// 3. Add the value label
		if (include.value) {
			labelGroup.append("text")
				.attr("id", function(d, i) { return pie.cssPrefix +  "segmentValue" + i + "-" + section; })
				.attr("class", pie.cssPrefix + "segmentValue-" + section)
				.text(function(d, i) {
					formatterContext.index = i;
					formatterContext.part = "value";
					formatterContext.value = d.value;
					formatterContext.label = d.value;
					return settings.formatter ? settings.formatter(formatterContext, d.value) : d.value;
				})
				.style("font-size", settings.value.fontSize + "px")
				.style("font-family", settings.value.font)
				.style("fill", settings.value.color);
		}
	},

	/**
	 * @param section "inner" / "outer"
	 */
	positionLabelElements: function(pie, section, sectionDisplayType) {
		labels["dimensions-" + section] = [];

		// get the latest widths, heights
		var labelGroups = d3.selectAll("." + pie.cssPrefix + "labelGroup-" + section);
		labelGroups.each(function(d, i) {
			var mainLabel  = d3.select(this).selectAll("." + pie.cssPrefix + "segmentMainLabel-" + section);
			var percentage = d3.select(this).selectAll("." + pie.cssPrefix + "segmentPercentage-" + section);
			var value      = d3.select(this).selectAll("." + pie.cssPrefix + "segmentValue-" + section);

			labels["dimensions-" + section].push({
				mainLabel:  (mainLabel.node() !== null) ? mainLabel.node().getBBox() : null,
				percentage: (percentage.node() !== null) ? percentage.node().getBBox() : null,
				value:      (value.node() !== null) ? value.node().getBBox() : null
			});
		});

		var singleLinePad = 5;
		var dims = labels["dimensions-" + section];
		switch (sectionDisplayType) {
			case "label-value1":
				d3.selectAll("." + pie.cssPrefix + "segmentValue-" + section)
					.attr("dx", function(d, i) { return dims[i].mainLabel.width + singleLinePad; });
				break;
			case "label-value2":
				d3.selectAll("." + pie.cssPrefix + "segmentValue-" + section)
					.attr("dy", function(d, i) { return dims[i].mainLabel.height; });
				break;
			case "label-percentage1":
				d3.selectAll("." + pie.cssPrefix + "segmentPercentage-" + section)
					.attr("dx", function(d, i) { return dims[i].mainLabel.width + singleLinePad; });
				break;
			case "label-percentage2":
				d3.selectAll("." + pie.cssPrefix + "segmentPercentage-" + section)
					.attr("dx", function(d, i) { return (dims[i].mainLabel.width / 2) - (dims[i].percentage.width / 2); })
					.attr("dy", function(d, i) { return dims[i].mainLabel.height; });
				break;
	 	}
	},

	computeLabelLinePositions: function(pie) {
		pie.lineCoordGroups = [];
		d3.selectAll("." + pie.cssPrefix + "labelGroup-outer")
			.each(function(d, i) { return labels.computeLinePosition(pie, i); });
	},

	computeLinePosition: function(pie, i) {
		var angle = segments.getSegmentAngle(i, pie.options.data.content, pie.totalSize, { midpoint: true });
		var originCoords = math.rotate(pie.pieCenter.x, pie.pieCenter.y - pie.outerRadius, pie.pieCenter.x, pie.pieCenter.y, angle);
		var heightOffset = pie.outerLabelGroupData[i].h / 5; // TODO check
		var labelXMargin = 6; // the x-distance of the label from the end of the line [TODO configurable]

		var quarter = Math.floor(angle / 90);
		var midPoint = 4;
		var x2, y2, x3, y3;

		// this resolves an issue when the
		if (quarter === 2 && angle === 180) {
			quarter = 1;
		}

		switch (quarter) {
			case 0:
				x2 = pie.outerLabelGroupData[i].x - labelXMargin - ((pie.outerLabelGroupData[i].x - labelXMargin - originCoords.x) / 2);
				y2 = pie.outerLabelGroupData[i].y + ((originCoords.y - pie.outerLabelGroupData[i].y) / midPoint);
				x3 = pie.outerLabelGroupData[i].x - labelXMargin;
				y3 = pie.outerLabelGroupData[i].y - heightOffset;
				break;
			case 1:
				x2 = originCoords.x + (pie.outerLabelGroupData[i].x - originCoords.x) / midPoint;
				y2 = originCoords.y + (pie.outerLabelGroupData[i].y - originCoords.y) / midPoint;
				x3 = pie.outerLabelGroupData[i].x - labelXMargin;
				y3 = pie.outerLabelGroupData[i].y - heightOffset;
				break;
			case 2:
				var startOfLabelX = pie.outerLabelGroupData[i].x + pie.outerLabelGroupData[i].w + labelXMargin;
				x2 = originCoords.x - (originCoords.x - startOfLabelX) / midPoint;
				y2 = originCoords.y + (pie.outerLabelGroupData[i].y - originCoords.y) / midPoint;
				x3 = pie.outerLabelGroupData[i].x + pie.outerLabelGroupData[i].w + labelXMargin;
				y3 = pie.outerLabelGroupData[i].y - heightOffset;
				break;
			case 3:
				var startOfLabel = pie.outerLabelGroupData[i].x + pie.outerLabelGroupData[i].w + labelXMargin;
				x2 = startOfLabel + ((originCoords.x - startOfLabel) / midPoint);
				y2 = pie.outerLabelGroupData[i].y + (originCoords.y - pie.outerLabelGroupData[i].y) / midPoint;
				x3 = pie.outerLabelGroupData[i].x + pie.outerLabelGroupData[i].w + labelXMargin;
				y3 = pie.outerLabelGroupData[i].y - heightOffset;
				break;
		}

		/*
		 * x1 / y1: the x/y coords of the start of the line, at the mid point of the segments arc on the pie circumference
		 * x2 / y2: if "curved" line style is being used, this is the midpoint of the line. Other
		 * x3 / y3: the end of the line; closest point to the label
		 */
		if (pie.options.labels.lines.style === "straight") {
			pie.lineCoordGroups[i] = [
				{ x: originCoords.x, y: originCoords.y },
				{ x: x3, y: y3 }
			];
		} else {
			pie.lineCoordGroups[i] = [
				{ x: originCoords.x, y: originCoords.y },
				{ x: x2, y: y2 },
				{ x: x3, y: y3 }
			];
		}
	},

	addLabelLines: function(pie) {
		var lineGroups = pie.svg.insert("g", "." + pie.cssPrefix + "pieChart") // meaning, BEFORE .pieChart
			.attr("class", pie.cssPrefix + "lineGroups")
			.style("opacity", 0);

		var lineGroup = lineGroups.selectAll("." + pie.cssPrefix + "lineGroup")
			.data(pie.lineCoordGroups)
			.enter()
			.append("g")
			.attr("class", pie.cssPrefix + "lineGroup");

        var lineFunction = d3.line()
			.curve(d3.curveBasis)
			.x(function(d) { return d.x; })
			.y(function(d) { return d.y; });

		lineGroup.append("path")
			.attr("d", lineFunction)
			.attr("stroke", function(d, i) {
				return (pie.options.labels.lines.color === "segment") ? pie.options.colors[i] : pie.options.labels.lines.color;
			})
			.attr("stroke-width", 1)
			.attr("fill", "none")
			.style("opacity", function(d, i) {
				var percentage = pie.options.labels.outer.hideWhenLessThanPercentage;
				var isHidden = (percentage !== null && d.percentage < percentage) || pie.options.data.content[i].label === "";
				return isHidden ? 0 : 1;
			});
	},

	positionLabelGroups: function(pie, section) {
    if (pie.options.labels[section].format === "none") {
      return;
    }

		d3.selectAll("." + pie.cssPrefix + "labelGroup-" + section)
			.style("opacity", 0)
			.attr("transform", function(d, i) {
				var x, y;
				if (section === "outer") {
					x = pie.outerLabelGroupData[i].x;
					y = pie.outerLabelGroupData[i].y;
				} else {
					var pieCenterCopy = extend(true, {}, pie.pieCenter);

					// now recompute the "center" based on the current _innerRadius
					if (pie.innerRadius > 0) {
						var angle = segments.getSegmentAngle(i, pie.options.data.content, pie.totalSize, { midpoint: true });
						var newCoords = math.translate(pie.pieCenter.x, pie.pieCenter.y, pie.innerRadius, angle);
						pieCenterCopy.x = newCoords.x;
						pieCenterCopy.y = newCoords.y;
					}

					var dims = helpers.getDimensions(pie.cssPrefix + "labelGroup" + i + "-inner");
					var xOffset = dims.w / 2;
					var yOffset = dims.h / 4; // confusing! Why 4? should be 2, but it doesn't look right

					x = pieCenterCopy.x + (pie.lineCoordGroups[i][0].x - pieCenterCopy.x) / 1.8;
					y = pieCenterCopy.y + (pie.lineCoordGroups[i][0].y - pieCenterCopy.y) / 1.8;

					x = x - xOffset;
					y = y + yOffset;
				}

				return "translate(" + x + "," + y + ")";
			});
	},


	fadeInLabelsAndLines: function(pie) {

		// fade in the labels when the load effect is complete - or immediately if there's no load effect
		var loadSpeed = (pie.options.effects.load.effect === "default") ? pie.options.effects.load.speed : 1;
		setTimeout(function() {
			var labelFadeInTime = (pie.options.effects.load.effect === "default") ? 400 : 1; // 400 is hardcoded for the present

			d3.selectAll("." + pie.cssPrefix + "labelGroup-outer")
				.transition()
				.duration(labelFadeInTime)
				.style("opacity", function(d, i) {
					var percentage = pie.options.labels.outer.hideWhenLessThanPercentage;
					return (percentage !== null && d.percentage < percentage) ? 0 : 1;
				});

			d3.selectAll("." + pie.cssPrefix + "labelGroup-inner")
				.transition()
				.duration(labelFadeInTime)
				.style("opacity", function(d, i) {
					var percentage = pie.options.labels.inner.hideWhenLessThanPercentage;
					return (percentage !== null && d.percentage < percentage) ? 0 : 1;
				});

			d3.selectAll("g." + pie.cssPrefix + "lineGroups")
				.transition()
				.duration(labelFadeInTime)
				.style("opacity", 1);

			// once everything's done loading, trigger the onload callback if defined
			if (helpers.isFunction(pie.options.callbacks.onload)) {
				setTimeout(function() {
					try {
						pie.options.callbacks.onload();
					} catch (e) { }
				}, labelFadeInTime);
			}
		}, loadSpeed);
	},

	getIncludes: function(val) {
		var addMainLabel  = false;
		var addValue      = false;
		var addPercentage = false;

		switch (val) {
			case "label":
				addMainLabel = true;
				break;
			case "value":
				addValue = true;
				break;
			case "percentage":
				addPercentage = true;
				break;
			case "label-value1":
			case "label-value2":
				addMainLabel = true;
				addValue = true;
				break;
			case "label-percentage1":
			case "label-percentage2":
				addMainLabel = true;
				addPercentage = true;
				break;
		}
		return {
			mainLabel: addMainLabel,
			value: addValue,
			percentage: addPercentage
		};
	},


	/**
	 * This does the heavy-lifting to compute the actual coordinates for the outer label groups. It does two things:
	 * 1. Make a first pass and position them in the ideal positions, based on the pie sizes
	 * 2. Do some basic collision avoidance.
	 */
	computeOuterLabelCoords: function(pie) {

		// 1. figure out the ideal positions for the outer labels
		pie.svg.selectAll("." + pie.cssPrefix + "labelGroup-outer")
			.each(function(d, i) {
				return labels.getIdealOuterLabelPositions(pie, i);
			});

		// 2. now adjust those positions to try to accommodate conflicts
		labels.resolveOuterLabelCollisions(pie);
	},

	/**
	 * This attempts to resolve label positioning collisions.
	 */
	resolveOuterLabelCollisions: function(pie) {
    if (pie.options.labels.outer.format === "none") {
      return;
    }

		var size = pie.options.data.content.length;
		labels.checkConflict(pie, 0, "clockwise", size);
		labels.checkConflict(pie, size-1, "anticlockwise", size);
	},

	checkConflict: function(pie, currIndex, direction, size) {
    var i, curr;

		if (size <= 1) {
			return;
		}

		var currIndexHemisphere = pie.outerLabelGroupData[currIndex].hs;
		if (direction === "clockwise" && currIndexHemisphere !== "right") {
			return;
		}
		if (direction === "anticlockwise" && currIndexHemisphere !== "left") {
			return;
		}
		var nextIndex = (direction === "clockwise") ? currIndex+1 : currIndex-1;

		// this is the current label group being looked at. We KNOW it's positioned properly (the first item
		// is always correct)
		var currLabelGroup = pie.outerLabelGroupData[currIndex];

		// this one we don't know about. That's the one we're going to look at and move if necessary
		var examinedLabelGroup = pie.outerLabelGroupData[nextIndex];

		var info = {
			labelHeights: pie.outerLabelGroupData[0].h,
			center: pie.pieCenter,
			lineLength: (pie.outerRadius + pie.options.labels.outer.pieDistance),
			heightChange: pie.outerLabelGroupData[0].h + 1 // 1 = padding
		};

		// loop through *ALL* label groups examined so far to check for conflicts. This is because when they're
		// very tightly fitted, a later label group may still appear high up on the page
		if (direction === "clockwise") {
      i = 0;
			for (; i<=currIndex; i++) {
				curr = pie.outerLabelGroupData[i];

				// if there's a conflict with this label group, shift the label to be AFTER the last known
				// one that's been properly placed
				if (!labels.isLabelHidden(pie, i) && helpers.rectIntersect(curr, examinedLabelGroup)) {
					labels.adjustLabelPos(pie, nextIndex, currLabelGroup, info);
					break;
				}
			}
		} else {
      i = size - 1;
			for (; i >= currIndex; i--) {
				curr = pie.outerLabelGroupData[i];

				// if there's a conflict with this label group, shift the label to be AFTER the last known
				// one that's been properly placed
				if (!labels.isLabelHidden(pie, i) && helpers.rectIntersect(curr, examinedLabelGroup)) {
					labels.adjustLabelPos(pie, nextIndex, currLabelGroup, info);
					break;
				}
			}
		}
		labels.checkConflict(pie, nextIndex, direction, size);
	},

	isLabelHidden: function(pie, index) {
		var percentage = pie.options.labels.outer.hideWhenLessThanPercentage;
		return (percentage !== null && d.percentage < percentage) || pie.options.data.content[index].label === "";
	},

	// does a little math to shift a label into a new position based on the last properly placed one
	adjustLabelPos: function(pie, nextIndex, lastCorrectlyPositionedLabel, info) {
		var xDiff, yDiff, newXPos, newYPos;
		newYPos = lastCorrectlyPositionedLabel.y + info.heightChange;
		yDiff = info.center.y - newYPos;

		if (Math.abs(info.lineLength) > Math.abs(yDiff)) {
			xDiff = Math.sqrt((info.lineLength * info.lineLength) - (yDiff * yDiff));
		} else {
			xDiff = Math.sqrt((yDiff * yDiff) - (info.lineLength * info.lineLength));
		}

		if (lastCorrectlyPositionedLabel.hs === "right") {
			newXPos = info.center.x + xDiff;
		} else {
			newXPos = info.center.x - xDiff - pie.outerLabelGroupData[nextIndex].w;
		}

		pie.outerLabelGroupData[nextIndex].x = newXPos;
		pie.outerLabelGroupData[nextIndex].y = newYPos;
	},

	/**
	 * @param i 0-N where N is the dataset size - 1.
	 */
	getIdealOuterLabelPositions: function(pie, i) {
    var labelGroupNode = d3.select("#" + pie.cssPrefix + "labelGroup" + i + "-outer").node();
    if (!labelGroupNode) {
      return;
    }
    var labelGroupDims = labelGroupNode.getBBox();
		var angle = segments.getSegmentAngle(i, pie.options.data.content, pie.totalSize, { midpoint: true });

		var originalX = pie.pieCenter.x;
		var originalY = pie.pieCenter.y - (pie.outerRadius + pie.options.labels.outer.pieDistance);
		var newCoords = math.rotate(originalX, originalY, pie.pieCenter.x, pie.pieCenter.y, angle);

		// if the label is on the left half of the pie, adjust the values
		var hemisphere = "right"; // hemisphere
		if (angle > 180) {
			newCoords.x -= (labelGroupDims.width + 8);
			hemisphere = "left";
		} else {
			newCoords.x += 8;
		}

		pie.outerLabelGroupData[i] = {
			x: newCoords.x,
			y: newCoords.y,
			w: labelGroupDims.width,
			h: labelGroupDims.height,
			hs: hemisphere
		};
	}
};

	//// --------- segments.js -----------
var segments = {

    effectMap: {
        "none": d3.easeLinear,
        "bounce": d3.easeBounce,
        "linear": d3.easeLinear,
        "sin": d3.easeSin,
        "elastic": d3.easeElastic,
        "back": d3.easeBack,
        "quad": d3.easeQuad,
        "circle": d3.easeCircle,
        "exp": d3.easeExp
    },

	/**
	 * Creates the pie chart segments and displays them according to the desired load effect.
	 * @private
	 */
	create: function(pie) {
		var pieCenter = pie.pieCenter;
		var colors = pie.options.colors;
		var loadEffects = pie.options.effects.load;
		var segmentStroke = pie.options.misc.colors.segmentStroke;

		// we insert the pie chart BEFORE the title, to ensure the title overlaps the pie
		var pieChartElement = pie.svg.insert("g", "#" + pie.cssPrefix + "title")
			.attr("transform", function() { return math.getPieTranslateCenter(pieCenter); })
			.attr("class", pie.cssPrefix + "pieChart");

		var arc = d3.arc()
			.innerRadius(pie.innerRadius)
			.outerRadius(pie.outerRadius)
			.startAngle(0)
			.endAngle(function(d) {
				return (d.value / pie.totalSize) * 2 * Math.PI;
			});

		var g = pieChartElement.selectAll("." + pie.cssPrefix + "arc")
			.data(pie.options.data.content)
			.enter()
			.append("g")
			.attr("class", pie.cssPrefix + "arc");

		// if we're not fading in the pie, just set the load speed to 0
		var loadSpeed = loadEffects.speed;
		if (loadEffects.effect === "none") {
			loadSpeed = 0;
		}

		g.append("path")
			.attr("id", function(d, i) { return pie.cssPrefix + "segment" + i; })
			.attr("fill", function(d, i) {
				var color = colors[i];
				if (pie.options.misc.gradient.enabled) {
					color = "url(#" + pie.cssPrefix + "grad" + i + ")";
				}
				return color;
			})
			.style("stroke", segmentStroke)
			.style("stroke-width", 1)
			.transition()
			.ease(d3.easeCubicInOut)
			.duration(loadSpeed)
			.attr("data-index", function(d, i) { return i; })
			.attrTween("d", function(b) {
				var i = d3.interpolate({ value: 0 }, b);
				return function(t) {
					return pie.arc(i(t));
				};
			});

		pie.svg.selectAll("g." + pie.cssPrefix + "arc")
			.attr("transform",
			function(d, i) {
				var angle = 0;
				if (i > 0) {
					angle = segments.getSegmentAngle(i-1, pie.options.data.content, pie.totalSize);
				}
				return "rotate(" + angle + ")";
			}
		);
		pie.arc = arc;
	},

	addGradients: function(pie) {
		var grads = pie.svg.append("defs")
			.selectAll("radialGradient")
			.data(pie.options.data.content)
			.enter().append("radialGradient")
			.attr("gradientUnits", "userSpaceOnUse")
			.attr("cx", 0)
			.attr("cy", 0)
			.attr("r", "120%")
			.attr("id", function(d, i) { return pie.cssPrefix + "grad" + i; });

		grads.append("stop").attr("offset", "0%").style("stop-color", function(d, i) { return pie.options.colors[i]; });
		grads.append("stop").attr("offset", pie.options.misc.gradient.percentage + "%").style("stop-color", pie.options.misc.gradient.color);
	},

	addSegmentEventHandlers: function(pie) {
		var arc = d3.selectAll("." + pie.cssPrefix + "arc,." + pie.cssPrefix + "labelGroup-inner,." + pie.cssPrefix + "labelGroup-outer");

		arc.on("click", function() {
			var currentEl = d3.select(this);
			var segment;

			// mouseover works on both the segments AND the segment labels, hence the following
			if (currentEl.attr("class") === pie.cssPrefix + "arc") {
				segment = currentEl.select("path");
			} else {
				var index = currentEl.attr("data-index");
				segment = d3.select("#" + pie.cssPrefix + "segment" + index);
			}

			var isExpanded = segment.attr("class") === pie.cssPrefix + "expanded";
			segments.onSegmentEvent(pie, pie.options.callbacks.onClickSegment, segment, isExpanded);
			if (pie.options.effects.pullOutSegmentOnClick.effect !== "none") {
				if (isExpanded) {
					segments.closeSegment(pie, segment.node());
				} else {
					segments.openSegment(pie, segment.node());
				}
			}
		});

		arc.on("mouseover", function() {
			var currentEl = d3.select(this);
			var segment, index;

			if (currentEl.attr("class") === pie.cssPrefix + "arc") {
				segment = currentEl.select("path");
			} else {
				index = currentEl.attr("data-index");
				segment = d3.select("#" + pie.cssPrefix + "segment" + index);
			}

			if (pie.options.effects.highlightSegmentOnMouseover) {
				index = segment.attr("data-index");
				var segColor = pie.options.colors[index];
				segment.style("fill", helpers.getColorShade(segColor, pie.options.effects.highlightLuminosity));
			}

			if (pie.options.tooltips.enabled) {
				index = segment.attr("data-index");
				tt.showTooltip(pie, index);
			}

			var isExpanded = segment.attr("class") === pie.cssPrefix + "expanded";
			segments.onSegmentEvent(pie, pie.options.callbacks.onMouseoverSegment, segment, isExpanded);
		});

		arc.on("mousemove", function() {
			tt.moveTooltip(pie);
		});

		arc.on("mouseout", function() {
			var currentEl = d3.select(this);
			var segment, index;

			if (currentEl.attr("class") === pie.cssPrefix + "arc") {
				segment = currentEl.select("path");
			} else {
				index = currentEl.attr("data-index");
				segment = d3.select("#" + pie.cssPrefix + "segment" + index);
			}

			if (pie.options.effects.highlightSegmentOnMouseover) {
				index = segment.attr("data-index");
				var color = pie.options.colors[index];
				if (pie.options.misc.gradient.enabled) {
					color = "url(#" + pie.cssPrefix + "grad" + index + ")";
				}
				segment.style("fill", color);
			}

			if (pie.options.tooltips.enabled) {
				index = segment.attr("data-index");
				tt.hideTooltip(pie, index);
			}

			var isExpanded = segment.attr("class") === pie.cssPrefix + "expanded";
			segments.onSegmentEvent(pie, pie.options.callbacks.onMouseoutSegment, segment, isExpanded);
		});
	},

	// helper function used to call the click, mouseover, mouseout segment callback functions
	onSegmentEvent: function(pie, func, segment, isExpanded) {
		if (!helpers.isFunction(func)) {
			return;
		}
		var index = parseInt(segment.attr("data-index"), 10);
		func({
			segment: segment.node(),
			index: index,
			expanded: isExpanded,
			data: pie.options.data.content[index]
		});
	},

	openSegment: function(pie, segment) {
		if (pie.isOpeningSegment) {
			return;
		}
		pie.isOpeningSegment = true;

		segments.maybeCloseOpenSegment();

		d3.select(segment).transition()
			.ease(segments.effectMap[pie.options.effects.pullOutSegmentOnClick.effect])
			.duration(pie.options.effects.pullOutSegmentOnClick.speed)
			.attr("transform", function(d, i) {
				var c = pie.arc.centroid(d),
					x = c[0],
					y = c[1],
					h = Math.sqrt(x*x + y*y),
					pullOutSize = parseInt(pie.options.effects.pullOutSegmentOnClick.size, 10);

				return "translate(" + ((x/h) * pullOutSize) + ',' + ((y/h) * pullOutSize) + ")";
			})
			.on("end", function(d, i) {
				pie.currentlyOpenSegment = segment;
				pie.isOpeningSegment = false;
				d3.select(segment).attr("class", pie.cssPrefix + "expanded");
			});
	},

    maybeCloseOpenSegment: function() {
        if (d3.selectAll("." + pie.cssPrefix + "expanded").size() > 0) {
            segments.closeSegment(pie, d3.select("." + pie.cssPrefix + "expanded").node());
        }
	},

	closeSegment: function(pie, segment) {
		d3.select(segment).transition()
			.duration(400)
			.attr("transform", "translate(0,0)")
			.on("end", function(d, i) {
				d3.select(segment).attr("class", "");
				pie.currentlyOpenSegment = null;
			});
	},

	getCentroid: function(el) {
		var bbox = el.getBBox();
		return {
			x: bbox.x + bbox.width / 2,
			y: bbox.y + bbox.height / 2
		};
	},

	/**
	 * General helper function to return a segment's angle, in various different ways.
	 * @param index
	 * @param opts optional object for fine-tuning exactly what you want.
	 */
	getSegmentAngle: function(index, data, totalSize, opts) {
		var options = extend({
			// if true, this returns the full angle from the origin. Otherwise it returns the single segment angle
			compounded: true,

			// optionally returns the midpoint of the angle instead of the full angle
			midpoint: false
		}, opts);

		var currValue = data[index].value;
		var fullValue;
		if (options.compounded) {
			fullValue = 0;

			// get all values up to and including the specified index
			for (var i=0; i<=index; i++) {
				fullValue += data[i].value;
			}
		}

		if (typeof fullValue === 'undefined') {
			fullValue = currValue;
		}

		// now convert the full value to an angle
		var angle = (fullValue / totalSize) * 360;

		// lastly, if we want the midpoint, factor that sucker in
		if (options.midpoint) {
			var currAngle = (currValue / totalSize) * 360;
			angle -= (currAngle / 2);
		}

		return angle;
	}

};

	//// --------- text.js -----------
var text = {
	offscreenCoord: -10000,

	addTitle: function(pie) {


		var title = pie.svg.selectAll("." + pie.cssPrefix + "title")
			.data([pie.options.header.title])
			.enter()
			.append("text")
			.text(function(d) { return d.text; })
			.attr("id", pie.cssPrefix + "title")
        	.attr("class", pie.cssPrefix + "title")
			.attr("x", text.offscreenCoord)
			.attr("y", text.offscreenCoord)
			.attr("text-anchor", function() {
				var location;
				if (pie.options.header.location === "top-center" || pie.options.header.location === "pie-center") {
					location = "middle";
				} else {
					location = "left";
				}
				return location;
			})
			.attr("fill", function(d) { return d.color; })
			.style("font-size", function(d) { return d.fontSize + "px"; })
			.style("font-family", function(d) { return d.font; });
	},

	positionTitle: function(pie) {
		var textComponents = pie.textComponents;
		var headerLocation = pie.options.header.location;
		var canvasPadding = pie.options.misc.canvasPadding;
		var canvasWidth = pie.options.size.canvasWidth;
		var titleSubtitlePadding = pie.options.header.titleSubtitlePadding;

		var x;
		if (headerLocation === "top-left") {
			x = canvasPadding.left;
		} else {
			x = ((canvasWidth - canvasPadding.right) / 2) + canvasPadding.left;
		}

    // add whatever offset has been added by user
    x += pie.options.misc.pieCenterOffset.x;

		var y = canvasPadding.top + textComponents.title.h;

		if (headerLocation === "pie-center") {
			y = pie.pieCenter.y;

			// still not fully correct
			if (textComponents.subtitle.exists) {
				var totalTitleHeight = textComponents.title.h + titleSubtitlePadding + textComponents.subtitle.h;
				y = y - (totalTitleHeight / 2) + textComponents.title.h;
			} else {
				y += (textComponents.title.h / 4);
			}
		}

		pie.svg.select("#" + pie.cssPrefix + "title")
			.attr("x", x)
			.attr("y", y);
	},

	addSubtitle: function(pie) {
		var headerLocation = pie.options.header.location;

		pie.svg.selectAll("." + pie.cssPrefix + "subtitle")
			.data([pie.options.header.subtitle])
			.enter()
			.append("text")
			.text(function(d) { return d.text; })
			.attr("x", text.offscreenCoord)
			.attr("y", text.offscreenCoord)
			.attr("id", pie.cssPrefix + "subtitle")
			.attr("class", pie.cssPrefix + "subtitle")
			.attr("text-anchor", function() {
				var location;
				if (headerLocation === "top-center" || headerLocation === "pie-center") {
					location = "middle";
				} else {
					location = "left";
				}
				return location;
			})
			.attr("fill", function(d) { return d.color; })
			.style("font-size", function(d) { return d.fontSize + "px"; })
			.style("font-family", function(d) { return d.font; });
	},

	positionSubtitle: function(pie) {
		var canvasPadding = pie.options.misc.canvasPadding;
		var canvasWidth = pie.options.size.canvasWidth;

		var x;
		if (pie.options.header.location === "top-left") {
			x = canvasPadding.left;
		} else {
			x = ((canvasWidth - canvasPadding.right) / 2) + canvasPadding.left;
		}

    // add whatever offset has been added by user
    x += pie.options.misc.pieCenterOffset.x;

		var y = text.getHeaderHeight(pie);
		pie.svg.select("#" + pie.cssPrefix + "subtitle")
			.attr("x", x)
			.attr("y", y);
	},

	addFooter: function(pie) {
		pie.svg.selectAll("." + pie.cssPrefix + "footer")
			.data([pie.options.footer])
			.enter()
			.append("text")
			.text(function(d) { return d.text; })
			.attr("x", text.offscreenCoord)
			.attr("y", text.offscreenCoord)
			.attr("id", pie.cssPrefix + "footer")
			.attr("class", pie.cssPrefix + "footer")
			.attr("text-anchor", function() {
				var location = "left";
				if (pie.options.footer.location === "bottom-center") {
					location = "middle";
				} else if (pie.options.footer.location === "bottom-right") {
					location = "left"; // on purpose. We have to change the x-coord to make it properly right-aligned
				}
				return location;
			})
			.attr("fill", function(d) { return d.color; })
			.style("font-size", function(d) { return d.fontSize + "px"; })
			.style("font-family", function(d) { return d.font; });
	},

	positionFooter: function(pie) {
		var footerLocation = pie.options.footer.location;
		var footerWidth = pie.textComponents.footer.w;
		var canvasWidth = pie.options.size.canvasWidth;
		var canvasHeight = pie.options.size.canvasHeight;
		var canvasPadding = pie.options.misc.canvasPadding;

		var x;
		if (footerLocation === "bottom-left") {
			x = canvasPadding.left;
		} else if (footerLocation === "bottom-right") {
			x = canvasWidth - footerWidth - canvasPadding.right;
		} else {
			x = canvasWidth / 2; // TODO - shouldn't this also take into account padding?
		}

		pie.svg.select("#" + pie.cssPrefix + "footer")
			.attr("x", x)
			.attr("y", canvasHeight - canvasPadding.bottom);
	},

	getHeaderHeight: function(pie) {
		var h;
		if (pie.textComponents.title.exists) {

			// if the subtitle isn't defined, it'll be set to 0
			var totalTitleHeight = pie.textComponents.title.h + pie.options.header.titleSubtitlePadding + pie.textComponents.subtitle.h;
			if (pie.options.header.location === "pie-center") {
				h = pie.pieCenter.y - (totalTitleHeight / 2) + totalTitleHeight;
			} else {
				h = totalTitleHeight + pie.options.misc.canvasPadding.top;
			}
		} else {
			if (pie.options.header.location === "pie-center") {
				var footerPlusPadding = pie.options.misc.canvasPadding.bottom + pie.textComponents.footer.h;
				h = ((pie.options.size.canvasHeight - footerPlusPadding) / 2) + pie.options.misc.canvasPadding.top + (pie.textComponents.subtitle.h / 2);
			} else {
				h = pie.options.misc.canvasPadding.top + pie.textComponents.subtitle.h;
			}
		}
		return h;
	}
};

	//// --------- validate.js -----------
var tt = {
    addTooltips: function(pie) {

    // group the label groups (label, percentage, value) into a single element for simpler positioning
    var tooltips = pie.svg.insert("g")
        .attr("class", pie.cssPrefix + "tooltips");

    tooltips.selectAll("." + pie.cssPrefix + "tooltip")
        .data(pie.options.data.content)
        .enter()
        .append("g")
        .attr("class", pie.cssPrefix + "tooltip")
        .attr("id", function(d, i) { return pie.cssPrefix + "tooltip" + i; })
        .style("opacity", 0)
        .append("rect")
        .attr("rx", pie.options.tooltips.styles.borderRadius)
        .attr("ry", pie.options.tooltips.styles.borderRadius)
        .attr("x", -pie.options.tooltips.styles.padding)
        .attr("opacity", pie.options.tooltips.styles.backgroundOpacity)
        .style("fill", pie.options.tooltips.styles.backgroundColor);

    tooltips.selectAll("." + pie.cssPrefix + "tooltip")
        .data(pie.options.data.content)
        .append("text")
        .attr("fill", function(d) { return pie.options.tooltips.styles.color; })
        .style("font-size", function(d) { return pie.options.tooltips.styles.fontSize; })
        .style("font-family", function(d) { return pie.options.tooltips.styles.font; })
        .text(function(d, i) {
            var caption = pie.options.tooltips.string;
            if (pie.options.tooltips.type === "caption") {
                caption = d.caption;
            }
            return tt.replacePlaceholders(pie, caption, i, {
                label: d.label,
                value: d.value,
                percentage: d.percentage
            });
        });

		tooltips.selectAll("." + pie.cssPrefix + "tooltip rect")
			.attr("width", function (d, i) {
                var dims = helpers.getDimensions(pie.cssPrefix + "tooltip" + i);
                return dims.w + (2 * pie.options.tooltips.styles.padding);
            })
            .attr("height", function (d, i) {
                var dims = helpers.getDimensions(pie.cssPrefix + "tooltip" + i);
                return dims.h + (2 * pie.options.tooltips.styles.padding);
            })
            .attr("y", function (d, i) {
                var dims = helpers.getDimensions(pie.cssPrefix + "tooltip" + i);
                return -(dims.h / 2) + 1;
            });
	},

    showTooltip: function(pie, index) {
        var fadeInSpeed = pie.options.tooltips.styles.fadeInSpeed;
        if (tt.currentTooltip === index) {
            fadeInSpeed = 1;
        }

        tt.currentTooltip = index;
        d3.select("#" + pie.cssPrefix + "tooltip" + index)
            .transition()
            .duration(fadeInSpeed)
            .style("opacity", function() { return 1; });

        tt.moveTooltip(pie);
    },

    moveTooltip: function(pie) {
        d3.selectAll("#" + pie.cssPrefix + "tooltip" + tt.currentTooltip)
            .attr("transform", function(d) {
                var mouseCoords = d3.mouse(this.parentNode);
                var x = mouseCoords[0] + pie.options.tooltips.styles.padding + 2;
                var y = mouseCoords[1] - (2 * pie.options.tooltips.styles.padding) - 2;
                    return "translate(" + x + "," + y + ")";
                });
    },

    hideTooltip: function(pie, index) {
        d3.select("#" + pie.cssPrefix + "tooltip" + index)
            .style("opacity", function() { return 0; });

        // move the tooltip offscreen. This ensures that when the user next mouseovers the segment the hidden
        // element won't interfere
        d3.select("#" + pie.cssPrefix + "tooltip" + tt.currentTooltip)
            .attr("transform", function(d, i) {
                // klutzy, but it accounts for tooltip padding which could push it onscreen
                var x = pie.options.size.canvasWidth + 1000;
                var y = pie.options.size.canvasHeight + 1000;
                return "translate(" + x + "," + y + ")";
            });
    },

    replacePlaceholders: function(pie, str, index, replacements) {

        // if the user has defined a placeholderParser function, call it before doing the replacements
        if (helpers.isFunction(pie.options.tooltips.placeholderParser)) {
            pie.options.tooltips.placeholderParser(index, replacements);
        }

        var replacer = function()  {
            return function(match) {
                var placeholder = arguments[1];
                if (replacements.hasOwnProperty(placeholder)) {
                    return replacements[arguments[1]];
                } else {
                    return arguments[0];
                }
            };
        };
        return str.replace(/\{(\w+)\}/g, replacer(replacements));
    }
};


	// --------------------------------------------------------------------------------------------

	// our constructor
	var d3pie = function(element, options) {

		// element can be an ID or DOM element
		this.element = element;
		if (typeof element === "string") {
			var el = element.replace(/^#/, ""); // replace any jQuery-like ID hash char
			this.element = document.getElementById(el);
		}

		var opts = {};
		extend(true, opts, defaultSettings, options);
		this.options = opts;

		// if the user specified a custom CSS element prefix (ID, class), use it
		if (this.options.misc.cssPrefix !== null) {
			this.cssPrefix = this.options.misc.cssPrefix;
		} else {
			this.cssPrefix = "p" + _uniqueIDCounter + "_";
			_uniqueIDCounter++;
		}


		// now run some validation on the user-defined info
		if (!validate.initialCheck(this)) {
			return;
		}

		// add a data-role to the DOM node to let anyone know that it contains a d3pie instance, and the d3pie version
		d3.select(this.element).attr(_scriptName, _version);

		// things that are done once
		_setupData.call(this);
		_init.call(this);
	};

	d3pie.prototype.recreate = function() {
		// now run some validation on the user-defined info
		if (!validate.initialCheck(this)) {
            return;
        }

		_setupData.call(this);
		_init.call(this);
	};

	d3pie.prototype.redraw = function() {
		this.element.innerHTML = "";
		_init.call(this);
	};

	d3pie.prototype.destroy = function() {
		this.element.innerHTML = ""; // clear out the SVG
		d3.select(this.element).attr(_scriptName, null); // remove the data attr
	};

	/**
	 * Returns all pertinent info about the current open info. Returns null if nothing's open, or if one is, an object of
	 * the following form:
	 * 	{
	 * 	  element: DOM NODE,
	 * 	  index: N,
	 * 	  data: {}
	 * 	}
	 */
	d3pie.prototype.getOpenSegment = function() {
		var segment = this.currentlyOpenSegment;
		if (segment !== null && typeof segment !== "undefined") {
			var index = parseInt(d3.select(segment).attr("data-index"), 10);
			return {
				element: segment,
				index: index,
				data: this.options.data.content[index]
			};
		} else {
			return null;
		}
	};

	d3pie.prototype.openSegment = function(index) {
		index = parseInt(index, 10);
		if (index < 0 || index > this.options.data.content.length-1) {
			return;
		}
		segments.openSegment(this, d3.select("#" + this.cssPrefix + "segment" + index).node());
	};

	d3pie.prototype.closeSegment = function() {
        segments.maybeCloseOpenSegment();
	};

	// this let's the user dynamically update aspects of the pie chart without causing a complete redraw. It
	// intelligently re-renders only the part of the pie that the user specifies. Some things cause a repaint, others
	// just redraw the single element
	d3pie.prototype.updateProp = function(propKey, value) {
		switch (propKey) {
			case "header.title.text":
				var oldVal = helpers.processObj(this.options, propKey);
				helpers.processObj(this.options, propKey, value);
				d3.select("#" + this.cssPrefix + "title").html(value);
				if ((oldVal === "" && value !== "") || (oldVal !== "" && value === "")) {
					this.redraw();
				}
				break;

			case "header.subtitle.text":
				var oldValue = helpers.processObj(this.options, propKey);
				helpers.processObj(this.options, propKey, value);
				d3.select("#" + this.cssPrefix + "subtitle").html(value);
				if ((oldValue === "" && value !== "") || (oldValue !== "" && value === "")) {
					this.redraw();
				}
				break;

			case "callbacks.onload":
			case "callbacks.onMouseoverSegment":
			case "callbacks.onMouseoutSegment":
			case "callbacks.onClickSegment":
			case "effects.pullOutSegmentOnClick.effect":
			case "effects.pullOutSegmentOnClick.speed":
			case "effects.pullOutSegmentOnClick.size":
			case "effects.highlightSegmentOnMouseover":
			case "effects.highlightLuminosity":
				helpers.processObj(this.options, propKey, value);
				break;

			// everything else, attempt to update it & do a repaint
			default:
				helpers.processObj(this.options, propKey, value);

				this.destroy();
				this.recreate();
				break;
		}
	};


	// ------------------------------------------------------------------------------------------------

	var _setupData = function () {
        this.options.data.content = math.sortPieData(this);
        if (this.options.data.smallSegmentGrouping.enabled) {
            this.options.data.content = helpers.applySmallSegmentGrouping(this.options.data.content, this.options.data.smallSegmentGrouping);
        }


        this.options.colors = helpers.initSegmentColors(this);
        this.totalSize      = math.getTotalPieSize(this.options.data.content);

        var dp = this.options.labels.percentage.decimalPlaces;

        // add in percentage data to content
        for (var i=0; i<this.options.data.content.length; i++) {
            this.options.data.content[i].percentage = _getPercentage(this.options.data.content[i].value, this.totalSize, dp);
        }

        // adjust the final item to ensure the percentage always adds up to precisely 100%. This is necessary
		var totalPercentage = 0;
        for (var j=0; j<this.options.data.content.length; j++) {
        	if (j === this.options.data.content.length - 1) {
                this.options.data.content[j].percentage = (100 - totalPercentage).toFixed(dp);
			}
			totalPercentage += parseFloat(this.options.data.content[j].percentage);
        }
	};

	var _init = function() {

		// prep-work
		this.svg = helpers.addSVGSpace(this);

		// store info about the main text components as part of the d3pie object instance
		this.textComponents = {
			headerHeight: 0,
			title: {
				exists: this.options.header.title.text !== "",
				h: 0,
				w: 0
			},
			subtitle: {
				exists: this.options.header.subtitle.text !== "",
				h: 0,
				w: 0
			},
			footer: {
				exists: this.options.footer.text !== "",
				h: 0,
				w: 0
			}
		};

		this.outerLabelGroupData = [];

		// add the key text components offscreen (title, subtitle, footer). We need to know their widths/heights for later computation
		if (this.textComponents.title.exists) {
			text.addTitle(this);
		}
		if (this.textComponents.subtitle.exists) {
			text.addSubtitle(this);
		}
		text.addFooter(this);

		// the footer never moves. Put it in place now
		var self = this;
		helpers.whenIdExists(this.cssPrefix + "footer", function() {
			text.positionFooter(self);
			var d3 = helpers.getDimensions(self.cssPrefix + "footer");
			self.textComponents.footer.h = d3.h;
			self.textComponents.footer.w = d3.w;
		});

		// now create the pie chart and position everything accordingly
		var reqEls = [];
		if (this.textComponents.title.exists)    { reqEls.push(this.cssPrefix + "title"); }
		if (this.textComponents.subtitle.exists) { reqEls.push(this.cssPrefix + "subtitle"); }
		if (this.textComponents.footer.exists)   { reqEls.push(this.cssPrefix + "footer"); }

		helpers.whenElementsExist(reqEls, function() {
			if (self.textComponents.title.exists) {
				var d1 = helpers.getDimensions(self.cssPrefix + "title");
				self.textComponents.title.h = d1.h;
				self.textComponents.title.w = d1.w;
			}
			if (self.textComponents.subtitle.exists) {
				var d2 = helpers.getDimensions(self.cssPrefix + "subtitle");
				self.textComponents.subtitle.h = d2.h;
				self.textComponents.subtitle.w = d2.w;
			}
			// now compute the full header height
			if (self.textComponents.title.exists || self.textComponents.subtitle.exists) {
				var headerHeight = 0;
				if (self.textComponents.title.exists) {
					headerHeight += self.textComponents.title.h;
					if (self.textComponents.subtitle.exists) {
						headerHeight += self.options.header.titleSubtitlePadding;
					}
				}
				if (self.textComponents.subtitle.exists) {
					headerHeight += self.textComponents.subtitle.h;
				}
				self.textComponents.headerHeight = headerHeight;
			}

			// at this point, all main text component dimensions have been calculated
			math.computePieRadius(self);

			// this value is used all over the place for placing things and calculating locations. We figure it out ONCE
			// and store it as part of the object
			math.calculatePieCenter(self);

			// position the title and subtitle
			text.positionTitle(self);
			text.positionSubtitle(self);

			// now create the pie chart segments, and gradients if the user desired
			if (self.options.misc.gradient.enabled) {
				segments.addGradients(self);
			}
			segments.create(self); // also creates this.arc
			labels.add(self, "inner", self.options.labels.inner.format);
			labels.add(self, "outer", self.options.labels.outer.format);

			// position the label elements relatively within their individual group (label, percentage, value)
			labels.positionLabelElements(self, "inner", self.options.labels.inner.format);
			labels.positionLabelElements(self, "outer", self.options.labels.outer.format);
			labels.computeOuterLabelCoords(self);

			// this is (and should be) dumb. It just places the outer groups at their calculated, collision-free positions
			labels.positionLabelGroups(self, "outer");

			// we use the label line positions for many other calculations, so ALWAYS compute them
			labels.computeLabelLinePositions(self);

			// only add them if they're actually enabled
			if (self.options.labels.lines.enabled && self.options.labels.outer.format !== "none") {
				labels.addLabelLines(self);
			}

			labels.positionLabelGroups(self, "inner");
			labels.fadeInLabelsAndLines(self);

			// add and position the tooltips
			if (self.options.tooltips.enabled) {
				tt.addTooltips(self);
			}

			segments.addSegmentEventHandlers(self);
		});
	};

	var _getPercentage = function(value, total, decimalPlaces) {
		var relativeAmount = value / total;
		if (decimalPlaces <= 0) {
			return Math.round(relativeAmount * 100);
		} else {
			return (relativeAmount * 100).toFixed(decimalPlaces);
		}
	};

    return d3pie;
}));

/*!
* d3pie
* @author Ben Keen
* @version 0.2.1
* @date March 11, 2017
* @repo http://github.com/benkeen/d3pie
*/
!function(a,b){"function"==typeof define&&define.amd?define([],b):"object"==typeof exports?module.exports=b():a.d3pie=b(a)}(this,function(){var a="d3pie",b="0.2.1",c=0,e={header:{title:{text:"",color:"#333333",fontSize:18,font:"arial"},subtitle:{text:"",color:"#666666",fontSize:14,font:"arial"},location:"top-center",titleSubtitlePadding:8},footer:{text:"",color:"#666666",fontSize:14,font:"arial",location:"left"},size:{canvasHeight:500,canvasWidth:500,pieInnerRadius:"0%",pieOuterRadius:null},data:{sortOrder:"none",ignoreSmallSegments:{enabled:!1,valueType:"percentage",value:null},smallSegmentGrouping:{enabled:!1,value:1,valueType:"percentage",label:"Other",color:"#cccccc"},content:[]},labels:{outer:{format:"label",hideWhenLessThanPercentage:null,pieDistance:30},inner:{format:"percentage",hideWhenLessThanPercentage:null},mainLabel:{color:"#333333",font:"arial",fontSize:10},percentage:{color:"#dddddd",font:"arial",fontSize:10,decimalPlaces:0},value:{color:"#cccc44",font:"arial",fontSize:10},lines:{enabled:!0,style:"curved",color:"segment"},truncation:{enabled:!1,truncateLength:30},formatter:null},effects:{load:{effect:"default",speed:1e3},pullOutSegmentOnClick:{effect:"bounce",speed:300,size:10},highlightSegmentOnMouseover:!0,highlightLuminosity:-.2},tooltips:{enabled:!1,type:"placeholder",string:"",placeholderParser:null,styles:{fadeInSpeed:250,backgroundColor:"#000000",backgroundOpacity:.5,color:"#efefef",borderRadius:2,font:"arial",fontSize:10,padding:4}},misc:{colors:{background:null,segments:["#2484c1","#65a620","#7b6888","#a05d56","#961a1a","#d8d23a","#e98125","#d0743c","#635222","#6ada6a","#0c6197","#7d9058","#207f33","#44b9b0","#bca44a","#e4a14b","#a3acb2","#8cc3e9","#69a6f9","#5b388f","#546e91","#8bde95","#d2ab58","#273c71","#98bf6e","#4daa4b","#98abc5","#cc1010","#31383b","#006391","#c2643f","#b0a474","#a5a39c","#a9c2bc","#22af8c","#7fcecf","#987ac6","#3d3b87","#b77b1c","#c9c2b6","#807ece","#8db27c","#be66a2","#9ed3c6","#00644b","#005064","#77979f","#77e079","#9c73ab","#1f79a7"],segmentStroke:"#ffffff"},gradient:{enabled:!1,percentage:95,color:"#000000"},canvasPadding:{top:5,right:5,bottom:5,left:5},pieCenterOffset:{x:0,y:0},cssPrefix:null},callbacks:{onload:null,onMouseoverSegment:null,onMouseoutSegment:null,onClickSegment:null}},f={initialCheck:function(a){var b=a.cssPrefix,c=a.element,d=a.options;if(!window.d3||!window.d3.hasOwnProperty("version"))return console.error("d3pie error: d3 is not available"),!1;if(!(c instanceof HTMLElement||c instanceof SVGElement))return console.error("d3pie error: the first d3pie() param must be a valid DOM element (not jQuery) or a ID string."),!1;if(!/[a-zA-Z][a-zA-Z0-9_-]*$/.test(b))return console.error("d3pie error: invalid options.misc.cssPrefix"),!1;if(!g.isArray(d.data.content))return console.error("d3pie error: invalid config structure: missing data.content property."),!1;if(0===d.data.content.length)return console.error("d3pie error: no data supplied."),!1;for(var e=[],f=0;f<d.data.content.length;f++)"number"!=typeof d.data.content[f].value||isNaN(d.data.content[f].value)?console.log("not valid: ",d.data.content[f]):d.data.content[f].value<=0?console.log("not valid - should have positive value: ",d.data.content[f]):e.push(d.data.content[f]);return a.options.data.content=e,!0}},g={addSVGSpace:function(a){var b=a.element,c=a.options.size.canvasWidth,d=a.options.size.canvasHeight,e=a.options.misc.colors.background,f=d3.select(b).append("svg:svg").attr("width",c).attr("height",d);return"transparent"!==e&&f.style("background-color",function(){return e}),f},whenIdExists:function(a,b){var c=1,d=1e3,e=setInterval(function(){document.getElementById(a)&&(clearInterval(e),b()),c>d&&clearInterval(e),c++},1)},whenElementsExist:function(a,b){var c=1,d=1e3,e=setInterval(function(){for(var f=!0,g=0;g<a.length;g++)if(!document.getElementById(a[g])){f=!1;break}f&&(clearInterval(e),b()),c>d&&clearInterval(e),c++},1)},shuffleArray:function(a){for(var b,c,d=a.length;0!==d;)c=Math.floor(Math.random()*d),d-=1,b=a[d],a[d]=a[c],a[c]=b;return a},processObj:function(a,b,c){return"string"==typeof b?g.processObj(a,b.split("."),c):1===b.length&&void 0!==c?(a[b[0]]=c,a[b[0]]):0===b.length?a:g.processObj(a[b[0]],b.slice(1),c)},getDimensions:function(a){var b=document.getElementById(a),c=0,d=0;if(b){var e=b.getBBox();c=e.width,d=e.height}else console.log("error: getDimensions() "+a+" not found.");return{w:c,h:d}},rectIntersect:function(a,b){var c=b.x>a.x+a.w||b.x+b.w<a.x||b.y+b.h<a.y||b.y>a.y+a.h;return!c},getColorShade:function(a,b){a=String(a).replace(/[^0-9a-f]/gi,""),a.length<6&&(a=a[0]+a[0]+a[1]+a[1]+a[2]+a[2]),b=b||0;for(var c="#",d=0;3>d;d++){var e=parseInt(a.substr(2*d,2),16);e=Math.round(Math.min(Math.max(0,e+e*b),255)).toString(16),c+=("00"+e).substr(e.length)}return c},initSegmentColors:function(a){for(var b=a.options.data.content,c=a.options.misc.colors.segments,d=[],e=0;e<b.length;e++)b[e].hasOwnProperty("color")?d.push(b[e].color):d.push(c[e]);return d},applySmallSegmentGrouping:function(a,b){var c;"percentage"===b.valueType&&(c=i.getTotalPieSize(a));for(var d=[],e=[],f=0,g=0;g<a.length;g++)if("percentage"===b.valueType){var h=a[g].value/c*100;if(h<=b.value){e.push(a[g]),f+=a[g].value;continue}a[g].isGrouped=!1,d.push(a[g])}else{if(a[g].value<=b.value){e.push(a[g]),f+=a[g].value;continue}a[g].isGrouped=!1,d.push(a[g])}return e.length&&d.push({color:b.color,label:b.label,value:f,isGrouped:!0,groupedData:e}),d},showPoint:function(a,b,c){a.append("circle").attr("cx",b).attr("cy",c).attr("r",2).style("fill","black")},isFunction:function(a){var b={};return a&&"[object Function]"===b.toString.call(a)},isArray:function(a){return"[object Array]"===Object.prototype.toString.call(a)}},h=function(){var a,b,c,d,e,f,g=arguments[0]||{},i=1,j=arguments.length,k=!1,l=Object.prototype.toString,m=Object.prototype.hasOwnProperty,n={"[object Boolean]":"boolean","[object Number]":"number","[object String]":"string","[object Function]":"function","[object Array]":"array","[object Date]":"date","[object RegExp]":"regexp","[object Object]":"object"},o={isFunction:function(a){return"function"===o.type(a)},isArray:Array.isArray||function(a){return"array"===o.type(a)},isWindow:function(a){return null!==a&&a===a.window},isNumeric:function(a){return!isNaN(parseFloat(a))&&isFinite(a)},type:function(a){return null===a?String(a):n[l.call(a)]||"object"},isPlainObject:function(a){if(!a||"object"!==o.type(a)||a.nodeType)return!1;try{if(a.constructor&&!m.call(a,"constructor")&&!m.call(a.constructor.prototype,"isPrototypeOf"))return!1}catch(b){return!1}var c;for(c in a);return void 0===c||m.call(a,c)}};for("boolean"==typeof g&&(k=g,g=arguments[1]||{},i=2),"object"==typeof g||o.isFunction(g)||(g={}),j===i&&(g=this,--i),i;j>i;i++)if(null!==(a=arguments[i]))for(b in a)c=g[b],d=a[b],g!==d&&(k&&d&&(o.isPlainObject(d)||(e=o.isArray(d)))?(e?(e=!1,f=c&&o.isArray(c)?c:[]):f=c&&o.isPlainObject(c)?c:{},g[b]=h(k,f,d)):void 0!==d&&(g[b]=d));return g},i={toRadians:function(a){return a*(Math.PI/180)},toDegrees:function(a){return a*(180/Math.PI)},computePieRadius:function(a){var b=a.options.size,c=a.options.misc.canvasPadding,d=b.canvasWidth-c.left-c.right,e=b.canvasHeight-c.top-c.bottom;"pie-center"!==a.options.header.location&&(e-=a.textComponents.headerHeight),a.textComponents.footer.exists&&(e-=a.textComponents.footer.h),e=0>e?0:e;var f,g,h=(e>d?d:e)/3;if(null!==b.pieOuterRadius)if(/%/.test(b.pieOuterRadius)){g=parseInt(b.pieOuterRadius.replace(/[\D]/,""),10),g=g>99?99:g,g=0>g?0:g;var i=e>d?d:e;if("none"!==a.options.labels.outer.format){var j=2*parseInt(a.options.labels.outer.pieDistance,10);i-j>0&&(i-=j)}h=Math.floor(i/100*g)/2}else h=parseInt(b.pieOuterRadius,10);/%/.test(b.pieInnerRadius)?(g=parseInt(b.pieInnerRadius.replace(/[\D]/,""),10),g=g>99?99:g,g=0>g?0:g,f=Math.floor(h/100*g)):f=parseInt(b.pieInnerRadius,10),a.innerRadius=f,a.outerRadius=h},getTotalPieSize:function(a){for(var b=0,c=0;c<a.length;c++)b+=a[c].value;return b},sortPieData:function(a){var b=a.options.data.content,c=a.options.data.sortOrder;switch(c){case"none":break;case"random":b=g.shuffleArray(b);break;case"value-asc":b.sort(function(a,b){return a.value<b.value?-1:1});break;case"value-desc":b.sort(function(a,b){return a.value<b.value?1:-1});break;case"label-asc":b.sort(function(a,b){return a.label.toLowerCase()>b.label.toLowerCase()?1:-1});break;case"label-desc":b.sort(function(a,b){return a.label.toLowerCase()<b.label.toLowerCase()?1:-1})}return b},getPieTranslateCenter:function(a){return"translate("+a.x+","+a.y+")"},calculatePieCenter:function(a){var b=a.options.misc.pieCenterOffset,c=a.textComponents.title.exists&&"pie-center"!==a.options.header.location,d=a.textComponents.subtitle.exists&&"pie-center"!==a.options.header.location,e=a.options.misc.canvasPadding.top;c&&d?e+=a.textComponents.title.h+a.options.header.titleSubtitlePadding+a.textComponents.subtitle.h:c?e+=a.textComponents.title.h:d&&(e+=a.textComponents.subtitle.h);var f=0;a.textComponents.footer.exists&&(f=a.textComponents.footer.h+a.options.misc.canvasPadding.bottom);var g=(a.options.size.canvasWidth-a.options.misc.canvasPadding.left-a.options.misc.canvasPadding.right)/2+a.options.misc.canvasPadding.left,h=(a.options.size.canvasHeight-f-e)/2+e;g+=b.x,h+=b.y,a.pieCenter={x:g,y:h}},rotate:function(a,b,c,d,e){e=e*Math.PI/180;var f=Math.cos,g=Math.sin,h=(a-c)*f(e)-(b-d)*g(e)+c,i=(a-c)*g(e)+(b-d)*f(e)+d;return{x:h,y:i}},translate:function(a,b,c,d){var e=i.toRadians(d);return{x:a+c*Math.sin(e),y:b-c*Math.cos(e)}},pointIsInArc:function(a,b,c){var d=c.innerRadius()(b),e=c.outerRadius()(b),f=c.startAngle()(b),g=c.endAngle()(b),h=a.x*a.x+a.y*a.y,i=Math.atan2(a.x,-a.y);return i=0>i?i+2*Math.PI:i,h>=d*d&&e*e>=h&&i>=f&&g>=i}},j={add:function(a,b,c){var d=j.getIncludes(c),e=a.options.labels,f=a.svg.insert("g","."+a.cssPrefix+"labels-"+b).attr("class",a.cssPrefix+"labels-"+b),g=f.selectAll("."+a.cssPrefix+"labelGroup-"+b).data(a.options.data.content).enter().append("g").attr("id",function(c,d){return a.cssPrefix+"labelGroup"+d+"-"+b}).attr("data-index",function(a,b){return b}).attr("class",a.cssPrefix+"labelGroup-"+b).style("opacity",0),h={section:b,sectionDisplayType:c};d.mainLabel&&g.append("text").attr("id",function(c,d){return a.cssPrefix+"segmentMainLabel"+d+"-"+b}).attr("class",a.cssPrefix+"segmentMainLabel-"+b).text(function(a,b){var c=a.label;return e.formatter?(h.index=b,h.part="mainLabel",h.value=a.value,h.label=c,c=e.formatter(h)):e.truncation.enabled&&a.label.length>e.truncation.truncateLength&&(c=a.label.substring(0,e.truncation.truncateLength)+"..."),c}).style("font-size",e.mainLabel.fontSize+"px").style("font-family",e.mainLabel.font).style("fill",e.mainLabel.color),d.percentage&&g.append("text").attr("id",function(c,d){return a.cssPrefix+"segmentPercentage"+d+"-"+b}).attr("class",a.cssPrefix+"segmentPercentage-"+b).text(function(a,b){var c=a.percentage;return e.formatter?(h.index=b,h.part="percentage",h.value=a.value,h.label=a.percentage,c=e.formatter(h)):c+="%",c}).style("font-size",e.percentage.fontSize+"px").style("font-family",e.percentage.font).style("fill",e.percentage.color),d.value&&g.append("text").attr("id",function(c,d){return a.cssPrefix+"segmentValue"+d+"-"+b}).attr("class",a.cssPrefix+"segmentValue-"+b).text(function(a,b){return h.index=b,h.part="value",h.value=a.value,h.label=a.value,e.formatter?e.formatter(h,a.value):a.value}).style("font-size",e.value.fontSize+"px").style("font-family",e.value.font).style("fill",e.value.color)},positionLabelElements:function(a,b,c){j["dimensions-"+b]=[];var d=d3.selectAll("."+a.cssPrefix+"labelGroup-"+b);d.each(function(c,d){var e=d3.select(this).selectAll("."+a.cssPrefix+"segmentMainLabel-"+b),f=d3.select(this).selectAll("."+a.cssPrefix+"segmentPercentage-"+b),g=d3.select(this).selectAll("."+a.cssPrefix+"segmentValue-"+b);j["dimensions-"+b].push({mainLabel:null!==e.node()?e.node().getBBox():null,percentage:null!==f.node()?f.node().getBBox():null,value:null!==g.node()?g.node().getBBox():null})});var e=5,f=j["dimensions-"+b];switch(c){case"label-value1":d3.selectAll("."+a.cssPrefix+"segmentValue-"+b).attr("dx",function(a,b){return f[b].mainLabel.width+e});break;case"label-value2":d3.selectAll("."+a.cssPrefix+"segmentValue-"+b).attr("dy",function(a,b){return f[b].mainLabel.height});break;case"label-percentage1":d3.selectAll("."+a.cssPrefix+"segmentPercentage-"+b).attr("dx",function(a,b){return f[b].mainLabel.width+e});break;case"label-percentage2":d3.selectAll("."+a.cssPrefix+"segmentPercentage-"+b).attr("dx",function(a,b){return f[b].mainLabel.width/2-f[b].percentage.width/2}).attr("dy",function(a,b){return f[b].mainLabel.height})}},computeLabelLinePositions:function(a){a.lineCoordGroups=[],d3.selectAll("."+a.cssPrefix+"labelGroup-outer").each(function(b,c){return j.computeLinePosition(a,c)})},computeLinePosition:function(a,b){var c,d,e,f,g=k.getSegmentAngle(b,a.options.data.content,a.totalSize,{midpoint:!0}),h=i.rotate(a.pieCenter.x,a.pieCenter.y-a.outerRadius,a.pieCenter.x,a.pieCenter.y,g),j=a.outerLabelGroupData[b].h/5,l=6,m=Math.floor(g/90),n=4;switch(2===m&&180===g&&(m=1),m){case 0:c=a.outerLabelGroupData[b].x-l-(a.outerLabelGroupData[b].x-l-h.x)/2,d=a.outerLabelGroupData[b].y+(h.y-a.outerLabelGroupData[b].y)/n,e=a.outerLabelGroupData[b].x-l,f=a.outerLabelGroupData[b].y-j;break;case 1:c=h.x+(a.outerLabelGroupData[b].x-h.x)/n,d=h.y+(a.outerLabelGroupData[b].y-h.y)/n,e=a.outerLabelGroupData[b].x-l,f=a.outerLabelGroupData[b].y-j;break;case 2:var o=a.outerLabelGroupData[b].x+a.outerLabelGroupData[b].w+l;c=h.x-(h.x-o)/n,d=h.y+(a.outerLabelGroupData[b].y-h.y)/n,e=a.outerLabelGroupData[b].x+a.outerLabelGroupData[b].w+l,f=a.outerLabelGroupData[b].y-j;break;case 3:var p=a.outerLabelGroupData[b].x+a.outerLabelGroupData[b].w+l;c=p+(h.x-p)/n,d=a.outerLabelGroupData[b].y+(h.y-a.outerLabelGroupData[b].y)/n,e=a.outerLabelGroupData[b].x+a.outerLabelGroupData[b].w+l,f=a.outerLabelGroupData[b].y-j}"straight"===a.options.labels.lines.style?a.lineCoordGroups[b]=[{x:h.x,y:h.y},{x:e,y:f}]:a.lineCoordGroups[b]=[{x:h.x,y:h.y},{x:c,y:d},{x:e,y:f}]},addLabelLines:function(a){var b=a.svg.insert("g","."+a.cssPrefix+"pieChart").attr("class",a.cssPrefix+"lineGroups").style("opacity",0),c=b.selectAll("."+a.cssPrefix+"lineGroup").data(a.lineCoordGroups).enter().append("g").attr("class",a.cssPrefix+"lineGroup"),d=d3.line().curve(d3.curveBasis).x(function(a){return a.x}).y(function(a){return a.y});c.append("path").attr("d",d).attr("stroke",function(b,c){return"segment"===a.options.labels.lines.color?a.options.colors[c]:a.options.labels.lines.color}).attr("stroke-width",1).attr("fill","none").style("opacity",function(b,c){var d=a.options.labels.outer.hideWhenLessThanPercentage,e=null!==d&&b.percentage<d||""===a.options.data.content[c].label;return e?0:1})},positionLabelGroups:function(a,b){"none"!==a.options.labels[b].format&&d3.selectAll("."+a.cssPrefix+"labelGroup-"+b).style("opacity",0).attr("transform",function(c,d){var e,f;if("outer"===b)e=a.outerLabelGroupData[d].x,f=a.outerLabelGroupData[d].y;else{var j=h(!0,{},a.pieCenter);if(a.innerRadius>0){var l=k.getSegmentAngle(d,a.options.data.content,a.totalSize,{midpoint:!0}),m=i.translate(a.pieCenter.x,a.pieCenter.y,a.innerRadius,l);j.x=m.x,j.y=m.y}var n=g.getDimensions(a.cssPrefix+"labelGroup"+d+"-inner"),o=n.w/2,p=n.h/4;e=j.x+(a.lineCoordGroups[d][0].x-j.x)/1.8,f=j.y+(a.lineCoordGroups[d][0].y-j.y)/1.8,e-=o,f+=p}return"translate("+e+","+f+")"})},fadeInLabelsAndLines:function(a){var b="default"===a.options.effects.load.effect?a.options.effects.load.speed:1;setTimeout(function(){var b="default"===a.options.effects.load.effect?400:1;d3.selectAll("."+a.cssPrefix+"labelGroup-outer").transition().duration(b).style("opacity",function(b,c){var d=a.options.labels.outer.hideWhenLessThanPercentage;return null!==d&&b.percentage<d?0:1}),d3.selectAll("."+a.cssPrefix+"labelGroup-inner").transition().duration(b).style("opacity",function(b,c){var d=a.options.labels.inner.hideWhenLessThanPercentage;return null!==d&&b.percentage<d?0:1}),d3.selectAll("g."+a.cssPrefix+"lineGroups").transition().duration(b).style("opacity",1),g.isFunction(a.options.callbacks.onload)&&setTimeout(function(){try{a.options.callbacks.onload()}catch(b){}},b)},b)},getIncludes:function(a){var b=!1,c=!1,d=!1;switch(a){case"label":b=!0;break;case"value":c=!0;break;case"percentage":d=!0;break;case"label-value1":case"label-value2":b=!0,c=!0;break;case"label-percentage1":case"label-percentage2":b=!0,d=!0}return{mainLabel:b,value:c,percentage:d}},computeOuterLabelCoords:function(a){a.svg.selectAll("."+a.cssPrefix+"labelGroup-outer").each(function(b,c){return j.getIdealOuterLabelPositions(a,c)}),j.resolveOuterLabelCollisions(a)},resolveOuterLabelCollisions:function(a){if("none"!==a.options.labels.outer.format){var b=a.options.data.content.length;j.checkConflict(a,0,"clockwise",b),j.checkConflict(a,b-1,"anticlockwise",b)}},checkConflict:function(a,b,c,d){var e,f;if(!(1>=d)){var h=a.outerLabelGroupData[b].hs;if(!("clockwise"===c&&"right"!==h||"anticlockwise"===c&&"left"!==h)){var i="clockwise"===c?b+1:b-1,k=a.outerLabelGroupData[b],l=a.outerLabelGroupData[i],m={labelHeights:a.outerLabelGroupData[0].h,center:a.pieCenter,lineLength:a.outerRadius+a.options.labels.outer.pieDistance,heightChange:a.outerLabelGroupData[0].h+1};if("clockwise"===c){for(e=0;b>=e;e++)if(f=a.outerLabelGroupData[e],!j.isLabelHidden(a,e)&&g.rectIntersect(f,l)){j.adjustLabelPos(a,i,k,m);break}}else for(e=d-1;e>=b;e--)if(f=a.outerLabelGroupData[e],!j.isLabelHidden(a,e)&&g.rectIntersect(f,l)){j.adjustLabelPos(a,i,k,m);break}j.checkConflict(a,i,c,d)}}},isLabelHidden:function(a,b){var c=a.options.labels.outer.hideWhenLessThanPercentage;return null!==c&&d.percentage<c||""===a.options.data.content[b].label},adjustLabelPos:function(a,b,c,d){var e,f,g,h;h=c.y+d.heightChange,f=d.center.y-h,e=Math.abs(d.lineLength)>Math.abs(f)?Math.sqrt(d.lineLength*d.lineLength-f*f):Math.sqrt(f*f-d.lineLength*d.lineLength),g="right"===c.hs?d.center.x+e:d.center.x-e-a.outerLabelGroupData[b].w,a.outerLabelGroupData[b].x=g,a.outerLabelGroupData[b].y=h},getIdealOuterLabelPositions:function(a,b){var c=d3.select("#"+a.cssPrefix+"labelGroup"+b+"-outer").node();if(c){var d=c.getBBox(),e=k.getSegmentAngle(b,a.options.data.content,a.totalSize,{midpoint:!0}),f=a.pieCenter.x,g=a.pieCenter.y-(a.outerRadius+a.options.labels.outer.pieDistance),h=i.rotate(f,g,a.pieCenter.x,a.pieCenter.y,e),j="right";e>180?(h.x-=d.width+8,j="left"):h.x+=8,a.outerLabelGroupData[b]={x:h.x,y:h.y,w:d.width,h:d.height,hs:j}}}},k={effectMap:{none:d3.easeLinear,bounce:d3.easeBounce,linear:d3.easeLinear,sin:d3.easeSin,elastic:d3.easeElastic,back:d3.easeBack,quad:d3.easeQuad,circle:d3.easeCircle,exp:d3.easeExp},create:function(a){var b=a.pieCenter,c=a.options.colors,d=a.options.effects.load,e=a.options.misc.colors.segmentStroke,f=a.svg.insert("g","#"+a.cssPrefix+"title").attr("transform",function(){return i.getPieTranslateCenter(b)}).attr("class",a.cssPrefix+"pieChart"),g=d3.arc().innerRadius(a.innerRadius).outerRadius(a.outerRadius).startAngle(0).endAngle(function(b){return b.value/a.totalSize*2*Math.PI}),h=f.selectAll("."+a.cssPrefix+"arc").data(a.options.data.content).enter().append("g").attr("class",a.cssPrefix+"arc"),j=d.speed;"none"===d.effect&&(j=0),h.append("path").attr("id",function(b,c){return a.cssPrefix+"segment"+c}).attr("fill",function(b,d){var e=c[d];return a.options.misc.gradient.enabled&&(e="url(#"+a.cssPrefix+"grad"+d+")"),e}).style("stroke",e).style("stroke-width",1).transition().ease(d3.easeCubicInOut).duration(j).attr("data-index",function(a,b){return b}).attrTween("d",function(b){var c=d3.interpolate({value:0},b);return function(b){return a.arc(c(b))}}),a.svg.selectAll("g."+a.cssPrefix+"arc").attr("transform",function(b,c){var d=0;return c>0&&(d=k.getSegmentAngle(c-1,a.options.data.content,a.totalSize)),"rotate("+d+")"}),a.arc=g},addGradients:function(a){var b=a.svg.append("defs").selectAll("radialGradient").data(a.options.data.content).enter().append("radialGradient").attr("gradientUnits","userSpaceOnUse").attr("cx",0).attr("cy",0).attr("r","120%").attr("id",function(b,c){return a.cssPrefix+"grad"+c});b.append("stop").attr("offset","0%").style("stop-color",function(b,c){return a.options.colors[c]}),b.append("stop").attr("offset",a.options.misc.gradient.percentage+"%").style("stop-color",a.options.misc.gradient.color)},addSegmentEventHandlers:function(a){var b=d3.selectAll("."+a.cssPrefix+"arc,."+a.cssPrefix+"labelGroup-inner,."+a.cssPrefix+"labelGroup-outer");b.on("click",function(){var b,c=d3.select(this);if(c.attr("class")===a.cssPrefix+"arc")b=c.select("path");else{var d=c.attr("data-index");b=d3.select("#"+a.cssPrefix+"segment"+d)}var e=b.attr("class")===a.cssPrefix+"expanded";k.onSegmentEvent(a,a.options.callbacks.onClickSegment,b,e),"none"!==a.options.effects.pullOutSegmentOnClick.effect&&(e?k.closeSegment(a,b.node()):k.openSegment(a,b.node()))}),b.on("mouseover",function(){var b,c,d=d3.select(this);if(d.attr("class")===a.cssPrefix+"arc"?b=d.select("path"):(c=d.attr("data-index"),b=d3.select("#"+a.cssPrefix+"segment"+c)),a.options.effects.highlightSegmentOnMouseover){c=b.attr("data-index");var e=a.options.colors[c];b.style("fill",g.getColorShade(e,a.options.effects.highlightLuminosity))}a.options.tooltips.enabled&&(c=b.attr("data-index"),m.showTooltip(a,c));var f=b.attr("class")===a.cssPrefix+"expanded";k.onSegmentEvent(a,a.options.callbacks.onMouseoverSegment,b,f)}),b.on("mousemove",function(){m.moveTooltip(a)}),b.on("mouseout",function(){var b,c,d=d3.select(this);if(d.attr("class")===a.cssPrefix+"arc"?b=d.select("path"):(c=d.attr("data-index"),b=d3.select("#"+a.cssPrefix+"segment"+c)),a.options.effects.highlightSegmentOnMouseover){c=b.attr("data-index");var e=a.options.colors[c];a.options.misc.gradient.enabled&&(e="url(#"+a.cssPrefix+"grad"+c+")"),b.style("fill",e)}a.options.tooltips.enabled&&(c=b.attr("data-index"),m.hideTooltip(a,c));var f=b.attr("class")===a.cssPrefix+"expanded";k.onSegmentEvent(a,a.options.callbacks.onMouseoutSegment,b,f)})},onSegmentEvent:function(a,b,c,d){if(g.isFunction(b)){var e=parseInt(c.attr("data-index"),10);b({segment:c.node(),index:e,expanded:d,data:a.options.data.content[e]})}},openSegment:function(a,b){a.isOpeningSegment||(a.isOpeningSegment=!0,k.maybeCloseOpenSegment(),d3.select(b).transition().ease(k.effectMap[a.options.effects.pullOutSegmentOnClick.effect]).duration(a.options.effects.pullOutSegmentOnClick.speed).attr("transform",function(b,c){var d=a.arc.centroid(b),e=d[0],f=d[1],g=Math.sqrt(e*e+f*f),h=parseInt(a.options.effects.pullOutSegmentOnClick.size,10);return"translate("+e/g*h+","+f/g*h+")"}).on("end",function(c,d){a.currentlyOpenSegment=b,a.isOpeningSegment=!1,d3.select(b).attr("class",a.cssPrefix+"expanded")}))},maybeCloseOpenSegment:function(){d3.selectAll("."+pie.cssPrefix+"expanded").size()>0&&k.closeSegment(pie,d3.select("."+pie.cssPrefix+"expanded").node())},closeSegment:function(a,b){d3.select(b).transition().duration(400).attr("transform","translate(0,0)").on("end",function(c,d){d3.select(b).attr("class",""),a.currentlyOpenSegment=null})},getCentroid:function(a){var b=a.getBBox();return{x:b.x+b.width/2,y:b.y+b.height/2}},getSegmentAngle:function(a,b,c,d){var e,f=h({compounded:!0,midpoint:!1},d),g=b[a].value;if(f.compounded){e=0;for(var i=0;a>=i;i++)e+=b[i].value}"undefined"==typeof e&&(e=g);var j=e/c*360;if(f.midpoint){var k=g/c*360;j-=k/2}return j}},l={offscreenCoord:-1e4,addTitle:function(a){a.svg.selectAll("."+a.cssPrefix+"title").data([a.options.header.title]).enter().append("text").text(function(a){return a.text}).attr("id",a.cssPrefix+"title").attr("class",a.cssPrefix+"title").attr("x",l.offscreenCoord).attr("y",l.offscreenCoord).attr("text-anchor",function(){var b;return b="top-center"===a.options.header.location||"pie-center"===a.options.header.location?"middle":"left"}).attr("fill",function(a){return a.color}).style("font-size",function(a){return a.fontSize+"px"}).style("font-family",function(a){return a.font})},positionTitle:function(a){var b,c=a.textComponents,d=a.options.header.location,e=a.options.misc.canvasPadding,f=a.options.size.canvasWidth,g=a.options.header.titleSubtitlePadding;b="top-left"===d?e.left:(f-e.right)/2+e.left,b+=a.options.misc.pieCenterOffset.x;var h=e.top+c.title.h;if("pie-center"===d)if(h=a.pieCenter.y,c.subtitle.exists){var i=c.title.h+g+c.subtitle.h;h=h-i/2+c.title.h}else h+=c.title.h/4;a.svg.select("#"+a.cssPrefix+"title").attr("x",b).attr("y",h)},addSubtitle:function(a){var b=a.options.header.location;a.svg.selectAll("."+a.cssPrefix+"subtitle").data([a.options.header.subtitle]).enter().append("text").text(function(a){return a.text}).attr("x",l.offscreenCoord).attr("y",l.offscreenCoord).attr("id",a.cssPrefix+"subtitle").attr("class",a.cssPrefix+"subtitle").attr("text-anchor",function(){var a;return a="top-center"===b||"pie-center"===b?"middle":"left"}).attr("fill",function(a){return a.color}).style("font-size",function(a){return a.fontSize+"px"}).style("font-family",function(a){return a.font})},positionSubtitle:function(a){var b,c=a.options.misc.canvasPadding,d=a.options.size.canvasWidth;b="top-left"===a.options.header.location?c.left:(d-c.right)/2+c.left,b+=a.options.misc.pieCenterOffset.x;var e=l.getHeaderHeight(a);a.svg.select("#"+a.cssPrefix+"subtitle").attr("x",b).attr("y",e)},addFooter:function(a){a.svg.selectAll("."+a.cssPrefix+"footer").data([a.options.footer]).enter().append("text").text(function(a){return a.text}).attr("x",l.offscreenCoord).attr("y",l.offscreenCoord).attr("id",a.cssPrefix+"footer").attr("class",a.cssPrefix+"footer").attr("text-anchor",function(){var b="left";return"bottom-center"===a.options.footer.location?b="middle":"bottom-right"===a.options.footer.location&&(b="left"),b}).attr("fill",function(a){return a.color}).style("font-size",function(a){return a.fontSize+"px"}).style("font-family",function(a){return a.font})},positionFooter:function(a){var b,c=a.options.footer.location,d=a.textComponents.footer.w,e=a.options.size.canvasWidth,f=a.options.size.canvasHeight,g=a.options.misc.canvasPadding;b="bottom-left"===c?g.left:"bottom-right"===c?e-d-g.right:e/2,a.svg.select("#"+a.cssPrefix+"footer").attr("x",b).attr("y",f-g.bottom)},getHeaderHeight:function(a){var b;if(a.textComponents.title.exists){var c=a.textComponents.title.h+a.options.header.titleSubtitlePadding+a.textComponents.subtitle.h;b="pie-center"===a.options.header.location?a.pieCenter.y-c/2+c:c+a.options.misc.canvasPadding.top}else if("pie-center"===a.options.header.location){var d=a.options.misc.canvasPadding.bottom+a.textComponents.footer.h;b=(a.options.size.canvasHeight-d)/2+a.options.misc.canvasPadding.top+a.textComponents.subtitle.h/2}else b=a.options.misc.canvasPadding.top+a.textComponents.subtitle.h;return b}},m={addTooltips:function(a){var b=a.svg.insert("g").attr("class",a.cssPrefix+"tooltips");b.selectAll("."+a.cssPrefix+"tooltip").data(a.options.data.content).enter().append("g").attr("class",a.cssPrefix+"tooltip").attr("id",function(b,c){return a.cssPrefix+"tooltip"+c}).style("opacity",0).append("rect").attr("rx",a.options.tooltips.styles.borderRadius).attr("ry",a.options.tooltips.styles.borderRadius).attr("x",-a.options.tooltips.styles.padding).attr("opacity",a.options.tooltips.styles.backgroundOpacity).style("fill",a.options.tooltips.styles.backgroundColor),b.selectAll("."+a.cssPrefix+"tooltip").data(a.options.data.content).append("text").attr("fill",function(b){return a.options.tooltips.styles.color}).style("font-size",function(b){return a.options.tooltips.styles.fontSize}).style("font-family",function(b){return a.options.tooltips.styles.font}).text(function(b,c){var d=a.options.tooltips.string;return"caption"===a.options.tooltips.type&&(d=b.caption),m.replacePlaceholders(a,d,c,{label:b.label,value:b.value,percentage:b.percentage})}),b.selectAll("."+a.cssPrefix+"tooltip rect").attr("width",function(b,c){var d=g.getDimensions(a.cssPrefix+"tooltip"+c);return d.w+2*a.options.tooltips.styles.padding}).attr("height",function(b,c){var d=g.getDimensions(a.cssPrefix+"tooltip"+c);return d.h+2*a.options.tooltips.styles.padding}).attr("y",function(b,c){var d=g.getDimensions(a.cssPrefix+"tooltip"+c);return-(d.h/2)+1})},showTooltip:function(a,b){var c=a.options.tooltips.styles.fadeInSpeed;m.currentTooltip===b&&(c=1),m.currentTooltip=b,d3.select("#"+a.cssPrefix+"tooltip"+b).transition().duration(c).style("opacity",function(){return 1}),m.moveTooltip(a)},moveTooltip:function(a){d3.selectAll("#"+a.cssPrefix+"tooltip"+m.currentTooltip).attr("transform",function(b){var c=d3.mouse(this.parentNode),d=c[0]+a.options.tooltips.styles.padding+2,e=c[1]-2*a.options.tooltips.styles.padding-2;return"translate("+d+","+e+")"})},hideTooltip:function(a,b){d3.select("#"+a.cssPrefix+"tooltip"+b).style("opacity",function(){return 0}),d3.select("#"+a.cssPrefix+"tooltip"+m.currentTooltip).attr("transform",function(b,c){var d=a.options.size.canvasWidth+1e3,e=a.options.size.canvasHeight+1e3;return"translate("+d+","+e+")"})},replacePlaceholders:function(a,b,c,d){g.isFunction(a.options.tooltips.placeholderParser)&&a.options.tooltips.placeholderParser(c,d);var e=function(){return function(a){var b=arguments[1];return d.hasOwnProperty(b)?d[arguments[1]]:arguments[0]}};return b.replace(/\{(\w+)\}/g,e(d))}},n=function(d,g){if(this.element=d,"string"==typeof d){var i=d.replace(/^#/,"");this.element=document.getElementById(i)}var j={};h(!0,j,e,g),this.options=j,null!==this.options.misc.cssPrefix?this.cssPrefix=this.options.misc.cssPrefix:(this.cssPrefix="p"+c+"_",c++),f.initialCheck(this)&&(d3.select(this.element).attr(a,b),o.call(this),p.call(this))};n.prototype.recreate=function(){f.initialCheck(this)&&(o.call(this),p.call(this))},n.prototype.redraw=function(){this.element.innerHTML="",p.call(this)},n.prototype.destroy=function(){this.element.innerHTML="",d3.select(this.element).attr(a,null)},n.prototype.getOpenSegment=function(){var a=this.currentlyOpenSegment;if(null!==a&&"undefined"!=typeof a){var b=parseInt(d3.select(a).attr("data-index"),10);return{element:a,index:b,data:this.options.data.content[b]}}return null},n.prototype.openSegment=function(a){a=parseInt(a,10),0>a||a>this.options.data.content.length-1||k.openSegment(this,d3.select("#"+this.cssPrefix+"segment"+a).node())},n.prototype.closeSegment=function(){k.maybeCloseOpenSegment()},n.prototype.updateProp=function(a,b){switch(a){case"header.title.text":var c=g.processObj(this.options,a);g.processObj(this.options,a,b),d3.select("#"+this.cssPrefix+"title").html(b),(""===c&&""!==b||""!==c&&""===b)&&this.redraw();break;case"header.subtitle.text":var d=g.processObj(this.options,a);g.processObj(this.options,a,b),d3.select("#"+this.cssPrefix+"subtitle").html(b),(""===d&&""!==b||""!==d&&""===b)&&this.redraw();break;case"callbacks.onload":case"callbacks.onMouseoverSegment":case"callbacks.onMouseoutSegment":case"callbacks.onClickSegment":case"effects.pullOutSegmentOnClick.effect":case"effects.pullOutSegmentOnClick.speed":case"effects.pullOutSegmentOnClick.size":case"effects.highlightSegmentOnMouseover":case"effects.highlightLuminosity":g.processObj(this.options,a,b);break;default:g.processObj(this.options,a,b),this.destroy(),this.recreate()}};var o=function(){this.options.data.content=i.sortPieData(this),this.options.data.smallSegmentGrouping.enabled&&(this.options.data.content=g.applySmallSegmentGrouping(this.options.data.content,this.options.data.smallSegmentGrouping)),this.options.colors=g.initSegmentColors(this),this.totalSize=i.getTotalPieSize(this.options.data.content);for(var a=this.options.labels.percentage.decimalPlaces,b=0;b<this.options.data.content.length;b++)this.options.data.content[b].percentage=q(this.options.data.content[b].value,this.totalSize,a);for(var c=0,d=0;d<this.options.data.content.length;d++)d===this.options.data.content.length-1&&(this.options.data.content[d].percentage=(100-c).toFixed(a)),c+=parseFloat(this.options.data.content[d].percentage)},p=function(){this.svg=g.addSVGSpace(this),this.textComponents={
headerHeight:0,title:{exists:""!==this.options.header.title.text,h:0,w:0},subtitle:{exists:""!==this.options.header.subtitle.text,h:0,w:0},footer:{exists:""!==this.options.footer.text,h:0,w:0}},this.outerLabelGroupData=[],this.textComponents.title.exists&&l.addTitle(this),this.textComponents.subtitle.exists&&l.addSubtitle(this),l.addFooter(this);var a=this;g.whenIdExists(this.cssPrefix+"footer",function(){l.positionFooter(a);var b=g.getDimensions(a.cssPrefix+"footer");a.textComponents.footer.h=b.h,a.textComponents.footer.w=b.w});var b=[];this.textComponents.title.exists&&b.push(this.cssPrefix+"title"),this.textComponents.subtitle.exists&&b.push(this.cssPrefix+"subtitle"),this.textComponents.footer.exists&&b.push(this.cssPrefix+"footer"),g.whenElementsExist(b,function(){if(a.textComponents.title.exists){var b=g.getDimensions(a.cssPrefix+"title");a.textComponents.title.h=b.h,a.textComponents.title.w=b.w}if(a.textComponents.subtitle.exists){var c=g.getDimensions(a.cssPrefix+"subtitle");a.textComponents.subtitle.h=c.h,a.textComponents.subtitle.w=c.w}if(a.textComponents.title.exists||a.textComponents.subtitle.exists){var d=0;a.textComponents.title.exists&&(d+=a.textComponents.title.h,a.textComponents.subtitle.exists&&(d+=a.options.header.titleSubtitlePadding)),a.textComponents.subtitle.exists&&(d+=a.textComponents.subtitle.h),a.textComponents.headerHeight=d}i.computePieRadius(a),i.calculatePieCenter(a),l.positionTitle(a),l.positionSubtitle(a),a.options.misc.gradient.enabled&&k.addGradients(a),k.create(a),j.add(a,"inner",a.options.labels.inner.format),j.add(a,"outer",a.options.labels.outer.format),j.positionLabelElements(a,"inner",a.options.labels.inner.format),j.positionLabelElements(a,"outer",a.options.labels.outer.format),j.computeOuterLabelCoords(a),j.positionLabelGroups(a,"outer"),j.computeLabelLinePositions(a),a.options.labels.lines.enabled&&"none"!==a.options.labels.outer.format&&j.addLabelLines(a),j.positionLabelGroups(a,"inner"),j.fadeInLabelsAndLines(a),a.options.tooltips.enabled&&m.addTooltips(a),k.addSegmentEventHandlers(a)})},q=function(a,b,c){var d=a/b;return 0>=c?Math.round(100*d):(100*d).toFixed(c)};return n});
(function($) {

	$.fn.dataTable.moment = function ( format, locale ) {
		var types = $.fn.dataTableExt.aTypes;

		// Add type detection
		types.unshift( function ( d ) {
			// Null and empty values are acceptable
			if ( d === '' || d === null ) {
				return 'moment-'+format;
			}

			return moment( d.replace ? d.replace(/<.*?>/g, '') : d, format, locale, true ).isValid() ?
			'moment-'+format :
				null;
		} );

		function parseFormatToUnix(value, format, locale) {
			return value === '' || value === null ?
				-Infinity :
				parseInt( moment( value.replace ? value.replace(/<.*?>/g, '') : value, format, locale, true ).format( 'x' ), 10 );
		}

		// Add ascending sorting method
		$.fn.dataTableExt.oSort[ 'moment-'+format+'-asc' ] = function ( x, y ) {

			var parsedX = parseFormatToUnix(x, format, locale);
			var parsedY = parseFormatToUnix(y, format, locale);

			return parsedX - parsedY;
		};

		// Add descending sorting method
		$.fn.dataTableExt.oSort[ 'moment-'+format+'-desc' ] = function ( x, y ) {
			var parsedX = parseFormatToUnix(x, format, locale);
			var parsedY = parseFormatToUnix(y, format, locale);

			return parsedY - parsedX;
		};
	};

}(jQuery));

//https://datatables.net/plug-ins/sorting/datetime-moment
/*!
* Parsley.js
* Version 2.4.4 - built Thu, Aug 4th 2016, 9:54 pm
* http://parsleyjs.org
* Guillaume Potier - <guillaume@wisembly.com>
* Marc-Andre Lafortune - <petroselinum@marc-andre.ca>
* MIT Licensed
*/
function _toConsumableArray(e){if(Array.isArray(e)){for(var t=0,i=Array(e.length);t<e.length;t++)i[t]=e[t];return i}return Array.from(e)}var _slice=Array.prototype.slice;!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],t):e.parsley=t(e.jQuery)}(this,function(e){"use strict";function t(e,t){return e.parsleyAdaptedCallback||(e.parsleyAdaptedCallback=function(){var i=Array.prototype.slice.call(arguments,0);i.unshift(this),e.apply(t||R,i)}),e.parsleyAdaptedCallback}function i(e){return 0===e.lastIndexOf(q,0)?e.substr(q.length):e}/**
   * inputevent - Alleviate browser bugs for input events
   * https://github.com/marcandre/inputevent
   * @version v0.0.3 - (built Thu, Apr 14th 2016, 5:58 pm)
   * @author Marc-Andre Lafortune <github@marc-andre.ca>
   * @license MIT
   */
function n(){var t=this,i=window||global;e.extend(this,{isNativeEvent:function(e){return e.originalEvent&&e.originalEvent.isTrusted!==!1},fakeInputEvent:function(i){t.isNativeEvent(i)&&e(i.target).trigger("input")},misbehaves:function(i){t.isNativeEvent(i)&&(t.behavesOk(i),e(document).on("change.inputevent",i.data.selector,t.fakeInputEvent),t.fakeInputEvent(i))},behavesOk:function(i){t.isNativeEvent(i)&&e(document).off("input.inputevent",i.data.selector,t.behavesOk).off("change.inputevent",i.data.selector,t.misbehaves)},install:function(){if(!i.inputEventPatched){i.inputEventPatched="0.0.3";for(var n=["select",'input[type="checkbox"]','input[type="radio"]','input[type="file"]'],r=0;r<n.length;r++){var s=n[r];e(document).on("input.inputevent",s,{selector:s},t.behavesOk).on("change.inputevent",s,{selector:s},t.misbehaves)}}},uninstall:function(){delete i.inputEventPatched,e(document).off(".inputevent")}})}var r=1,s={},a={attr:function(e,t,i){var n,r,s,a=new RegExp("^"+t,"i");if("undefined"==typeof i)i={};else for(n in i)i.hasOwnProperty(n)&&delete i[n];if("undefined"==typeof e||"undefined"==typeof e[0])return i;for(s=e[0].attributes,n=s.length;n--;)r=s[n],r&&r.specified&&a.test(r.name)&&(i[this.camelize(r.name.slice(t.length))]=this.deserializeValue(r.value));return i},checkAttr:function(e,t,i){return e.is("["+t+i+"]")},setAttr:function(e,t,i,n){e[0].setAttribute(this.dasherize(t+i),String(n))},generateID:function(){return""+r++},deserializeValue:function(t){var i;try{return t?"true"==t||("false"==t?!1:"null"==t?null:isNaN(i=Number(t))?/^[\[\{]/.test(t)?e.parseJSON(t):t:i):t}catch(n){return t}},camelize:function(e){return e.replace(/-+(.)?/g,function(e,t){return t?t.toUpperCase():""})},dasherize:function(e){return e.replace(/::/g,"/").replace(/([A-Z]+)([A-Z][a-z])/g,"$1_$2").replace(/([a-z\d])([A-Z])/g,"$1_$2").replace(/_/g,"-").toLowerCase()},warn:function(){var e;window.console&&"function"==typeof window.console.warn&&(e=window.console).warn.apply(e,arguments)},warnOnce:function(e){s[e]||(s[e]=!0,this.warn.apply(this,arguments))},_resetWarnings:function(){s={}},trimString:function(e){return e.replace(/^\s+|\s+$/g,"")},namespaceEvents:function(t,i){return t=this.trimString(t||"").split(/\s+/),t[0]?e.map(t,function(e){return e+"."+i}).join(" "):""},difference:function(t,i){var n=[];return e.each(t,function(e,t){-1==i.indexOf(t)&&n.push(t)}),n},all:function(t){return e.when.apply(e,_toConsumableArray(t).concat([42,42]))},objectCreate:Object.create||function(){var e=function(){};return function(t){if(arguments.length>1)throw Error("Second argument not supported");if("object"!=typeof t)throw TypeError("Argument must be an object");e.prototype=t;var i=new e;return e.prototype=null,i}}(),_SubmitSelector:'input[type="submit"], button:submit'},o=a,l={namespace:"data-parsley-",inputs:"input, textarea, select",excluded:"input[type=button], input[type=submit], input[type=reset], input[type=hidden]",priorityEnabled:!0,multiple:null,group:null,uiEnabled:!0,validationThreshold:3,focus:"first",trigger:!1,triggerAfterFailure:"input",errorClass:"parsley-error",successClass:"parsley-success",classHandler:function(e){},errorsContainer:function(e){},errorsWrapper:'<ul class="parsley-errors-list"></ul>',errorTemplate:"<li></li>"},u=function(){this.__id__=o.generateID()};u.prototype={asyncSupport:!0,_pipeAccordingToValidationResult:function(){var t=this,i=function(){var i=e.Deferred();return!0!==t.validationResult&&i.reject(),i.resolve().promise()};return[i,i]},actualizeOptions:function(){return o.attr(this.$element,this.options.namespace,this.domOptions),this.parent&&this.parent.actualizeOptions&&this.parent.actualizeOptions(),this},_resetOptions:function(e){this.domOptions=o.objectCreate(this.parent.options),this.options=o.objectCreate(this.domOptions);for(var t in e)e.hasOwnProperty(t)&&(this.options[t]=e[t]);this.actualizeOptions()},_listeners:null,on:function(e,t){this._listeners=this._listeners||{};var i=this._listeners[e]=this._listeners[e]||[];return i.push(t),this},subscribe:function(t,i){e.listenTo(this,t.toLowerCase(),i)},off:function(e,t){var i=this._listeners&&this._listeners[e];if(i)if(t)for(var n=i.length;n--;)i[n]===t&&i.splice(n,1);else delete this._listeners[e];return this},unsubscribe:function(t,i){e.unsubscribeTo(this,t.toLowerCase())},trigger:function(e,t,i){t=t||this;var n,r=this._listeners&&this._listeners[e];if(r)for(var s=r.length;s--;)if(n=r[s].call(t,t,i),n===!1)return n;return this.parent?this.parent.trigger(e,t,i):!0},reset:function(){if("ParsleyForm"!==this.__class__)return this._resetUI(),this._trigger("reset");for(var e=0;e<this.fields.length;e++)this.fields[e].reset();this._trigger("reset")},destroy:function(){if(this._destroyUI(),"ParsleyForm"!==this.__class__)return this.$element.removeData("Parsley"),this.$element.removeData("ParsleyFieldMultiple"),void this._trigger("destroy");for(var e=0;e<this.fields.length;e++)this.fields[e].destroy();this.$element.removeData("Parsley"),this._trigger("destroy")},asyncIsValid:function(e,t){return o.warnOnce("asyncIsValid is deprecated; please use whenValid instead"),this.whenValid({group:e,force:t})},_findRelated:function(){return this.options.multiple?this.parent.$element.find("["+this.options.namespace+'multiple="'+this.options.multiple+'"]'):this.$element}};var d={string:function(e){return e},integer:function(e){if(isNaN(e))throw'Requirement is not an integer: "'+e+'"';return parseInt(e,10)},number:function(e){if(isNaN(e))throw'Requirement is not a number: "'+e+'"';return parseFloat(e)},reference:function(t){var i=e(t);if(0===i.length)throw'No such reference: "'+t+'"';return i},"boolean":function(e){return"false"!==e},object:function(e){return o.deserializeValue(e)},regexp:function(e){var t="";return/^\/.*\/(?:[gimy]*)$/.test(e)?(t=e.replace(/.*\/([gimy]*)$/,"$1"),e=e.replace(new RegExp("^/(.*?)/"+t+"$"),"$1")):e="^"+e+"$",new RegExp(e,t)}},h=function(e,t){var i=e.match(/^\s*\[(.*)\]\s*$/);if(!i)throw'Requirement is not an array: "'+e+'"';var n=i[1].split(",").map(o.trimString);if(n.length!==t)throw"Requirement has "+n.length+" values when "+t+" are needed";return n},p=function(e,t){var i=d[e||"string"];if(!i)throw'Unknown requirement specification: "'+e+'"';return i(t)},c=function(e,t,i){var n=null,r={};for(var s in e)if(s){var a=i(s);"string"==typeof a&&(a=p(e[s],a)),r[s]=a}else n=p(e[s],t);return[n,r]},f=function(t){e.extend(!0,this,t)};f.prototype={validate:function(t,i){if(this.fn)return arguments.length>3&&(i=[].slice.call(arguments,1,-1)),this.fn.call(this,t,i);if(e.isArray(t)){if(!this.validateMultiple)throw"Validator `"+this.name+"` does not handle multiple values";return this.validateMultiple.apply(this,arguments)}if(this.validateNumber)return isNaN(t)?!1:(arguments[0]=parseFloat(arguments[0]),this.validateNumber.apply(this,arguments));if(this.validateString)return this.validateString.apply(this,arguments);throw"Validator `"+this.name+"` only handles multiple values"},parseRequirements:function(t,i){if("string"!=typeof t)return e.isArray(t)?t:[t];var n=this.requirementType;if(e.isArray(n)){for(var r=h(t,n.length),s=0;s<r.length;s++)r[s]=p(n[s],r[s]);return r}return e.isPlainObject(n)?c(n,t,i):[p(n,t)]},requirementType:"string",priority:2};var m=function(e,t){this.__class__="ParsleyValidatorRegistry",this.locale="en",this.init(e||{},t||{})},g={email:/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,number:/^-?(\d*\.)?\d+(e[-+]?\d+)?$/i,integer:/^-?\d+$/,digits:/^\d+$/,alphanum:/^\w+$/i,url:new RegExp("^(?:(?:https?|ftp)://)?(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))(?::\\d{2,5})?(?:/\\S*)?$","i")};g.range=g.number;var v=function(e){var t=(""+e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return t?Math.max(0,(t[1]?t[1].length:0)-(t[2]?+t[2]:0)):0};m.prototype={init:function(t,i){this.catalog=i,this.validators=e.extend({},this.validators);for(var n in t)this.addValidator(n,t[n].fn,t[n].priority);window.Parsley.trigger("parsley:validator:init")},setLocale:function(e){if("undefined"==typeof this.catalog[e])throw new Error(e+" is not available in the catalog");return this.locale=e,this},addCatalog:function(e,t,i){return"object"==typeof t&&(this.catalog[e]=t),!0===i?this.setLocale(e):this},addMessage:function(e,t,i){return"undefined"==typeof this.catalog[e]&&(this.catalog[e]={}),this.catalog[e][t]=i,this},addMessages:function(e,t){for(var i in t)this.addMessage(e,i,t[i]);return this},addValidator:function(e,t,i){if(this.validators[e])o.warn('Validator "'+e+'" is already defined.');else if(l.hasOwnProperty(e))return void o.warn('"'+e+'" is a restricted keyword and is not a valid validator name.');return this._setValidator.apply(this,arguments)},updateValidator:function(e,t,i){return this.validators[e]?this._setValidator.apply(this,arguments):(o.warn('Validator "'+e+'" is not already defined.'),this.addValidator.apply(this,arguments))},removeValidator:function(e){return this.validators[e]||o.warn('Validator "'+e+'" is not defined.'),delete this.validators[e],this},_setValidator:function(e,t,i){"object"!=typeof t&&(t={fn:t,priority:i}),t.validate||(t=new f(t)),this.validators[e]=t;for(var n in t.messages||{})this.addMessage(n,e,t.messages[n]);return this},getErrorMessage:function(e){var t;if("type"===e.name){var i=this.catalog[this.locale][e.name]||{};t=i[e.requirements]}else t=this.formatMessage(this.catalog[this.locale][e.name],e.requirements);return t||this.catalog[this.locale].defaultMessage||this.catalog.en.defaultMessage},formatMessage:function(e,t){if("object"==typeof t){for(var i in t)e=this.formatMessage(e,t[i]);return e}return"string"==typeof e?e.replace(/%s/i,t):""},validators:{notblank:{validateString:function(e){return/\S/.test(e)},priority:2},required:{validateMultiple:function(e){return e.length>0},validateString:function(e){return/\S/.test(e)},priority:512},type:{validateString:function(e,t){var i=arguments.length<=2||void 0===arguments[2]?{}:arguments[2],n=i.step,r=void 0===n?"1":n,s=i.base,a=void 0===s?0:s,o=g[t];if(!o)throw new Error("validator type `"+t+"` is not supported");if(!o.test(e))return!1;if("number"===t&&!/^any$/i.test(r||"")){var l=Number(e),u=Math.max(v(r),v(a));if(v(l)>u)return!1;var d=function(e){return Math.round(e*Math.pow(10,u))};if((d(l)-d(a))%d(r)!=0)return!1}return!0},requirementType:{"":"string",step:"string",base:"number"},priority:256},pattern:{validateString:function(e,t){return t.test(e)},requirementType:"regexp",priority:64},minlength:{validateString:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxlength:{validateString:function(e,t){return e.length<=t},requirementType:"integer",priority:30},length:{validateString:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},mincheck:{validateMultiple:function(e,t){return e.length>=t},requirementType:"integer",priority:30},maxcheck:{validateMultiple:function(e,t){return e.length<=t},requirementType:"integer",priority:30},check:{validateMultiple:function(e,t,i){return e.length>=t&&e.length<=i},requirementType:["integer","integer"],priority:30},min:{validateNumber:function(e,t){return e>=t},requirementType:"number",priority:30},max:{validateNumber:function(e,t){return t>=e},requirementType:"number",priority:30},range:{validateNumber:function(e,t,i){return e>=t&&i>=e},requirementType:["number","number"],priority:30},equalto:{validateString:function(t,i){var n=e(i);return n.length?t===n.val():t===i},priority:256}}};var y={},_=function k(e,t,i){for(var n=[],r=[],s=0;s<e.length;s++){for(var a=!1,o=0;o<t.length;o++)if(e[s].assert.name===t[o].assert.name){a=!0;break}a?r.push(e[s]):n.push(e[s])}return{kept:r,added:n,removed:i?[]:k(t,e,!0).added}};y.Form={_actualizeTriggers:function(){var e=this;this.$element.on("submit.Parsley",function(t){e.onSubmitValidate(t)}),this.$element.on("click.Parsley",o._SubmitSelector,function(t){e.onSubmitButton(t)}),!1!==this.options.uiEnabled&&this.$element.attr("novalidate","")},focus:function(){if(this._focusedField=null,!0===this.validationResult||"none"===this.options.focus)return null;for(var e=0;e<this.fields.length;e++){var t=this.fields[e];if(!0!==t.validationResult&&t.validationResult.length>0&&"undefined"==typeof t.options.noFocus&&(this._focusedField=t.$element,"first"===this.options.focus))break}return null===this._focusedField?null:this._focusedField.focus()},_destroyUI:function(){this.$element.off(".Parsley")}},y.Field={_reflowUI:function(){if(this._buildUI(),this._ui){var e=_(this.validationResult,this._ui.lastValidationResult);this._ui.lastValidationResult=this.validationResult,this._manageStatusClass(),this._manageErrorsMessages(e),this._actualizeTriggers(),!e.kept.length&&!e.added.length||this._failedOnce||(this._failedOnce=!0,this._actualizeTriggers())}},getErrorsMessages:function(){if(!0===this.validationResult)return[];for(var e=[],t=0;t<this.validationResult.length;t++)e.push(this.validationResult[t].errorMessage||this._getErrorMessage(this.validationResult[t].assert));return e},addError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._addError(e,{message:i,assert:n}),s&&this._errorClass()},updateError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.message,n=t.assert,r=t.updateClass,s=void 0===r?!0:r;this._buildUI(),this._updateError(e,{message:i,assert:n}),s&&this._errorClass()},removeError:function(e){var t=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],i=t.updateClass,n=void 0===i?!0:i;this._buildUI(),this._removeError(e),n&&this._manageStatusClass()},_manageStatusClass:function(){this.hasConstraints()&&this.needsValidation()&&!0===this.validationResult?this._successClass():this.validationResult.length>0?this._errorClass():this._resetClass()},_manageErrorsMessages:function(t){if("undefined"==typeof this.options.errorsMessagesDisabled){if("undefined"!=typeof this.options.errorMessage)return t.added.length||t.kept.length?(this._insertErrorWrapper(),0===this._ui.$errorsWrapper.find(".parsley-custom-error-message").length&&this._ui.$errorsWrapper.append(e(this.options.errorTemplate).addClass("parsley-custom-error-message")),this._ui.$errorsWrapper.addClass("filled").find(".parsley-custom-error-message").html(this.options.errorMessage)):this._ui.$errorsWrapper.removeClass("filled").find(".parsley-custom-error-message").remove();for(var i=0;i<t.removed.length;i++)this._removeError(t.removed[i].assert.name);for(i=0;i<t.added.length;i++)this._addError(t.added[i].assert.name,{message:t.added[i].errorMessage,assert:t.added[i].assert});for(i=0;i<t.kept.length;i++)this._updateError(t.kept[i].assert.name,{message:t.kept[i].errorMessage,assert:t.kept[i].assert})}},_addError:function(t,i){var n=i.message,r=i.assert;this._insertErrorWrapper(),this._ui.$errorsWrapper.addClass("filled").append(e(this.options.errorTemplate).addClass("parsley-"+t).html(n||this._getErrorMessage(r)))},_updateError:function(e,t){var i=t.message,n=t.assert;this._ui.$errorsWrapper.addClass("filled").find(".parsley-"+e).html(i||this._getErrorMessage(n))},_removeError:function(e){this._ui.$errorsWrapper.removeClass("filled").find(".parsley-"+e).remove()},_getErrorMessage:function(e){var t=e.name+"Message";return"undefined"!=typeof this.options[t]?window.Parsley.formatMessage(this.options[t],e.requirements):window.Parsley.getErrorMessage(e)},_buildUI:function(){if(!this._ui&&!1!==this.options.uiEnabled){var t={};this.$element.attr(this.options.namespace+"id",this.__id__),t.$errorClassHandler=this._manageClassHandler(),t.errorsWrapperId="parsley-id-"+(this.options.multiple?"multiple-"+this.options.multiple:this.__id__),t.$errorsWrapper=e(this.options.errorsWrapper).attr("id",t.errorsWrapperId),t.lastValidationResult=[],t.validationInformationVisible=!1,this._ui=t}},_manageClassHandler:function(){if("string"==typeof this.options.classHandler&&e(this.options.classHandler).length)return e(this.options.classHandler);var t=this.options.classHandler.call(this,this);return"undefined"!=typeof t&&t.length?t:this._inputHolder()},_inputHolder:function(){return!this.options.multiple||this.$element.is("select")?this.$element:this.$element.parent()},_insertErrorWrapper:function(){var t;if(0!==this._ui.$errorsWrapper.parent().length)return this._ui.$errorsWrapper.parent();if("string"==typeof this.options.errorsContainer){if(e(this.options.errorsContainer).length)return e(this.options.errorsContainer).append(this._ui.$errorsWrapper);o.warn("The errors container `"+this.options.errorsContainer+"` does not exist in DOM")}else"function"==typeof this.options.errorsContainer&&(t=this.options.errorsContainer.call(this,this));return"undefined"!=typeof t&&t.length?t.append(this._ui.$errorsWrapper):this._inputHolder().after(this._ui.$errorsWrapper)},_actualizeTriggers:function(){var e,t=this,i=this._findRelated();i.off(".Parsley"),this._failedOnce?i.on(o.namespaceEvents(this.options.triggerAfterFailure,"Parsley"),function(){t.validate()}):(e=o.namespaceEvents(this.options.trigger,"Parsley"))&&i.on(e,function(e){t._eventValidate(e)})},_eventValidate:function(e){!(!/key|input/.test(e.type)||this._ui&&this._ui.validationInformationVisible)&&this.getValue().length<=this.options.validationThreshold||this.validate()},_resetUI:function(){this._failedOnce=!1,this._actualizeTriggers(),"undefined"!=typeof this._ui&&(this._ui.$errorsWrapper.removeClass("filled").children().remove(),this._resetClass(),this._ui.lastValidationResult=[],this._ui.validationInformationVisible=!1)},_destroyUI:function(){this._resetUI(),"undefined"!=typeof this._ui&&this._ui.$errorsWrapper.remove(),delete this._ui},_successClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.errorClass).addClass(this.options.successClass)},_errorClass:function(){this._ui.validationInformationVisible=!0,this._ui.$errorClassHandler.removeClass(this.options.successClass).addClass(this.options.errorClass)},_resetClass:function(){this._ui.$errorClassHandler.removeClass(this.options.successClass).removeClass(this.options.errorClass)}};var w=function(t,i,n){this.__class__="ParsleyForm",this.$element=e(t),this.domOptions=i,this.options=n,this.parent=window.Parsley,this.fields=[],this.validationResult=null},b={pending:null,resolved:!0,rejected:!1};w.prototype={onSubmitValidate:function(e){var t=this;if(!0!==e.parsley){var i=this._$submitSource||this.$element.find(o._SubmitSelector).first();if(this._$submitSource=null,this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!0),!i.is("[formnovalidate]")){var n=this.whenValidate({event:e});"resolved"===n.state()&&!1!==this._trigger("submit")||(e.stopImmediatePropagation(),e.preventDefault(),"pending"===n.state()&&n.done(function(){t._submit(i)}))}}},onSubmitButton:function(t){this._$submitSource=e(t.currentTarget)},_submit:function(t){if(!1!==this._trigger("submit")){if(t){var i=this.$element.find(".parsley-synthetic-submit-button").prop("disabled",!1);0===i.length&&(i=e('<input class="parsley-synthetic-submit-button" type="hidden">').appendTo(this.$element)),i.attr({name:t.attr("name"),value:t.attr("value")})}this.$element.trigger(e.extend(e.Event("submit"),{parsley:!0}))}},validate:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling validate on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1],s=i[2];t={group:n,force:r,event:s}}return b[this.whenValidate(t).state()]},whenValidate:function(){var t,i=this,n=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],r=n.group,s=n.force,a=n.event;this.submitEvent=a,a&&(this.submitEvent=e.extend({},a,{preventDefault:function(){o.warnOnce("Using `this.submitEvent.preventDefault()` is deprecated; instead, call `this.validationResult = false`"),i.validationResult=!1}})),this.validationResult=!0,this._trigger("validate"),this._refreshFields();var l=this._withoutReactualizingFormOptions(function(){return e.map(i.fields,function(e){return e.whenValidate({force:s,group:r})})});return(t=o.all(l).done(function(){i._trigger("success")}).fail(function(){i.validationResult=!1,i.focus(),i._trigger("error")}).always(function(){i._trigger("validated")})).pipe.apply(t,_toConsumableArray(this._pipeAccordingToValidationResult()))},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling isValid on a parsley form without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={group:n,force:r}}return b[this.whenValid(t).state()]},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.group,r=i.force;this._refreshFields();var s=this._withoutReactualizingFormOptions(function(){return e.map(t.fields,function(e){return e.whenValid({group:n,force:r})})});return o.all(s)},_refreshFields:function(){return this.actualizeOptions()._bindFields()},_bindFields:function(){var t=this,i=this.fields;return this.fields=[],this.fieldsMappedById={},this._withoutReactualizingFormOptions(function(){t.$element.find(t.options.inputs).not(t.options.excluded).each(function(e,i){var n=new window.Parsley.Factory(i,{},t);"ParsleyField"!==n.__class__&&"ParsleyFieldMultiple"!==n.__class__||!0===n.options.excluded||"undefined"==typeof t.fieldsMappedById[n.__class__+"-"+n.__id__]&&(t.fieldsMappedById[n.__class__+"-"+n.__id__]=n,t.fields.push(n))}),e.each(o.difference(i,t.fields),function(e,t){t._trigger("reset")})}),this},_withoutReactualizingFormOptions:function(e){var t=this.actualizeOptions;this.actualizeOptions=function(){return this};var i=e();return this.actualizeOptions=t,i},_trigger:function(e){return this.trigger("form:"+e)}};var F=function(t,i,n,r,s){if(!/ParsleyField/.test(t.__class__))throw new Error("ParsleyField or ParsleyFieldMultiple instance expected");var a=window.Parsley._validatorRegistry.validators[i],o=new f(a);e.extend(this,{validator:o,name:i,requirements:n,priority:r||t.options[i+"Priority"]||o.priority,isDomConstraint:!0===s}),this._parseRequirements(t.options)},C=function(e){var t=e[0].toUpperCase();return t+e.slice(1)};F.prototype={validate:function(e,t){var i;return(i=this.validator).validate.apply(i,[e].concat(_toConsumableArray(this.requirementList),[t]))},_parseRequirements:function(e){var t=this;this.requirementList=this.validator.parseRequirements(this.requirements,function(i){return e[t.name+C(i)]})}};var $=function(t,i,n,r){this.__class__="ParsleyField",this.$element=e(t),"undefined"!=typeof r&&(this.parent=r),this.options=n,this.domOptions=i,this.constraints=[],this.constraintsByName={},this.validationResult=!0,this._bindConstraints()},x={pending:null,resolved:!0,rejected:!1};$.prototype={validate:function(t){arguments.length>=1&&!e.isPlainObject(t)&&(o.warnOnce("Calling validate on a parsley field without passing arguments as an object is deprecated."),t={options:t});var i=this.whenValidate(t);if(!i)return!0;switch(i.state()){case"pending":return null;case"resolved":return!0;case"rejected":return this.validationResult}},whenValidate:function(){var e,t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.force,r=i.group;return this.refreshConstraints(),!r||this._isInGroup(r)?(this.value=this.getValue(),this._trigger("validate"),(e=this.whenValid({force:n,value:this.value,_refreshed:!0}).always(function(){t._reflowUI()}).done(function(){t._trigger("success")}).fail(function(){t._trigger("error")}).always(function(){t._trigger("validated")})).pipe.apply(e,_toConsumableArray(this._pipeAccordingToValidationResult()))):void 0},hasConstraints:function(){return 0!==this.constraints.length},needsValidation:function(e){return"undefined"==typeof e&&(e=this.getValue()),!(!e.length&&!this._isRequired()&&"undefined"==typeof this.options.validateIfEmpty)},_isInGroup:function(t){return e.isArray(this.options.group)?-1!==e.inArray(t,this.options.group):this.options.group===t},isValid:function(t){if(arguments.length>=1&&!e.isPlainObject(t)){o.warnOnce("Calling isValid on a parsley field without passing arguments as an object is deprecated.");var i=_slice.call(arguments),n=i[0],r=i[1];t={force:n,value:r}}var s=this.whenValid(t);return s?x[s.state()]:!0},whenValid:function(){var t=this,i=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],n=i.force,r=void 0===n?!1:n,s=i.value,a=i.group,l=i._refreshed;if(l||this.refreshConstraints(),!a||this._isInGroup(a)){if(this.validationResult=!0,!this.hasConstraints())return e.when();if("undefined"!=typeof s&&null!==s||(s=this.getValue()),!this.needsValidation(s)&&!0!==r)return e.when();var u=this._getGroupedConstraints(),d=[];return e.each(u,function(i,n){var r=o.all(e.map(n,function(e){return t._validateConstraint(s,e)}));return d.push(r),"rejected"===r.state()?!1:void 0}),o.all(d)}},_validateConstraint:function(t,i){var n=this,r=i.validate(t,this);return!1===r&&(r=e.Deferred().reject()),o.all([r]).fail(function(e){n.validationResult instanceof Array||(n.validationResult=[]),n.validationResult.push({assert:i,errorMessage:"string"==typeof e&&e})})},getValue:function(){var e;return e="function"==typeof this.options.value?this.options.value(this):"undefined"!=typeof this.options.value?this.options.value:this.$element.val(),"undefined"==typeof e||null===e?"":this._handleWhitespace(e)},refreshConstraints:function(){return this.actualizeOptions()._bindConstraints()},addConstraint:function(e,t,i,n){if(window.Parsley._validatorRegistry.validators[e]){var r=new F(this,e,t,i,n);"undefined"!==this.constraintsByName[r.name]&&this.removeConstraint(r.name),this.constraints.push(r),this.constraintsByName[r.name]=r}return this},removeConstraint:function(e){for(var t=0;t<this.constraints.length;t++)if(e===this.constraints[t].name){this.constraints.splice(t,1);break}return delete this.constraintsByName[e],this},updateConstraint:function(e,t,i){return this.removeConstraint(e).addConstraint(e,t,i)},_bindConstraints:function(){for(var e=[],t={},i=0;i<this.constraints.length;i++)!1===this.constraints[i].isDomConstraint&&(e.push(this.constraints[i]),t[this.constraints[i].name]=this.constraints[i]);this.constraints=e,this.constraintsByName=t;for(var n in this.options)this.addConstraint(n,this.options[n],void 0,!0);return this._bindHtml5Constraints()},_bindHtml5Constraints:function(){(this.$element.hasClass("required")||this.$element.attr("required"))&&this.addConstraint("required",!0,void 0,!0),"string"==typeof this.$element.attr("pattern")&&this.addConstraint("pattern",this.$element.attr("pattern"),void 0,!0),"undefined"!=typeof this.$element.attr("min")&&"undefined"!=typeof this.$element.attr("max")?this.addConstraint("range",[this.$element.attr("min"),this.$element.attr("max")],void 0,!0):"undefined"!=typeof this.$element.attr("min")?this.addConstraint("min",this.$element.attr("min"),void 0,!0):"undefined"!=typeof this.$element.attr("max")&&this.addConstraint("max",this.$element.attr("max"),void 0,!0),"undefined"!=typeof this.$element.attr("minlength")&&"undefined"!=typeof this.$element.attr("maxlength")?this.addConstraint("length",[this.$element.attr("minlength"),this.$element.attr("maxlength")],void 0,!0):"undefined"!=typeof this.$element.attr("minlength")?this.addConstraint("minlength",this.$element.attr("minlength"),void 0,!0):"undefined"!=typeof this.$element.attr("maxlength")&&this.addConstraint("maxlength",this.$element.attr("maxlength"),void 0,!0);var e=this.$element.attr("type");return"undefined"==typeof e?this:"number"===e?this.addConstraint("type",["number",{step:this.$element.attr("step"),base:this.$element.attr("min")||this.$element.attr("value")}],void 0,!0):/^(email|url|range)$/i.test(e)?this.addConstraint("type",e,void 0,!0):this},_isRequired:function(){return"undefined"==typeof this.constraintsByName.required?!1:!1!==this.constraintsByName.required.requirements},_trigger:function(e){return this.trigger("field:"+e)},_handleWhitespace:function(e){return!0===this.options.trimValue&&o.warnOnce('data-parsley-trim-value="true" is deprecated, please use data-parsley-whitespace="trim"'),"squish"===this.options.whitespace&&(e=e.replace(/\s{2,}/g," ")),"trim"!==this.options.whitespace&&"squish"!==this.options.whitespace&&!0!==this.options.trimValue||(e=o.trimString(e)),e},_getGroupedConstraints:function(){if(!1===this.options.priorityEnabled)return[this.constraints];for(var e=[],t={},i=0;i<this.constraints.length;i++){var n=this.constraints[i].priority;t[n]||e.push(t[n]=[]),t[n].push(this.constraints[i])}return e.sort(function(e,t){return t[0].priority-e[0].priority}),e}};var E=$,P=function(){this.__class__="ParsleyFieldMultiple"};P.prototype={addElement:function(e){return this.$elements.push(e),this},refreshConstraints:function(){var t;if(this.constraints=[],this.$element.is("select"))return this.actualizeOptions()._bindConstraints(),this;for(var i=0;i<this.$elements.length;i++)if(e("html").has(this.$elements[i]).length){t=this.$elements[i].data("ParsleyFieldMultiple").refreshConstraints().constraints;for(var n=0;n<t.length;n++)this.addConstraint(t[n].name,t[n].requirements,t[n].priority,t[n].isDomConstraint)}else this.$elements.splice(i,1);return this},getValue:function(){if("function"==typeof this.options.value)return this.options.value(this);if("undefined"!=typeof this.options.value)return this.options.value;if(this.$element.is("input[type=radio]"))return this._findRelated().filter(":checked").val()||"";if(this.$element.is("input[type=checkbox]")){var t=[];return this._findRelated().filter(":checked").each(function(){t.push(e(this).val())}),t}return this.$element.is("select")&&null===this.$element.val()?[]:this.$element.val()},_init:function(){return this.$elements=[this.$element],this}};var V=function(t,i,n){this.$element=e(t);var r=this.$element.data("Parsley");if(r)return"undefined"!=typeof n&&r.parent===window.Parsley&&(r.parent=n,r._resetOptions(r.options)),"object"==typeof i&&e.extend(r.options,i),r;if(!this.$element.length)throw new Error("You must bind Parsley on an existing element.");if("undefined"!=typeof n&&"ParsleyForm"!==n.__class__)throw new Error("Parent instance must be a ParsleyForm instance");return this.parent=n||window.Parsley,this.init(i)};V.prototype={init:function(e){return this.__class__="Parsley",this.__version__="2.4.4",this.__id__=o.generateID(),this._resetOptions(e),this.$element.is("form")||o.checkAttr(this.$element,this.options.namespace,"validate")&&!this.$element.is(this.options.inputs)?this.bind("parsleyForm"):this.isMultiple()?this.handleMultiple():this.bind("parsleyField")},isMultiple:function(){return this.$element.is("input[type=radio], input[type=checkbox]")||this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple")},handleMultiple:function(){var t,i,n=this;if(this.options.multiple||("undefined"!=typeof this.$element.attr("name")&&this.$element.attr("name").length?this.options.multiple=t=this.$element.attr("name"):"undefined"!=typeof this.$element.attr("id")&&this.$element.attr("id").length&&(this.options.multiple=this.$element.attr("id"))),
this.$element.is("select")&&"undefined"!=typeof this.$element.attr("multiple"))return this.options.multiple=this.options.multiple||this.__id__,this.bind("parsleyFieldMultiple");if(!this.options.multiple)return o.warn("To be bound by Parsley, a radio, a checkbox and a multiple select input must have either a name or a multiple option.",this.$element),this;this.options.multiple=this.options.multiple.replace(/(:|\.|\[|\]|\{|\}|\$)/g,""),"undefined"!=typeof t&&e('input[name="'+t+'"]').each(function(t,i){e(i).is("input[type=radio], input[type=checkbox]")&&e(i).attr(n.options.namespace+"multiple",n.options.multiple)});for(var r=this._findRelated(),s=0;s<r.length;s++)if(i=e(r.get(s)).data("Parsley"),"undefined"!=typeof i){this.$element.data("ParsleyFieldMultiple")||i.addElement(this.$element);break}return this.bind("parsleyField",!0),i||this.bind("parsleyFieldMultiple")},bind:function(t,i){var n;switch(t){case"parsleyForm":n=e.extend(new w(this.$element,this.domOptions,this.options),new u,window.ParsleyExtend)._bindFields();break;case"parsleyField":n=e.extend(new E(this.$element,this.domOptions,this.options,this.parent),new u,window.ParsleyExtend);break;case"parsleyFieldMultiple":n=e.extend(new E(this.$element,this.domOptions,this.options,this.parent),new P,new u,window.ParsleyExtend)._init();break;default:throw new Error(t+"is not a supported Parsley type")}return this.options.multiple&&o.setAttr(this.$element,this.options.namespace,"multiple",this.options.multiple),"undefined"!=typeof i?(this.$element.data("ParsleyFieldMultiple",n),n):(this.$element.data("Parsley",n),n._actualizeTriggers(),n._trigger("init"),n)}};var M=e.fn.jquery.split(".");if(parseInt(M[0])<=1&&parseInt(M[1])<8)throw"The loaded version of jQuery is too old. Please upgrade to 1.8.x or better.";M.forEach||o.warn("Parsley requires ES5 to run properly. Please include https://github.com/es-shims/es5-shim");var O=e.extend(new u,{$element:e(document),actualizeOptions:null,_resetOptions:null,Factory:V,version:"2.4.4"});e.extend(E.prototype,y.Field,u.prototype),e.extend(w.prototype,y.Form,u.prototype),e.extend(V.prototype,u.prototype),e.fn.parsley=e.fn.psly=function(t){if(this.length>1){var i=[];return this.each(function(){i.push(e(this).parsley(t))}),i}return e(this).length?new V(this,t):void o.warn("You must bind Parsley on an existing element.")},"undefined"==typeof window.ParsleyExtend&&(window.ParsleyExtend={}),O.options=e.extend(o.objectCreate(l),window.ParsleyConfig),window.ParsleyConfig=O.options,window.Parsley=window.psly=O,window.ParsleyUtils=o;var A=window.Parsley._validatorRegistry=new m(window.ParsleyConfig.validators,window.ParsleyConfig.i18n);window.ParsleyValidator={},e.each("setLocale addCatalog addMessage addMessages getErrorMessage formatMessage addValidator updateValidator removeValidator".split(" "),function(t,i){window.Parsley[i]=e.proxy(A,i),window.ParsleyValidator[i]=function(){var e;return o.warnOnce("Accessing the method '"+i+"' through ParsleyValidator is deprecated. Simply call 'window.Parsley."+i+"(...)'"),(e=window.Parsley)[i].apply(e,arguments)}}),window.Parsley.UI=y,window.ParsleyUI={removeError:function(e,t,i){var n=!0!==i;return o.warnOnce("Accessing ParsleyUI is deprecated. Call 'removeError' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e.removeError(t,{updateClass:n})},getErrorsMessages:function(e){return o.warnOnce("Accessing ParsleyUI is deprecated. Call 'getErrorsMessages' on the instance directly."),e.getErrorsMessages()}},e.each("addError updateError".split(" "),function(e,t){window.ParsleyUI[t]=function(e,i,n,r,s){var a=!0!==s;return o.warnOnce("Accessing ParsleyUI is deprecated. Call '"+t+"' on the instance directly. Please comment in issue 1073 as to your need to call this method."),e[t](i,{message:n,assert:r,updateClass:a})}}),!1!==window.ParsleyConfig.autoBind&&e(function(){e("[data-parsley-validate]").length&&e("[data-parsley-validate]").parsley()});var R=e({}),T=function(){o.warnOnce("Parsley's pubsub module is deprecated; use the 'on' and 'off' methods on parsley instances or window.Parsley")},q="parsley:";e.listen=function(e,n){var r;if(T(),"object"==typeof arguments[1]&&"function"==typeof arguments[2]&&(r=arguments[1],n=arguments[2]),"function"!=typeof n)throw new Error("Wrong parameters");window.Parsley.on(i(e),t(n,r))},e.listenTo=function(e,n,r){if(T(),!(e instanceof E||e instanceof w))throw new Error("Must give Parsley instance");if("string"!=typeof n||"function"!=typeof r)throw new Error("Wrong parameters");e.on(i(n),t(r))},e.unsubscribe=function(e,t){if(T(),"string"!=typeof e||"function"!=typeof t)throw new Error("Wrong arguments");window.Parsley.off(i(e),t.parsleyAdaptedCallback)},e.unsubscribeTo=function(e,t){if(T(),!(e instanceof E||e instanceof w))throw new Error("Must give Parsley instance");e.off(i(t))},e.unsubscribeAll=function(t){T(),window.Parsley.off(i(t)),e("form,input,textarea,select").each(function(){var n=e(this).data("Parsley");n&&n.off(i(t))})},e.emit=function(e,t){var n;T();var r=t instanceof E||t instanceof w,s=Array.prototype.slice.call(arguments,r?2:1);s.unshift(i(e)),r||(t=window.Parsley),(n=t).trigger.apply(n,_toConsumableArray(s))};e.extend(!0,O,{asyncValidators:{"default":{fn:function(e){return e.status>=200&&e.status<300},url:!1},reverse:{fn:function(e){return e.status<200||e.status>=300},url:!1}},addAsyncValidator:function(e,t,i,n){return O.asyncValidators[e]={fn:t,url:i||!1,options:n||{}},this}}),O.addValidator("remote",{requirementType:{"":"string",validator:"string",reverse:"boolean",options:"object"},validateString:function(t,i,n,r){var s,a,o={},l=n.validator||(!0===n.reverse?"reverse":"default");if("undefined"==typeof O.asyncValidators[l])throw new Error("Calling an undefined async validator: `"+l+"`");i=O.asyncValidators[l].url||i,i.indexOf("{value}")>-1?i=i.replace("{value}",encodeURIComponent(t)):o[r.$element.attr("name")||r.$element.attr("id")]=t;var u=e.extend(!0,n.options||{},O.asyncValidators[l].options);s=e.extend(!0,{},{url:i,data:o,type:"GET"},u),r.trigger("field:ajaxoptions",r,s),a=e.param(s),"undefined"==typeof O._remoteCache&&(O._remoteCache={});var d=O._remoteCache[a]=O._remoteCache[a]||e.ajax(s),h=function(){var t=O.asyncValidators[l].fn.call(r,d,i,n);return t||(t=e.Deferred().reject()),e.when(t)};return d.then(h,h)},priority:-1}),O.on("form:submit",function(){O._remoteCache={}}),window.ParsleyExtend.addAsyncValidator=function(){return ParsleyUtils.warnOnce("Accessing the method `addAsyncValidator` through an instance is deprecated. Simply call `Parsley.addAsyncValidator(...)`"),O.addAsyncValidator.apply(O,arguments)},O.addMessages("en",{defaultMessage:"This value seems to be invalid.",type:{email:"This value should be a valid email.",url:"This value should be a valid url.",number:"This value should be a valid number.",integer:"This value should be a valid integer.",digits:"This value should be digits.",alphanum:"This value should be alphanumeric."},notblank:"This value should not be blank.",required:"This value is required.",pattern:"This value seems to be invalid.",min:"This value should be greater than or equal to %s.",max:"This value should be lower than or equal to %s.",range:"This value should be between %s and %s.",minlength:"This value is too short. It should have %s characters or more.",maxlength:"This value is too long. It should have %s characters or fewer.",length:"This value length is invalid. It should be between %s and %s characters long.",mincheck:"You must select at least %s choices.",maxcheck:"You must select %s choices or fewer.",check:"You must select between %s and %s choices.",equalto:"This value should be the same."}),O.setLocale("en");var D=new n;D.install();var I=O;return I});
//# sourceMappingURL=parsley.min.js.map
