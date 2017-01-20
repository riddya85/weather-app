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

            var service = new google.maps.places.PlacesService(map);
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
    initSearchForm: function() {
        $("#submitSearch").on('click',function(e) {
            e.preventDefault();
            var form = $(this).parent('form');

            var action = form.attr('action');

            var index = action.lastIndexOf('forecast')+8;
            var url = action.substr(0,index);

            var newUrl = url + "/" + $('#lng').val() + "/" + $('#lat').val();

            form.attr('action',newUrl);
            form.submit();
        });
    }
};

module.exports = maps;