
function mapInitialize(location) {
	
	if(location){
		myLatlng = currLatlng = new google.maps.LatLng(location.coords.latitude,
				location.coords.longitude);		
	}else{
		myLatlng = sysDefaultLocation;
	}

	if(userDefaultLocation){
		myLatlng = userDefaultLocation;
	}
	
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
		zoom : map_zoom,
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
	
	google.maps.event.addListener(myLocation, 'dragend', function(e){
		changeLocation(e.latLng);
	});
	google.maps.event.addListener(map, 'click', function(event) {
		    placeMarker(event.latLng);
		  });
}

function changeLocation(latLng){
	myLatlng = latLng;
	map.setCenter(myLatlng);
}

function placeMarker(location) {
	  var marker = new google.maps.Marker({
	      position: location,
	      map: map
	  });
	  map.setCenter(location);
}

function errorHandler(err) {
	
	mapInitialize(null);
	
	/*if(err.code == 1) {
	    alert("Error: Access is denied!");
	  }else if( err.code == 2) {
	    alert("Error: Position is unavailable!");
	  }*/
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

function set_map_location(elem){
	var name = elem.attr('name');
	var lat = elem.attr('lat');
	var lng = elem.attr('lng');
	
	myLatlng = new google.maps.LatLng(lat, lng);
	myLocation.setPosition(myLatlng);
	map.setCenter(myLatlng);
	
	$( ".user-locations" ).each(function( index ) {
		$(this).text($(this).attr('name'));
		$(this).attr('current', '0');
	});
	
	elem.text(name + '*');
	elem.attr('current', '1');	
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
	
	$('#login-action').click(function(e){
		e.preventDefault();
		
		$.ajax({
			type : "POST",
			url : $('#login-form').attr('action'),
			dataType : "json",
			data : {
				email: $('input[name="email"]').val(),
				passwd: $('input[name="passwd"]').val(),
				hms1: $('input[name="hms1"]').val()
			}
		}).done(function(response) {
			if(response.status == 'error'){
				$('#login-error-msg').html(response.msg);
				$('#login-error-wrapper').show();
			}else{
				window.location.reload(true);
			}
		});
		
	});
	
	$('.user-locations').click(function(e){
		e.preventDefault();
		set_map_location($(this));		
	});
	
	$('#add-location-action').click(function(e){
		e.preventDefault();
		
		var name = $('input[name="location-name"]').val();
		if(!name){
			$('#add-location-error-msg').html(err_msg_missing_field);
			$('#add-location-error-wrapper').show();			
			return false;
		}
		
		var def = $('input[name="location-def"]').is(':checked') ? '1' : '0';
		var lat = myLatlng.lat();
		var lng = myLatlng.lng();
		
		$.ajax({
			type : "POST",
			url : $('#add-location-form').attr('action'),
			dataType : "json",
			data : {
				name: name,
				lat: lat,
				lng: lng,
				def: def,
				hms1: $('input[name="hms1"]').val()
			}
		}).done(function(response) {
			if(response.status == 'error'){
				$('#add-location-error-msg').html(response.msg);
				$('#add-location-error-wrapper').show();
				return false;
			}
			
			$('input[name="location-name"]').val('');
			$.modal.close();

			$( ".user-locations" ).each(function( index ) {
				$(this).text($(this).attr('name'));
				$(this).attr('current', '0');
			});

			$('#saved-locations').append('<li><a href="javascript:void(0)" class="user-locations" lat="' + lat + '" lng="' + lng + '" name="' + name + '" current="1">' + name + '*</a></li>');

			$('.user-locations').click(function(e){
				e.preventDefault();
				set_map_location($(this));		
			});
		
		});
		
	});
	
	$('#set-default-location').click(function(e){
		e.preventDefault();

		var name = '';
		$( ".user-locations" ).each(function( index ) {
			if($(this).attr('current') == '1')
				name = $(this).attr('name');
		});
		
		if(!name)
			return false;
		
		$.ajax({
			type : "POST",
			url : $(this).attr('href'),
			dataType : "json",
			data : {
				name: name,
				hms1: $('input[name="hms1"]').val()
			}
		}).done(function(response) {
				return true;		
		});		
	});
	
	$('#delete-location').click(function (e){
		e.preventDefault();
		
		var name = '';
		$( ".user-locations" ).each(function( index ) {
			if($(this).attr('current') == '1')
				name = $(this).attr('name');
		});
		
		if(!name)
			return false;

		$.ajax({
			type : "POST",
			url : $(this).attr('href'),
			dataType : "json",
			data : {
				name: name,
				hms1: $('input[name="hms1"]').val()
			}
		}).done(function(response) {
				return true;		
		});		

	});
	
	$('#signin-action').click(function (e){
		e.preventDefault();
		
		var hms1 = $('input[name="hms1"]').val();
		var name = $('input[name="user_name"]').val();
		var email = $('input[name="user_email"]').val(); 
		var passwd = $('input[name="user_passwd"]').val();
		var passwd2 = $('input[name="user_passwd2"]').val();
		var recaptcha_challenge_field = $('input[name="recaptcha_challenge_field"]').val();
		var recaptcha_response_field = $('input[name="recaptcha_response_field"]').val();
				
		if(!name || !email || !passwd){
			$('#signin-error-msg').html(err_msg_missing_field_signin);
			$('#signin-error-wrapper').show();			
			return false;
		}
		
		if(passwd != passwd2){
			$('#signin-error-msg').html(err_msg_mismatch_pass);
			$('#signin-error-wrapper').show();			
			return false;			
		}
		
		//Email format validation
		var emailReg = /^[a-zA-Z0-9._-]+([+][a-zA-Z0-9._-]+){0,1}[@][a-zA-Z0-9._-]+[.][a-zA-Z]{2,6}$/;
		if( !emailReg.test( email ) ) {
			$('#signin-error-msg').html(err_msg_wrong_email_format);
			$('#signin-error-wrapper').show();			
			return false;
		}
		
		$.ajax({
			type : "POST",
			url : $('#signin-form').attr('action'),
			dataType : "json",
			data : {
				hms1: hms1,
				name : name,
				email : email,
				passwd: passwd,
				recaptcha_challenge_field: recaptcha_challenge_field,
				recaptcha_response_field: recaptcha_response_field
			}
		}).done(function(response) {
			if(response.status == 'error'){
				$('#signin-error-msg').html(response.msg);
				$('#signin-error-wrapper').show();
				return false;
			}
			
			window.location.reload(true);
			
		});		
		
	});
	
	$('.bz-type').click(function(e){
		put_bz_by_type($(this).val());
	});

});


function put_bz_by_type(type_id){
	console.log(type_id);
}
