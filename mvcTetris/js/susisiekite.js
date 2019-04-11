function initMap() {
    var location = { lat: 54.895720, lng: 23.923730 };
    var map = new google.maps.Map(document.getElementById("map"), {
      zoom: 15,
      center: location
    });
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }