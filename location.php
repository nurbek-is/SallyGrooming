<?php
require 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../styles/styles.css">
<title>Location</title>
<style>
    #map{
     height:800px;
     width:100%; 
    }
    h4 {
        color:black;
    }
</style>

</head>
<body>
<main id='main-canvas'>
  <h1><?='Welcome to ' . $pageTitle?></h1> 
  <h2>Here our location  </h2>
  <p>Hours of Operation Monday-Saturday 8 am-8pm.  We have 3 branches in Seattle area, here is our addresses below</p>
<div id="map">Map</div>
<script type='text/javascript'>
function initMap() {
    const options = {
      zoom: 13,
      center: { lat:47.6062, lng:-122.3321} 
    }
    //new map
  const map = new google.maps.Map(
    document.getElementById("map"),options);

    //add marker
//     const marker = new google.maps.Marker({
//         position:{lat:47.5526,lng:-122.3009},
//         map:map,
//         icon:"images/dog-paw-pointer.png"
//     });
//  const infoWindow = new google.maps.InfoWindow({
//      content:'<h4>Beacon Hill</h4>'
//  });

//  marker.addListener('click',function() {
//      infoWindow.open(map,marker);
//  });

addMarker({
    coords:{lat:47.5526,lng:-122.3009},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>Beacon Hill Branch</h4>'
});

addMarker({
    coords:{lat:47.6323,lng:-122.3569},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>Queen Anne Branch</h4>'
});

addMarker({
    coords:{lat:47.5667,lng:-122.3868},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>West Seattle Branch</h4>'
});

//add markert function 
function addMarker (props) {
    const marker = new google.maps.Marker({
        position:props.coords,
        map:map,
        icon:props.iconImage
    });
    if(props.content) {
    const infoWindow = new google.maps.InfoWindow({
     content:props.content
 });
 marker.addListener('click',function() {
     infoWindow.open(map,marker);
 });

}
    // if(props.iconImage) {
    //     marker.setIcon(props.iconImage)
    // }
//check content

 }
}
</script>
<script async -kapi key code skipped for privacy
       
    </script>
</main>
</body>



<?php
require 'includes/footer.php';
?>