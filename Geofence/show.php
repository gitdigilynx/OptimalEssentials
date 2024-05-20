<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <title>Geofence</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
       <script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry,drawing&key=AIzaSyCqrZnjQWx79s1srv3sii29aAzah-5v_Jo"></script>
       <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style type="text/css">
       /* Set the size of the div element that contains the map */
        #map {
            width: 100%;
            height: 80vh;
            position: relative;
            transform: translateZ(0px);
            border-radius: 5px;
        }

        #color-palette {
            clear: both;
        }

        .color-button {
            width: 30px;
            height: 30px;
            font-size: 0;
            margin: 2px;
            float: left;
            cursor: pointer;
            border-radius: 16px
        }

        .button_style {
            border-radius: 20px
        }

        .input_radius {
            border-bottom-right-radius: 20px;
            border-top-right-radius: 20px;
        }

        .input_radius_icon {
            border-bottom-left-radius: 20px;
            border-top-left-radius: 20px;
        }

        .padding_less {
            padding-left: 0px;
        }

        .margin_container {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .text-align_div {
            text-align: center;
        }

        #area {
            font-weight: bold;
        }

        .btn-info {
            box-shadow: 0 4px 2px -2px #555;
        }
        .disclaimer{
            display: none!important;
        }
    </style>
   
  </head>
  <body>
    

    

    <div class="container-fluid margin_container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div id="map"></div>
            </div>
        </div>
    </div>

          
          
     <script type="text/javascript">
    
   
 


      /////////////////////////////////////
      var map; //= new google.maps.Map(document.getElementById('map'), {
      // these must have global refs too!:
      var watchID;
      var antennasCircle;
      var marker;
      var userLatLng;
      var pos;
      var stadium ;
      var center ;
      var alerted = false;
      var polygon ;
      var rectangle;
      var polygonDrawn = false;
      var rectangularDrawn = false;
      var  cirlcleDrawn = false;
      var alerted = false;
      var alertedRectangel = false;
      var alertedPolygon = false;

      /////////////////////////////////////
      function initialize() {
        map = new google.maps.Map(document.getElementById('map'), { //var
          zoom: 18,//10,
          center: {lat: -33.8688, lng: 151.2195 },//(22.344, 114.048),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: false,
          zoomControl: true
        });
        axios.post('getDataFromDB.php')
            .then(function(response){
                // alert('responding');
                if (watchID) {
                    navigator.geolocation.clearWatch(watchID);
                    watchID = null;
                }
                
                watchID = navigator.geolocation.watchPosition(function (position) {
                    //    pos = {
                        //     lat: position.coords.latitude,
                        //     lng: position.coords.longitude
                        //   };
                        if(marker){
                            marker.setMap(null);
                        }
           stadium = {lat:position.coords.latitude, lng:position.coords.longitude};
         marker = new google.maps.Marker({
            position: stadium,
            title: 'Your Location',
            map: map,
            dragable:true
        });
        response.data.forEach(function(data) {

            if(data.type == "circle"){
                if(cirlcleDrawn){
                      google.maps.event.clearListeners(antennasCircle, 'click_handler_name');
                    google.maps.event.clearListeners(antennasCircle, 'drag_handler_name');
                    antennasCircle.setRadius(0);
                    // if polygon:
                    // polygon_shape.setPath([]); 
                    antennasCircle.setMap(null);
                }
                 var centerPos = JSON.parse(data.center);
                 var styles = JSON.parse(data.style)
                 center = {lat:centerPos.lat, lng:centerPos.lng}
                  antennasCircle = new google.maps.Circle({
                     strokeColor: styles.strokeColor,
                     strokeOpacity:styles.strokeOpacity,
                     strokeWeight: styles.strokeWeight,
                     fillColor: styles.fillColor,
                     fillOpacity: styles.fillOpacity,
                     map: map,
                     center: center,
                     radius: parseInt(data.radius)
                     });    
                     map.fitBounds(antennasCircle.getBounds());
                 

                     var check = checkMarkerInCircle(stadium, center, parseInt(data.radius));
                    //  console.log(stadium.lat)
                    if (check && alerted==false) {
                        alert("In the region of "+data.zone)
                        alerted=true
                    }else if(check==false && alerted==true){
                        alert("out of the region "+data.zone)
                        alerted=false
                    };
            }
            else if(data.type =="rectangle"){
                if(rectangularDrawn){
                        google.maps.event.clearListeners(antennasCircle, 'click_handler_name');
                        google.maps.event.clearListeners(antennasCircle, 'drag_handler_name');
                        rectangle.setMap(null);

                    }
               var recBonds = (JSON.parse(data.bounds))
                var styles = JSON.parse(data.style)
                 rectangle = new google.maps.Rectangle({
                strokeColor: styles.strokeColor,
                strokeOpacity:styles.strokeOpacity,
                strokeWeight: styles.strokeWeight,
                fillColor: styles.fillColor,
                fillOpacity:styles.fillOpacity,
                map,
                bounds: {
                north: recBonds.north,
                south: recBonds.south,
                east: recBonds.east,
                west: recBonds.west,
                },
            });
            isWithinPoly();
            function isWithinPoly(){
    // console.log(rectangle);
    var point = new google.maps.LatLng(stadium.lat, stadium.lng);
    var isWithinPolygon = rectangle.getBounds().contains(point);
    if(isWithinPolygon && alertedRectangel==false){
        alert("In the region of "+data.zone);
        alertedRectangel=true
    }else if(!isWithinPolygon && alertedRectangel==true){
        alert("out of region "+data.zone);
        alertedRectangel = false
    }

}
            }else if(data.type =="polygon"){
                if(polygonDrawn){
                        google.maps.event.clearListeners(polygon, 'click_handler_name');
                        google.maps.event.clearListeners(polygon, 'drag_handler_name');
                        // polygon.setRadius(0);
                        // if polygon:
                            polygon.setPath([]); 
                            polygon.setMap(null);
                    }
                const triangleCoords = [
                { lat: 25.774, lng: -80.19 },
                { lat: 18.466, lng: -66.118 },
                { lat: 32.321, lng: -64.757 },
                { lat: 25.774, lng: -80.19 },
            ];
                 var styles = JSON.parse(data.style)
             polygon = new google.maps.Polygon({
                paths: JSON.parse(data.paths),
                strokeColor: styles.strokeColor,
                strokeOpacity:styles.strokeOpacity,
                strokeWeight: styles.strokeWeight,
                fillColor: styles.fillColor,
                fillOpacity: styles.fillOpacity,
            });
            google.maps.Polygon.prototype.Contains = function(point) {
                var crossings = 0,
                    path = this.getPath();
                    
                // for each edge
                for (var i = 0; i < path.getLength(); i++) {
                    var a = path.getAt(i),
                        j = i + 1;
                    if (j >= path.getLength()) {
                        j = 0;
                    }
                    var b = path.getAt(j);
                    if (rayCrossesSegment(point, a, b)) {
                        crossings++;
                    }
                }

                // odd number of crossings?
                return (crossings % 2 == 1);

                function rayCrossesSegment(point, a, b) { 
                    var px = point.lng(),
                        py = point.lat(),
                        ax = a.lng(),
                        ay = a.lat(),
                        bx = b.lng(),
                        by = b.lat();
                    if (ay > by) {
                        ax = b.lng();
                        ay = b.lat();
                        bx = a.lng();
                        by = a.lat();
                    }
                    // alter longitude to cater for 180 degree crossings
                    if (px < 0) {
                        px += 360;
                    }
                    if (ax < 0) {
                        ax += 360;
                    }
                    if (bx < 0) {
                        bx += 360;
                    }

                    if (py == ay || py == by) py += 0.00000001;
                    if ((py > by || py < ay) || (px > Math.max(ax, bx))) return false;
                    if (px < Math.min(ax, bx)) return true;

                    var red = (ax != bx) ? ((by - ay) / (bx - ax)) : Infinity;
                    var blue = (ax != px) ? ((py - ay) / (px - ax)) : Infinity;
                    return (blue >= red);

                }

            };
            if(polygon.Contains(marker.getPosition()) && alertedPolygon==false){
        alert("In the region of "+data.zone);
        alertedPolygon=true
    }else if(!polygon.Contains(marker.getPosition()) && alertedPolygon==true){
        alert("out of region "+data.zone);
        alertedPolygon = false
    }
          
            polygon.setMap(map);
            }
        });
        cirlcleDrawn = true;
        rectangularDrawn = true
        polygonDrawn = true

       map.setCenter(marker.getPosition());
          map.setCenter(pos);
                 }, function () {
          handleLocationError(true, infoWindow, map.getCenter());
        });
               

          
            }).catch(function (error) {
                console.log(error);
            });
}
polygon = '';
    google.maps.event.addDomListener(window, 'load', initialize);
    function checkMarkerInCircle(markerPosition, circlePosition, radius) {
      var km = radius/1000;
      var kx = Math.cos(Math.PI * circlePosition.lat / 180) * 111;
      var dx = Math.abs(circlePosition.lng - markerPosition.lng) * kx;
      var dy = Math.abs(circlePosition.lat - markerPosition.lat) * 111;
      return Math.sqrt(dx * dx + dy * dy) <= km;
    }



      
    </script>
        
  </body>
</html>