var options = {
    mapTypeControlOptions: {
        mapTypeIds: ['Styled']
    },
    center: new google.maps.LatLng(61.272410210396956,73.35203177116388),
    zoom: 15,
    scrollwheel: false,
    draggable: true,
};

map = new google.maps.Map(document.getElementById("map"), options);

// Onsen
var myLatlng = new google.maps.LatLng(61.272410210396956,73.35203177116388);

var markerImage = new google.maps.MarkerImage(
    '/images/mark.png',
    new google.maps.Size(62,83),
    new google.maps.Point(0,0),
    new google.maps.Point(31, 83)
);
  
var marker = new google.maps.Marker({
    icon: markerImage,
    position: myLatlng,
    map: map,
    title: '«Автопарк» - ул. Югорский тракт 1, к.1'
});

var contentString = '«Автопарк» - ул. Югорский тракт 1, к.1';

var infowindow = new google.maps.InfoWindow({
    content: contentString
});

marker.addListener('click', function() {
    infowindow.open(map, marker);
});

// 
