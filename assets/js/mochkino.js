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

	$("#map_canvas")
			.gmap3(
					{
						map : {
							options : {
								center : [ location.coords.latitude,
										location.coords.longitude ],
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
							events : {
								click : function(sender, event) {
									// if(confirm())
									console.log(event.latLng);
								}
							},

						},
						marker : {
							values : [
									{
										id : 'center',
										latLng : [ location.coords.latitude, location.coords.longitude ],
										data : "Your Location"
									}, ],
							options : {
								draggable : true,
								animation : google.maps.Animation.DROP
							},
							events : { // events trigged by markers
								dragend : function(e) {
									console.log(e.latLng);
								},
								click : function() {
									alert("Here is the default click event");
								}
							},
						}

					});

}

function handleGetCurrentPositionError(e) {
	console.log(e);
}

function get_tyes_html_row(data){
	console.log(data);
	var html = '<div class="row">';
	for(var x=0; x<data.length;x++){
		html = html + '<div class="small-2 columns">'+
			'<label class="text-color-white" for="type_' + data[x].id + '"><input class="bz-type" type="checkbox" name="type_' + data[x].id + '" id="type_' + data[x].id + '">' + data[x].name + '</label>'+
		'</div>';
	}
	
	var diff = 6 - data.length;
	if(diff > 0){
		for(var x=0; x<diff;x++){
			html = html + '<div class="small-2 columns">&nbsp;</div>';
		}
	}
	
	html = html + '</div>';
	return html;
}

$(document).ready(
		function() {

			set_map_canvas_size();

			$(window).bind('resolutionchange', set_map_canvas_size)

			if (navigator.geolocation)
				navigator.geolocation
						.getCurrentPosition(handleGetCurrentPosition,
								handleGetCurrentPositionError);

			$('#adv-search').click(function(e) {
				e.preventDefault();

				if ($('#adv-search-block').is(':visible')) { // Lo quieren
					// ocultar
					$('#visible-advsearch').hide();
					$('#hiden-advsearch').show();
					$('#adv-search-block').slideUp("slow");
				} else { // Lo quieren mostrar
					$('#hiden-advsearch').hide();
					$('#visible-advsearch').show();
					$('#adv-search-block').slideDown("slow");
				}
			});

			$('#view-all-types').click(function(e) {
				e.preventDefault();

				$.ajax({
					type : "GET",
					url : "en/dashboard/ajax_get_all_types",
					dataType: "json",
					cache: true,
					data : {}
				}).done(function(response) {
					if(response.length){
						var c = 1;
						var data = new Array();
						var html = '';
						for(var x=0; x<response.length; x++){
							if(c <= 6){
								data.push(response[x]);
								c++;
							}else{
								c = 1;
								html = html + get_tyes_html_row(data);
								data = new Array();
							}
						}
						
						if(data.length){
							html = html + get_tyes_html_row(data);
						}
						
						$('#extra-types').append(html);
						$('#extra-types').show("slow");
					}
				});

			})

		});