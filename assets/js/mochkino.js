
function mapInitialize(location) {
	
	var myLatlng = new google.maps.LatLng(location.coords.latitude,
			location.coords.longitude);

	var styles = [ {
		"featureType" : "poi.business",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.attraction",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.government",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.medical",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.park",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.place_of_worship",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.school",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	}, {
		"featureType" : "poi.sports_complex",
		"stylers" : [ {
			"visibility" : "off"
		} ]
	} ];

	var mapOptions = {
		zoom : 17,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		mapTypeControl : true,
		mapTypeControlOptions : {
			position : google.maps.ControlPosition.RIGHT_CENTER
		},
		panControl : false,
		scrollwheel : true,
		navigationControl : true,
		streetViewControl : false,
		zoomControlOptions : {
			style : google.maps.ZoomControlStyle.SMALL,
			position : google.maps.ControlPosition.RIGHT_CENTER
		},
		styles : styles
	};

	map = new google.maps.Map(document.getElementById('map_canvas'),
			mapOptions);

	myLocation = new google.maps.Marker({
		position : myLatlng,
		map : map,
		title : currentPosLbl,
		icon : 'assets/images/myLocation.png',
		draggable : true,
	});
	
	if(location.coords.accuracy < 200){
	    var myLocationAccuracy = new google.maps.Circle({
	        map: map,
	        radius: location.coords.accuracy,
	        fillColor: "#5882FA",
	        strokeColor: "#2E2EFE",
	        strokeWeight: 1
	        
	        
	        });
	    
	    myLocationAccuracy.bindTo('center', myLocation, 'position');		
	}else{
		alert(accuracyErrorMsg);
	}

}

function errorHandler(err) {
	  if(err.code == 1) {
	    alert("Error: Access is denied!");
	  }else if( err.code == 2) {
	    alert("Error: Position is unavailable!");
	  }
}

function get_tyes_html_row(data) {
	var html = '<div class="row">';
	for ( var x = 0; x < data.length; x++) {
		html = html + '<div class="small-2 columns">'
				+ '<label class="text-color-white" for="type_' + data[x].id
				+ '"><input class="bz-type" type="checkbox" name="type_'
				+ data[x].id + '" id="type_' + data[x].id + '" value="' + data[x].id + '">' + data[x].name
				+ '</label>' + '</div>';
	}

	var diff = 6 - data.length;
	if (diff > 0) {
		for ( var x = 0; x < diff; x++) {
			html = html + '<div class="small-2 columns">&nbsp;</div>';
		}
	}

	html = html + '</div>';
	return html;
}

function pullUpWrapper() {
	$('#wrapper').css('margin-bottom', '-11em');
}
function pullDownWrapper() {
	$('#wrapper').css('margin-bottom', '-4em');
}

$(document).ready(function() {

	navigator.geolocation.getCurrentPosition(mapInitialize, errorHandler);

	$('#adv-search').click(function(e) {
		e.preventDefault();

		if ($('#adv-search-block').is(':visible')) { // Must be Hide
			// ocultar
			$('#visible-advsearch').hide();
			$('#hiden-advsearch').show();
			$('#adv-search-block').slideUp("slow");
		} else { // Must be shown
			$('#hiden-advsearch').hide();
			$('#visible-advsearch').show();
			$('#adv-search-block').slideDown("slow");
		}
	});

	$('#view-all-types').click(function(e) {
		e.preventDefault();

		if ($("#extra-types").text().length == 0) { // Only once			
			$.ajax({
				type : "POST",
				url : "en/api/ajax_get_all_types",
				dataType : "json",
				cache : true,
				data : {
					hms1: $('input[name="hms1"]').val()
				}
			}).done(function(response) {
				if (response.length) {
					var c = 1;
					var data = new Array();
					var html = '';
					for ( var x = 0; x < response.length; x++) {
						if (c <= 6) {
							data.push(response[x]);
							c++;
						} else {
							c = 1;
							html = html + get_tyes_html_row(data);
							data = new Array();
						}
					}

					if (data.length) {
						html = html + get_tyes_html_row(data);
					}

					$('#extra-types').append(html);
					$('.bz-type').click(function(e){
						get_bz_by_type($(this).val());
					});
					pullUpWrapper();
					$('#extra-types').show("slow");
					$('#hiden-types-bar').hide();
					$('#visible-types-bar').show();
				}
			});

		} else {

			if ($('#extra-types').is(':visible')) { // Must be Hide
				$('#extra-types').hide("slow");
				pullDownWrapper();
				$('#hiden-types-bar').show();
				$('#visible-types-bar').hide();
			} else {
				pullUpWrapper();
				$('#extra-types').show("slow");
				$('#hiden-types-bar').hide();
				$('#visible-types-bar').show();
			}

		}

	});
	
	$('.bz-type').click(function(e){
		get_bz_by_type($(this).val());
	});

});

function put_bz_by_type(type_id){
	console.log(type_id);
}