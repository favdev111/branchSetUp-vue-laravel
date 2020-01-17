var zipcodes = new Array();

$(document).ready(function(){
    $('#selectRadius').change(function(){
        updateMap($(this).val())
    });

    var radius = $('#selectRadius').val();
    if(radius)
        updateMap(radius);
  });

function getAddress() {
    let address = '';
    $(".address-row").each(function(){
        let $curRow = this;
        let type = $($curRow).find('[name="address_type[]"]').val();
        console.log(type);
        if(type === 'o' && !address) {
            address = $($curRow).find('input[name="address_county[]"]').val() +', '
                + $($curRow).find('input[name="address_city[]"]').val() +', '
                + $($curRow).find('input[name="address_1[]"]').val() +', '
                +$($curRow).find('input[name="address_2[]"]').val();
        }
    });

    return address;
}

function updateMap(radius) {
    var radius = (radius * 1.60934) ;
    let $curRow = $('.address-row.view')[0];

    let currentAddress = getAddress();
    console.log(currentAddress);
    document.getElementById("zip-list").innerHTML = "";
    initMap(currentAddress, radius);
}

function initMap(address, radius){

    var geocoder = new google.maps.Geocoder();
    //var address = "1600 Amphitheatre Parkway,Mountain View, CA";

    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            nearbyPlaces(latitude,longitude, radius);
        } 
    }); 
}

function nearbyPlaces(latitude,longitude, radius){
    var map;
    var service;
    var infowindow;
    console.log(latitude,longitude,radius);
    
    var newMap = new google.maps.LatLng(latitude,longitude);

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        center: newMap,
        zoom: 13
    });

    var circle = new google.maps.Circle({
        center: newMap,
        map: map,
        radius: 1000,          
        fillColor: '#FF6600',
        fillOpacity: 0.3,
        strokeColor: "#FFF",
        strokeWeight: 0         
    });

    var marker = new google.maps.Marker({
        position: newMap, 
        map: map,
    }); 

    var maxRows = 300;
    var username = "zipcodes19";
    
    fetch("http://api.geonames.org/findNearbyPostalCodesJSON?lat="+latitude+"&lng="+longitude+"&radius="+radius+"&maxRows="+maxRows+"&username="+username)
    .then(res => res.json())
    .then((data) => {
        for(var i=0;i<data['postalCodes'].length;i++){
            codeAddress(data['postalCodes'][i]['postalCode'], map);
            // sleep(600);
        }
    });

    //document.getElementById('iletisim').style.background = "";
    
}

function codeAddress(zipCode, map) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': zipCode}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            label: { color: '#00aaff', fontWeight: 'bold', fontSize: '25px', text: results[0]['address_components'][0]['long_name'] }
        });

        var circle = new google.maps.Circle({
            map: map,
            radius: 500,
            fillColor: '#AA0000'
        });
        circle.bindTo('center', marker, 'position');
        addToList(zipCode);
      } else {
        console.log("Geocode was not successful for the following reason: " + status);
      }
    });
  }

  function sleep(milliSeconds) {
    var startTime = new Date().getTime();
    while (new Date().getTime() < startTime + milliSeconds);
  }

//Add to list
function addToList(postal_code){
    var ul = document.querySelector("ul#zip-list");
    var li = document.createElement("li");
    var div = document.createElement("div");
    var inputBox = document.createElement('input');
    var label = document.createElement('label');
    
    var forAtt = document.createAttribute("for");     
    forAtt.value = "checkbox";                           
    label.setAttributeNode(forAtt);
    label.textContent = "ZipCode: " + postal_code;     

    var inAtt = document.createAttribute("type");
    inAtt.value = "checkbox";
    inputBox.setAttributeNode(inAtt);
    var inAttName = document.createAttribute("name");
    inAttName.value = "zipcode";
    inputBox.setAttributeNode(inAttName);
    var inAttVal = document.createAttribute("value");
    inAttVal.value = postal_code;
    inputBox.setAttributeNode(inAttVal);
    inputBox.checked = true;
    inputBox.className = 'zipcode-input';

    div.className = 'checkbox';
    div.appendChild(inputBox);
    div.appendChild(label);
    li.className = 'list-group-item';
    li.appendChild(div);
    ul.appendChild(li);
}

var button = document.getElementById("enter");
var input = document.getElementById("userinput");
var ul = document.querySelector("ul");

button.addEventListener("click", function() {
  console.log(input.value);
  var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': input.value}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {
        //Got result, center the map and put it out there
        addToList(input.value);
        var map = new google.maps.Map(document.getElementById("map_canvas"), {
            center: new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng()),
            zoom: 10,
            mapTypeId: 'roadmap'
        });
        map.setCenter(results[0].geometry.location);
        //console.log(results[0]['address_components'][0]['long_name'])
        var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            label: { color: '#00aaff', fontWeight: 'bold', fontSize: '25px', text: results[0]['address_components'][0]['long_name'] }
        });

        var circle = new google.maps.Circle({
            map: map,
            radius: 500,
            fillColor: '#AA0000'
        });
        circle.bindTo('center', marker, 'position');
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
})


var chkBtn = document.getElementById("chk-btn");

chkBtn.addEventListener("click", function(){
  console.log("fired");
  
  var zipCodesToStore = [];
  $.each($("input[name='zipcode']:checked"), function(){
    zipCodesToStore.push($(this).val());
  });
  alert("Zipcodes Selected: "+ zipCodesToStore.join(", "));
})