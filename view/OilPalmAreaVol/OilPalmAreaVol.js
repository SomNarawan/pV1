
$( document ).ready(function() {
  //  console.log("y");
  $('.tt').tooltip();

});
function initMap() {
  var startLatLng = new google.maps.LatLng(13.736717, 100.523186);

  mapdetail = new google.maps.Map(document.getElementById('map'), {
      // center: { lat: 13.7244416, lng: 100.3529157 },
      center: startLatLng,
      zoom: 8,
      mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  mapdetail.markers = [];
  marker = new google.maps.Marker({
      position: new google.maps.LatLng(13.736717, 100.523186),
      //icon: "http://maps.google.com/mapfiles/kml/paddle/grn-circle.png",
      map: mapdetail,
      title: "test"
  });
}