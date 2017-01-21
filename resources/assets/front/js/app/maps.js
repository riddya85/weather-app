var $ = require('jquery');

var GoogleMapsLoader = require('google-maps');

GoogleMapsLoader.KEY = 'AIzaSyCdX6-YxZ45Dnc6pEqPY0i9rjUp79Z2yF0';
GoogleMapsLoader.LIBRARIES = ['places'];

var maps = {
    init: function() {
        GoogleMapsLoader.load(function(google) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 0, lng: 0},
                zoom: 1
            });

            var input = document.getElementById('city');

            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.bindTo('bounds', map);

            var marker = new google.maps.Marker({
                map: map
            });

            autocomplete.addListener('place_changed', function() {
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                
                $('#lng').val(place.geometry.location.lng());
                $('#lat').val(place.geometry.location.lat());

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            });
        });
        this.initSearchForm();

    },
    getUrlParameter: function(sParam,link) {
        var index = link.indexOf('forecast') + 9;
        link = link.substring(index);

        var sPageURL = decodeURIComponent(link),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    },
    callback: function(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                var place = results[i];
                createMarker(results[i]);
            }
        }
    },
    initHistoryMap: function() {
        GoogleMapsLoader.load(function(google) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 0, lng: 0},
                zoom: 1
            });

            var newMarkers = [];

            $('a.item-link').each(function() {

                var link = $(this).attr('href');

                var lng = maps.getUrlParameter('lng',link);
                var lat = maps.getUrlParameter('lat',link);
                var name = maps.getUrlParameter('name',link);

                var myLatlng = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

                var marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    title: name,
                    animation: google.maps.Animation.DROP
                });

                marker.addListener('click', function() {
                    map.setZoom(8);
                    map.setCenter(marker.getPosition());
                });

                newMarkers.push(marker);
            });
        });
    },
    initSearchForm: function() {
        $("#submitSearch").on('click',function(e) {
            var form = $(this).parent('form');
            e.preventDefault();

            $("#name").val($("#city").val());

            form.submit();
        });
    }
};

module.exports = maps;