<?php
header('Content-type: text/javascript');
?>
(function() {
	var height = $(window).height();

	setInterval(function() {
		if ($(window).height() !== height) {
			height = $(window).height();
			$(window).trigger('resolutionchange');
		}
	}, 50);
}());

function set_map_canvas_size() {
	var viewpport = $(window).height();
	var position = $('#map_canvas').offset();
	var new_height = viewpport - position.top;
	$('#map_canvas').height(new_height);
}

function handleGetCurrentPosition(location) {

	$("#map_canvas").gmap3({
		map : {
			options : {
				center : [ location.coords.latitude, location.coords.longitude ],
				zoom : 16,
				mapTypeId : google.maps.MapTypeId.ROADMAP,
				mapTypeControl : true,
				mapTypeControlOptions : {
					style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
				},
				navigationControl : true,
				scrollwheel : true,
				streetViewControl : true
			},
			events:{
				click: function(sender,event){
					console.log(event.latLng);
				}
			},
			
		},
		marker:{
		    values:[
		      {id:'center', latLng:[location.coords.latitude, location.coords.longitude], data:"Your Location"},
		    ],
		    options:{
		      draggable: false,
		      animation: google.maps.Animation.DROP
		    },
		    events:{ // events trigged by markers 
		        click: function(){
		          alert("Here is the default click event");
		        }
		      },
		}
		
	});

}

function handleGetCurrentPositionError(e) {
	console.log(e);
}