<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Geofence</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
       <script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry,drawing&key=AIzaSyCqrZnjQWx79s1srv3sii29aAzah-5v_Jo"></script>
      
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
            <div class="col-sm-6 col-md-6">
                <div class="input-group">
                    <span class="input-group-addon input_radius_icon"><i class="glyphicon glyphicon-search"></i></span>
                    <input id="pac-input1" type="text" class="form-control input_radius " placeholder="Enter your address">
                </div>
            </div>
            <!-- <div class="col-sm-1 col-md-1 padding_less">
                <button type="button" class="btn btn-info button_style" id="search_byaddress">Search</button>
            </div> -->
        </div>
    </div>
    

    <div class="container-fluid margin_container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 40px;">
        <div class="row" style=" margin-bottom: 10px;">
            <div class="col-sm-4 col-md-4">
                <div id="color-palette"></div>
            </div>
            <div class="col-sm-4 col-md-4 text-align_div">
                <button type="button" class="btn btn-danger button_style" id="delete-button">Delete Selected Geofence</button>
                <button type="button" class="btn btn-info button_style"  id="save_data">Save Selected Geofence</button>
            </div>
            <div class="col-sm-4 col-md-4">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 text-align_div">
               <div id="curpos" style="display:none;"></div>
               <div id="cursel" style="display:none;"></div>
 
            </div>
        </div>

          
          <!-- Modal -->
          <div class="modal fade" id="saveModal" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Save Geofence</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                      <input type="text" class="form-control" id="zone" placeholder="Geofence zone " name="zone">
                  </div>
                  
                  <div id="inputs_group" style="display:none;">
                     
                    <div class="form-group">
                      <input type="text" class="form-control" id="type" placeholder="Type" name="type" readonly>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="style" placeholder="Styles" name="style" readonly>
                    </div>
                     <div class="form-group">
                      <input type="text" class="form-control" id="paths" placeholder="Paths" name="paths" readonly>
                     </div>
                     <div class="form-group">
                      <input type="text" class="form-control" id="bounds" placeholder="Bounds" name="bounds" readonly>
                     </div>
                     <div class="form-group">
                      <input type="text" class="form-control" id="center" placeholder="center" name="center" readonly>
                     </div>
                     <div class="form-group">
                      <input type="text" class="form-control" id="radius" placeholder="Radius" name="radius" readonly>
                     </div>
                  </form>
               </div>
               
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="submit_form">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          
          
     <script type="text/javascript">
    
    $(document).ready(function(){
 
      var drawingManager;
      var selectedShape;
      var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
      var selectedColor;
      var colorButtons = {};

      function clearSelection() {
        if (selectedShape) {
          if (typeof selectedShape.setEditable == 'function') {
            selectedShape.setEditable(false);
          }
          selectedShape = null;
        }
        curseldiv.innerHTML = "<b>cursel</b>:";
      }

      function updateCurSelText(shape) {
        posstr = "" + selectedShape.position;
        if (typeof selectedShape.position == 'object') {
          posstr = selectedShape.position.toUrlValue();
        }
        pathstr = "" + selectedShape.getPath;
        if (typeof selectedShape.getPath == 'function') {
          pathstr = "[ ";
          for (var i = 0; i < selectedShape.getPath().getLength(); i++) {
            // .toUrlValue(5) limits number of decimals, default is 6 but can do more
            var pathstr1 = '{ "lat": '+selectedShape.getPath().getAt(i).toUrlValue() + ' }';
            if( i === selectedShape.getPath().getLength()-1) {
              pathstr += pathstr1.replace(",", ', "lng": ');

            }else{

              pathstr += pathstr1.replace(",", ', "lng": ')+ ", ";
            }
          }
          pathstr +=  "]";

  
        }
        bndstr = "" + selectedShape.getBounds;
        cntstr = "" + selectedShape.getBounds;
        if (typeof selectedShape.getBounds == 'function') {
          var tmpbounds = selectedShape.getBounds();
          cntstr = "" + tmpbounds.getCenter().toUrlValue();

          norteast1 =  '{ "north": '+tmpbounds.getNorthEast().toUrlValue();
          southwest1 =  ' "south": '+tmpbounds.getSouthWest().toUrlValue()+'}';
          norteast = norteast1.replace(",", ', "east": ')+',';
          southwest = southwest1.replace(",", ', "west": ');
          bndstr = norteast + southwest;
        }
        cntrstr = "" + selectedShape.getCenter;
        if (typeof selectedShape.getCenter == 'function') {
          cntrstr1 = '{ "lat": ' +selectedShape.getCenter().toUrlValue();
          cntrstr = cntrstr1.replace(",", ', "lng": ')+' }';
        }

        radstr = "" + selectedShape.getRadius;
        if (typeof selectedShape.getRadius == 'function') {
          radstr = "" + selectedShape.getRadius();
        }
       
       
    
       fillcoloropacity = `{"strokeColor": "${selectedShape.fillColor}" , "fillColor": "${selectedShape.fillColor}", "fillOpacity": "${selectedShape.fillOpacity}", "strokeOpacity": "${selectedShape.strokeOpacity}",  "strokeWeight": 0}`;
       

        curseldiv.innerHTML += "<b>color</b>: " + fillcoloropacity ;
        curseldiv.innerHTML += "<b>cursel</b>: " + selectedShape.type + " " + selectedShape + "; <i>pos</i>: " + posstr + " ; <i>path</i>: " + pathstr + " ; <i>bounds</i>: " + bndstr + " ; <i>Cb</i>: " + cntstr + " ; <i>radius</i>: " + radstr + " ; <i>Cr</i>: " + cntrstr ;

      $('#zone').val("");
       $('#type').val("");
       $('#style').val("");
       $('#paths').val("");
       $('#bounds').val("");
       $('#center').val("");
       $('#radius').val("");


       $('#zone').val();
       $('#type').val(selectedShape.type);
       $('#style').val(fillcoloropacity);
       $('#paths').val(pathstr);
       $('#bounds').val(bndstr);
       $('#center').val(cntrstr);
       $('#radius').val(radstr);
      }


      function setSelection(shape, isNotMarker) {
        clearSelection();
        selectedShape = shape;
        if (isNotMarker)
          shape.setEditable(true);
        selectColor(shape.get('fillColor') || shape.get('strokeColor'));
        updateCurSelText(shape);
      }

      function deleteSelectedShape() {
        if (selectedShape) {
          selectedShape.setMap(null);
        }
      }

      function selectColor(color) {
        selectedColor = color;
        for (var i = 0; i < colors.length; ++i) {
          var currColor = colors[i];
          colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
        }

        // Retrieves the current options from the drawing manager and replaces the
        // stroke or fill color as appropriate.
        var polylineOptions = drawingManager.get('polylineOptions');
        polylineOptions.strokeColor = color;
        drawingManager.set('polylineOptions', polylineOptions);

        var rectangleOptions = drawingManager.get('rectangleOptions');
        rectangleOptions.fillColor = color;
        drawingManager.set('rectangleOptions', rectangleOptions);

        var circleOptions = drawingManager.get('circleOptions');
        circleOptions.fillColor = color;
        drawingManager.set('circleOptions', circleOptions);

        var polygonOptions = drawingManager.get('polygonOptions');
        polygonOptions.fillColor = color;
        drawingManager.set('polygonOptions', polygonOptions);
      }

      function setSelectedShapeColor(color) {
        if (selectedShape) {
          if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
            selectedShape.set('strokeColor', color);
          } else {
            selectedShape.set('fillColor', color);
          }
        }
      }

      function makeColorButton(color) {
        var button = document.createElement('span');
        button.className = 'color-button';
        button.style.backgroundColor = color;
        google.maps.event.addDomListener(button, 'click', function() {
          selectColor(color);
          setSelectedShapeColor(color);
        });

        return button;
      }

       function buildColorPalette() {
         var colorPalette = document.getElementById('color-palette');
         for (var i = 0; i < colors.length; ++i) {
           var currColor = colors[i];
           var colorButton = makeColorButton(currColor);
           colorPalette.appendChild(colorButton);
           colorButtons[currColor] = colorButton;
         }
         selectColor(colors[0]);
       }

      /////////////////////////////////////
      var map; //= new google.maps.Map(document.getElementById('map'), {
      // these must have global refs too!:
      var placeMarkers = [];
      var input;
      var searchBox;
      var curposdiv;
      var curseldiv;

      function deletePlacesSearchResults() {
        for (var i = 0, marker; marker = placeMarkers[i]; i++) {
          marker.setMap(null);
        }
        placeMarkers = [];
        input.value = ''; // clear the box too
      }

      /////////////////////////////////////
      function initialize() {
        map = new google.maps.Map(document.getElementById('map'), { //var
          zoom: 18,//10,
          center: {lat: -33.8688, lng: 151.2195 },//(22.344, 114.048),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: false,
          zoomControl: true
        });
        curposdiv = document.getElementById('curpos');
        curseldiv = document.getElementById('cursel');

        var polyOptions = {
          strokeWeight: 0,
          fillOpacity: 0.45,
          editable: true
        };
        // Creates a drawing manager attached to the map that allows the user to draw
        // markers, lines, and shapes.
        drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          markerOptions: {
            draggable: true,
            editable: true,
          },
          polylineOptions: {
            editable: true
          },
          rectangleOptions: polyOptions,
          circleOptions: polyOptions,
          polygonOptions: polyOptions,
          drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [
                        // google.maps.drawing.OverlayType.MARKER,
                        google.maps.drawing.OverlayType.CIRCLE,
                        // google.maps.drawing.OverlayType.POLYLINE,
                        google.maps.drawing.OverlayType.RECTANGLE,
                        google.maps.drawing.OverlayType.POLYGON,
                      ],
                    },
          map: map
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
          //~ if (e.type != google.maps.drawing.OverlayType.MARKER) {
            var isNotMarker = (e.type != google.maps.drawing.OverlayType.MARKER);
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setDrawingMode(null);

            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            var newShape = e.overlay;
            newShape.type = e.type;
              google.maps.event.addDomListener(document.getElementById('save_data'), 'click', function() {
                             $('#saveModal').modal('show'); 
                            //  google.maps.event.trigger(newShape, 'click');
                         });
            google.maps.event.addListener(newShape, 'click', function() {
              setSelection(newShape, isNotMarker);
              
            });
            
           
            setSelection(newShape, isNotMarker);
          //~ }// end if
        });

        // Clear the current selection when the drawing mode is changed, or when the
        // map is clicked.
        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
        google.maps.event.addListener(map, 'click', clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

        buildColorPalette();

        
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
        //
        var DelPlcButDiv = document.createElement('div');
        //~ DelPlcButDiv.style.color = 'rgb(25,25,25)'; // no effect?
        DelPlcButDiv.style.backgroundColor = '#fff';
        DelPlcButDiv.style.cursor = 'pointer';
        DelPlcButDiv.innerHTML = 'DEL';
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(DelPlcButDiv);
        google.maps.event.addDomListener(DelPlcButDiv, 'click', deletePlacesSearchResults);


         var options = {
                // types: ['(cities)'],
                // componentRestrictions: {country: "jp"}
            };


        // Create the search address
            var input = document.getElementById('pac-input1');

        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
          searchBox = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(searchBox, 'place_changed', function() {
                var place = searchBox.getPlace();
                lat_current = place.geometry.location.lat();
                lng_current = place.geometry.location.lng();

                var center = {
                    lat: lat_current,
                    lng: lng_current
                };

                map.setCenter(center);

            });

          

        // Bias the SearchBox results towards places that are within the bounds of the
        // current map's viewport.
        google.maps.event.addListener(map, 'bounds_changed', function() {
          var bounds = map.getBounds();
          searchBox.setBounds(bounds);
          curposdiv.innerHTML = "<b>curpos</b> Z: " + map.getZoom() + " C: " + map.getCenter().toUrlValue();
        }); //////////////////////
      }



      google.maps.event.addDomListener(window, 'load', initialize);
      
      
        
          
         $("#submit_form").click(function(){
            $('#saveModal').modal('hide');
            var zone = $("#zone").val();
            var type = $("#type").val();
            var style = $("#style").val();
            var bounds = $("#bounds").val();
            var paths = $("#paths").val();
            var center = $("#center").val();
            var radius = $("#radius").val();
            // Returns successful data submission message when the entered information is stored in database.
            var dataString = 'zone='+ zone + '&type='+ type + '&style='+ style + '&bounds='+ bounds + '&paths='+ paths + '&center='+ center + '&radius='+ radius;
            if(zone=='')
            {
            alert("Please fill the zone name.");
            }
            else
            {
            // AJAX Code To Submit Form.
            $.ajax({
            type: "POST",
            url: "insert_info.php",
            data: dataString,
            cache: false,
            success: function(result){
            
            alert(result);
            }
            });
            }
            return false;
            });
      
      
    });
      
    </script>
        
  </body>
</html>