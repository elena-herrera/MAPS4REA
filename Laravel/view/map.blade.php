<!DOCTYPE html>
<html lang="en">
<head>
  <link href="{{ asset('css/template/theme.css') }}" rel="stylesheet">
</head>
<body>
  <div id="map" class="div-map"></div>
    <div class="legend-map">
    <a href="https://www.escire.lat/"><strong>MAPS4REA</strong></a>
    <span>Licencia GPL-3.0</span>
    <p>© OpenStreetMap contributors</p>
  </div>

  <div id="popup" class="ol-popup">
      <a href="#" id="popup-closer" class="ol-popup-closer"></a>
      <div id="popup-content"></div>
  </div>
</body>
</html>
<script src="{{ asset('js/components/ol.js') }}"></script>               

<script>
    var attribution = new ol.control.Attribution({
      collapsible: false
    });
    var raster = new ol.layer.Tile({
      source: new ol.source.OSM()
    });
    
    var map = new ol.Map({
      layers: [raster],
      target: 'map',
      view: new ol.View({
        center: [0, 0],
        zoom: 2.5,
        })
    });

    var alldata = @json($allcoordinates);
    console.log(alldata);

  for(var i=0; i<alldata.length; i++){
    if(typeof alldata[i] !== 'string'){
      var layer = new ol.layer.Vector({
        source: new ol.source.Vector({
          features: [
              new ol.Feature({
                  geometry: new ol.geom.Point(ol.proj.fromLonLat(alldata[i]))
              })
              ]
          }),
          style: new ol.style.Style({
            image: new ol.style.Icon({
              anchor: [0.5, 46],
              anchorXUnits: 'fraction',
              anchorYUnits: 'pixels',
              src: "{{ asset('img/marker.png')}}"
            })
          })
      });
      map.addLayer(layer);

    }   
  }

</script>