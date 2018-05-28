var customIcons = {
    dharna: {
      icon: 'img/map-marker/mvn_protest.png'
    },
    accident: {
      icon: 'img/map-marker/mvn_accident.png'
    },
    traffic: {
      icon: 'img/map-marker/mvn_traffic.png'
    },
    hazard: {
      icon: 'img/map-marker/mvn_hazard.png'
    }
  };

var map;
var markering;
var infoWindow;
function initialize() {

  //Map parametrs
  var mapOptions = {
      zoom: 14,
      center: new google.maps.LatLng(24.8615, 67.0099),
      mapTypeId: google.maps.MapTypeId.ROADMAP,

      mapTypeControl: false,
      mapTypeControlOptions: {
          style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
          position: google.maps.ControlPosition.BOTTOM_CENTER
      },
      panControl: false,
      panControlOptions: {
          position: google.maps.ControlPosition.TOP_RIGHT
      },
      zoomControl: true,
      zoomControlOptions: {
          style: google.maps.ZoomControlStyle.LARGE,
          position: google.maps.ControlPosition.TOP_RIGHT
      },
      scaleControl: false,
      scaleControlOptions: {
          position: google.maps.ControlPosition.TOP_LEFT
      },
      streetViewControl: true,
      streetViewControlOptions: {
          position: google.maps.ControlPosition.LEFT_TOP
      }
  }

  //map
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    var infowindow = new google.maps.InfoWindow;
          function marked(){
    downloadUrl("php/map_xml.php", function(data) {
      var xml = data.responseXML;
      var markers = xml.documentElement.getElementsByTagName("marker");
      for (var i = 0; i < markers.length; i++) {
        var place_name = markers[i].getAttribute("place_name");
        var reported_at = markers[i].getAttribute("reported_at");
        var type = markers[i].getAttribute("type");
        var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
        switch(type)
        {
          case "1":
            type =  "dharna";
            console.log('dharna');
            break;
          case "2":
            type = "dharna";
            console.log('dharna 1');
            break;
          case "3":
            type = "traffic";
            console.log('dharna 2');
            break;
          default:
            type = "hazard";     
        }  
        var htmls = "<b>" + place_name  + "</b> <br/>" + reported_at;
        var icon = customIcons[type] || {};
        var marker = new google.maps.Marker({
          map: map,
          position: point,
          icon: icon.icon
        });
        
        bindInfoWindow(marker, map, infowindow, htmls);
      }
    });
      };
    marked();
}
   
   //function
    function bindInfoWindow(marker, map, infowindow, htmls) {
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.setContent(htmls);
      infowindow.open(map, marker);
    });
  }

//httpRequest function
      function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request.responseText, request.status);
      }
    };

    request.open('GET', url, true);
    request.send(null);
  }
  
  
  //function 
  function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request, request.status);
      }
    };

    request.open('GET', url, true);
    request.send(null);
  }

  function doNothing() {}
