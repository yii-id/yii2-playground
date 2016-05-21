(function ($) {
    var pos = {lat: -6.2115, lng: 106.8452};

    var map = new google.maps.Map(document.getElementById('map'), {
        center: pos,
        zoom: 12
    });
    var geocoder = new google.maps.Geocoder;
    var marker = new google.maps.Marker({
        position: pos,
        map: map,
    });
    getLocationName(pos);
    setImsakiyah(pos);

    map.addListener('click', function (e) {
        marker.setPosition(e.latLng);
        var pos = {lat: e.latLng.lat(), lng: e.latLng.lng()};
        getLocationName(pos);
        setImsakiyah(pos);
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            marker.setPosition(pos);
            map.panTo(pos);
            getLocationName(pos);
            setImsakiyah(pos);
        });
    }


    function getLocationName(pos) {
        var s = '(' + pos.lat + ', ' + pos.lng + ')';
        geocoder.geocode({'latLng': pos}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK && results[1]) {
                $('#location-name').text(results[1].formatted_address + '\n' + s);
            } else {
                $('#location-name').text(s);
            }
        });
    }
    function setImsakiyah(pos) {
        $.get(urlImsakiyah, pos, function (r) {
            var $bodyTbl = $('#body-tbl').html('');
            $.each(r, function (k, v) {
                $('<tr>').append('<th>' + k + '</th>')
                    .append('<td>' + v + '</td>')
                    .appendTo($bodyTbl);
            });
        });
    }
})(jQuery);