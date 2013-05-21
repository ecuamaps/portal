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
					//if(confirm())
					console.log(event.latLng);
				}
			},
			
		},
		marker:{
		    values:[
		      {id:'center', latLng:[location.coords.latitude, location.coords.longitude], data:"Your Location"},
		    ],
		    options:{
		      draggable: true,
		      animation: google.maps.Animation.DROP
		    },
		    events:{ // events trigged by markers 
		    	dragend: function(e){
		    		console.log(e.latLng);
		    	},
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

$(document).ready(function() {

	set_map_canvas_size();

	$(window).bind('resolutionchange', set_map_canvas_size)

	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(handleGetCurrentPosition,handleGetCurrentPositionError);
	
	$('#adv-search').click(function(e){
		e.preventDefault();

		if($('#adv-search-block').is(':visible')) { //Lo quieren ocultar
			$('#visible-advsearch').hide();
			$('#hiden-advsearch').show();
			$('#adv-search-block').slideUp("slow");
		}else{ //Lo quieren mostrar
			$('#hiden-advsearch').hide();
			$('#visible-advsearch').show();
			$('#adv-search-block').slideDown("slow");
		}
		//
		
		//hiden-advsearch
		//visible-advsearch
	})
	
});