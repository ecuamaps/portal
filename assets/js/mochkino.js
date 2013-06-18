
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
	
function mapInitialize(location) {

	if (location) {
		myLatlng = currLatlng = new google.maps.LatLng(
				location.coords.latitude, location.coords.longitude);
	} else {
		myLatlng = sysDefaultLocation;
	}

	if (userDefaultLocation) {
		myLatlng = userDefaultLocation;
	}

	var cookie_latlng = cookie('latlng');

	if (cookie_latlng) {
		myLatlng = new google.maps.LatLng(cookie_latlng.lat, cookie_latlng.lng);
	}

	cookie('latlng', {
		'lat' : myLatlng.lat(),
		'lng' : myLatlng.lng()
	});

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

	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

	myLocation = new google.maps.Marker({
		position : myLatlng,
		map : map,
		title : currentPosLbl,
		icon : 'assets/images/myLocation.png',
		draggable : true
	});
	
    codeLatLng();
	
    /*if (location) {
		if (location.coords.accuracy < 200) {
			var myLocationAccuracy = new google.maps.Circle({
				map : map,
				radius : location.coords.accuracy,
				fillColor : "#5882FA",
				strokeColor : "#2E2EFE",
				strokeWeight : 1
			});
			myLocationAccuracy.bindTo('center', myLocation, 'position');
		} else {
			alert(accuracyErrorMsg);
		}
	}*/

    google.maps.event.addListener(myLocation, 'dragend', function(e) {
        changeLocation(e.latLng);
    });

/*
	 * google.maps.event.addListener(map, 'click', function(event) {
	 * placeMarker(event.latLng); });
	 */

}

function changeLocation(latLng) {
    myLatlng = latLng;
    map.setCenter(myLatlng);
    cookie('latlng', {
        'lat' : myLatlng.lat(),
        'lng' : myLatlng.lng()
    });
	
    codeLatLng();
}

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position : location,
        map : map
    });
    map.setCenter(location);
}

function errorHandler(err) {

    return null;

}

function get_tyes_html_row(data) {
    var html = '<div class="row">';
    for ( var x = 0; x < data.length; x++) {
        html = html + '<div class="small-2 columns">'
        + '<label class="text-color-white" for="type_' + data[x].id
        + '"><input class="bz-type" type="checkbox" name="type_'
        + data[x].id + '" id="type_' + data[x].id + '" value="'
        + data[x].id + '">' + data[x].name + '</label>' + '</div>';
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

function set_map_location(elem) {
    var name = elem.attr('name');
    var lat = elem.attr('lat');
    var lng = elem.attr('lng');

    changeLocation(new google.maps.LatLng(lat, lng));
    // myLatlng = new google.maps.LatLng(lat, lng);
    myLocation.setPosition(myLatlng);
    map.setCenter(myLatlng);

    $(".user-locations").each(function(index) {
        $(this).text($(this).attr('name'));
        $(this).attr('current', '0');
    });

    elem.text(name + '*');
    elem.attr('current', '1');
}

function goToMyCurrentLocation(location){
	myLatlng = currLatlng = new google.maps.LatLng(
			location.coords.latitude, location.coords.longitude);
	changeLocation(myLatlng);
	myLocation.setPosition(myLatlng);
}

$(document).ready(function() {
    $.cookie.json = true;
    $.cookie.expires = 1;
    
    mapInitialize(null);
    
    $('#chlocation-go-current-location').click(function (e){
    	e.preventDefault();
    	Foundation.libs.dropdown.close($('#change-location-wrapper'));
    	navigator.geolocation.getCurrentPosition(goToMyCurrentLocation, errorHandler);
    });
    //navigator.geolocation.getCurrentPosition(mapInitialize, errorHandler);

    /*$('#adv-search').click(function(e) {
		e.preventDefault();

		if ($('#adv-search-block').is(':visible')) { // Must be Hide
			$('#visible-advsearch').hide();
			$('#hiden-advsearch').show();
			$('#adv-search-block').slideUp("slow");
		} else { // Must be shown
			$('#hiden-advsearch').hide();
			$('#visible-advsearch').show();
			$('#adv-search-block').slideDown("slow");
		}
	});*/

    $('#view-all-types').click(function(e) {
        e.preventDefault();

        if ($("#extra-types").text().length == 0) { // Only once
            $.ajax({
                type : "POST",
                url : "en/api/ajax_get_all_types",
                dataType : "json",
                cache : true,
                data : {
                    hms1 : $('input[name="hms1"]').val()
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
                    $('.bz-type').click(function(e) {
                        get_bz_by_type($(this).val());
                    });
					
                    pullUpWrapper();
                    $('#extra-types').show("slow");
                    $('#hiden-types-bar').hide();
                    $('#visible-types-bar').show();
                }
            });
			
        } else {

            if ($('#extra-types')
                .is(':visible')) { // Must
                // be
                // Hide
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

    $('#login-action').click(function(e) {
        e.preventDefault();

        $.ajax({
            type : "POST",
            url : $('#login-form').attr('action'),
            dataType : "json",
            data : {
                email : $('input[name="email"]').val(),
                passwd : $('input[name="passwd"]').val(),
                hms1 : $('input[name="hms1"]').val()
            }
        }).done(function(response) {
            if (response.status == 'error') {
                $('#login-error-msg').html(response.msg);
                $('#login-error-wrapper').show();
            } else {
                window.location.reload(true);
            }
        });

    });

    $('.user-locations').click(function(e) {
        e.preventDefault();
        set_map_location($(this));
    });

    $('#add-location-action')
    .click(
        function(e) {
            e.preventDefault();

            var name = $(
                'input[name="location-name"]')
            .val();
            if (!name) {
                $('#add-location-error-msg').html(err_msg_missing_field);
                $('#add-location-error-wrapper')
                .show();
                return false;
            }

            var def = $(
                'input[name="location-def"]') 
                .is(':checked') ? '1' : '0';
            var lat = myLatlng.lat();
            var lng = myLatlng.lng();

            $
            .ajax(
            {
                type : "POST",
                url : $(
                    '#add-location-form')
                .attr(
                    'action'),
                dataType : "json",
                data : {
                    name : name,
                    lat : lat,
                    lng : lng,
                    def : def,
                    hms1 : $(
                        'input[name="hms1"]')
                    .val()
                }
            })
            .done(
                function(response) {
                    if (response.status == 'error') {
                        $(
                            '#add-location-error-msg')
                        .html(
                            response.msg);
                        $(
                            '#add-location-error-wrapper')
                        .show();
                        return false;
                    }

                    $('input[name="location-name"]').val('');
                    $('#add-location-form-wrapper').foundation('reveal', 'close');

                    $('#set-default-location, #delete-location').show();

                    $(".user-locations")
                    .each(
                        function(
                            index) {
                            $(
                                this)
                            .text(
                                $(
                                    this)
                                .attr(
                                    'name'));
                            $(
                                this)
                            .attr(
                                'current',
                                '0');
                        });

                    $(
                        '#saved-locations')
                    .append(
                        '<li><a href="javascript:void(0)" class="user-locations" lat="'
                        + lat
                        + '" lng="'
                        + lng
                        + '" name="'
                        + name
                        + '" current="1">'
                        + name
                        + '*</a></li>');

                    $('.user-locations')
                    .click(
                        function(
                            e) {
                            e
                            .preventDefault();
                            set_map_location($(this));
                        });

                });

        });

    $('#set-default-location').click(function(e) {
        e.preventDefault();

        var name = '';
        $(".user-locations").each(function(index) {
            if ($(this).attr('current') == '1')
                name = $(this).attr('name');
        });

        if (!name)
            return false;

        $.ajax({
            type : "POST",
            url : $(this).attr('href'),
            dataType : "json",
            data : {
                name : name,
                hms1 : $('input[name="hms1"]').val()
            }
        }).done(function(response) {
            return true;
        });
    });

    $('#delete-location').click(function(e) {
        e.preventDefault();

        var name = '';
        $(".user-locations").each(function(index) {
            if ($(this).attr('current') == '1')
                name = $(this).attr('name');
        });

        if (!name)
            return false;

        $.ajax({
            type : "POST",
            url : $(this).attr('href'),
            dataType : "json",
            data : {
                name : name,
                hms1 : $('input[name="hms1"]').val()
            }
        }).done(function(response) {

            if (response.status == 'error') {
                alert(response.msg);
                return false;
            }

            $(".user-locations").each(function(index) {
                if ($(this).attr('current') == '1')
                    $(this).hide();
            });

        });

    });

    $('#signup-action').click(function(e) {
        e.preventDefault();

        var hms1 = $('input[name="hms1"]').val();
        var name = $('input[name="user_name"]').val();
        var email = $('input[name="user_email"]').val();
        var passwd = $('input[name="user_passwd"]').val();
        var passwd2 = $('input[name="user_passwd2"]').val();

        if (!name || !email || !passwd) {
            $('#signin-error-msg').html(err_msg_missing_field_signin);
            $('#signin-error-wrapper').show();
            return false;
        }

        if (passwd != passwd2) {
            $('#signin-error-msg').html(err_msg_mismatch_pass);
            $('#signin-error-wrapper').show();
            return false;
        }

        // Email format validation
        var emailReg = /^[a-zA-Z0-9._-]+([+][a-zA-Z0-9._-]+){0,1}[@][a-zA-Z0-9._-]+[.][a-zA-Z]{2,6}$/;
        if (!emailReg.test(email)) {
            $('#signin-error-msg').html(err_msg_wrong_email_format);
            $('#signin-error-wrapper').show();
            return false;
        }
        
        $('#waiting').show();
        $('#signup-form').hide();
        
        $.ajax({
            type : "POST",
            url : $(
                '#signup-form')
            .attr(
                'action'),
            dataType : "json",
            data : {
                hms1 : hms1,
                name : name,
                email : email,
                passwd : passwd
            }
        }).done(function(response) {
        	if (response.status == 'error') {
        		$('#signin-error-msg').html(response.msg);
        		$('#signin-error-wrapper').show();
                $('#waiting').hide();
                $('#signup-form').show();
        		return false;
        	}
            
            $('#waiting').hide();
            $('#succesfull').show();
        });

    });

    $('#nav-menu-back').click(function(e) {
        map.setCenter(myLatlng);
    });

    $('#nav-menu-move').click(function(e) {
        changeLocation(map.getCenter());
        myLocation.setPosition(myLatlng);
    });

    $('.nav-location').click(function(e) {

        var lat = $(this).attr('lat');
        var lng = $(this).attr('lng');

        changeLocation(new google.maps.LatLng(lat, lng));
        myLocation.setPosition(myLatlng);
        map.setCenter(myLatlng);
    });

    $('#chlocation-action').click(function(e){
        var address = $('input[name="new_addr"]').val();
        if(address){
            geocoder.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    changeLocation(results[0].geometry.location);
                    myLocation.setPosition(results[0].geometry.location);
                    $('input[name="new_addr"]').val('');
                } else {
                    alert(locationErrorMsg);
                }
            });			
        }
		
        Foundation.libs.dropdown.close($('#change-location-wrapper'));
    });

    $('#search-btn').click(function(e){
				
        var text = $('input[name="search-text"]').val();
		
        if(!text)
            return false;
		
        $.ajax({
            type : "POST",
            url : $('#search-form').attr('action'),
            dataType : "html",
            data : {
                text : text,
                hms1 : $('input[name="hms1"]').val()
            }
        }).done(function(response) {
            showSearchResults(response);
            $('#search-result-wrapper').foundation('reveal', 'open');
        });
						
    });
					
    $('#close-panel-button, #open-panel-button').click(function(e){
        e.preventDefault();
        showHideLeftPanel();
    });
	
    $('.search-results-panel').click(function(e){
        e.preventDefault();

        var post_id = $(this).attr('id');
		
		
        if($('input[name="' + post_id + '-inmap"]').val() == '1'){
            $('input[name="' + post_id + '-inmap"]').val('0');
            $(this).attr('style', 'background: none repeat scroll 0 0 #FFFFFF !important;');
            removeMarker(post_id);
        } else {

            $('input[name="' + post_id + '-inmap"]').val('1');
			
            $(this).attr('style', 'background: none repeat scroll 0 0 #A1D1E0 !important;');
			
            var lat = $('input[name="' + post_id + '-lat"]').val();
            var lng = $('input[name="' + post_id + '-lng"]').val();

            var latLng = new google.maps.LatLng(lat, lng);
            addMarker(post_id, latLng);			
        }
		

    //console.log(markers);
    });
	
    $('#load-into-map').click(function(e){
        e.preventDefault();
    });
	
    $('.bz-type').click(function(e) {
        put_bz_by_type($(this).val());
    });
    
    $('#chpwd-action').click(function(e){
         e.preventDefault();
                  
        var hms1     = $('input[name="hms1"]').val();
        var oldpass  = $('input[name="chpwd_oldpasswd"]').val();
        var newpass  = $('input[name="chpwd_newpasswd"]').val();
        var newpasswd = $('input[name="chpwd_newpasswd2"]').val();
        var email = $('input[name="chpwd_email"]').val();

        if (!oldpass || !newpass || !newpasswd) {
            $('#chpwd-error-msg').html(chpwd_err_msg_missing_field);
            $('#chpwd-error-wrapper').show();
            return false;
        }

        if (newpass != newpasswd ) {
            $('#chpwd-error-msg').html(chpwd_error_keys_mistmatch);
            $('#chpwd-error-wrapper').show();
            return false;
        }
         
         $.ajax({
            type : "POST",
            url : $('#chpwd-form').attr('action'),        
            dataType : "json",
            data : {
                hms1     : hms1,
                email    : email,
                oldpass  : oldpass,
                newpass  : newpass,
                newpasswd : newpasswd
            }
        }).done(function(response){
            if(response.status == 'error'){
                $('#chpwd-error-msg').html(response.msg);
                $('#chpwd-error-wrapper').show();
                return false;
            }

            $('input[name="chpwd_oldpasswd"], input[name="chpwd_newpasswd"], input[name="chpwd_newpasswd2"]').val('');
            alert(response.msg);
            $('#chpwd-form-wrapper').foundation('reveal', 'close');
        });
         
         
    });
});

function search(){
	
}

function removeMarker(id){
    markers[id].setMap(null);
    markers[id] = null;
}

function addMarker(id, latLng){
    markers[id] = placeMarker(latLng);
}

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position : location,
        map : map
    });
    map.setCenter(location);
	
    return marker;
}

function showSearchResults(response){

    if (response.status == 'error') {
        alert(response.msg);
        return false;
    }
	
    $('#search-result-wrapper').html(response);
}

function showHideLeftPanel(){
	
    if ($('#left-panel').attr('class') == 'large-3 columns') {
		
        $('#left-panel').attr('class', 'large-1 columns');
        $('#right-panel').attr('class', 'large-11 columns');
		
        $('#close-panel-button').attr('style', 'display: none !important;');		
        $('#open-panel-button').attr('style', '');
		
        $('#clear-button-wrapper').hide();
		
    } else {
        $('#left-panel').attr('class', 'large-3 columns');
        $('#right-panel').attr('class', 'large-9 columns');

        $('#close-panel-button').attr('style', '');	
        $('#open-panel-button').attr('style', 'display: none !important;');

        $('#clear-button-wrapper').show();
    }
	
}

function codeLatLng() {
    geocoder.geocode({
        'latLng' : myLatlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                //map.setZoom(11);
                //infowindow.setContent(results[1].formatted_address);
                //infowindow.open(map, myLocation);
                $('#current-address').html(results[1].formatted_address);
            }
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });
}

function cookie(name, val) {

    if (val) {
        return $.cookie(name, val);
    } else {
        return $.cookie(name);
    }
}

function put_bz_by_type(type_id) {
    console.log(type_id);
}
