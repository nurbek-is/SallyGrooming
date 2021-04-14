<?php
require 'includes/header.php';
$pageTitle= 'Location,Map Page';
?>
<style>
    #map{
     height:800px;
     width:100%; 
    }
    h4,p {
        color:black;
    }
</style>

</head>
<body>
<main class='main-canvas-DarkTeal'>
  <h1><?='Welcome to our Locations'?></h1> 
  <h2>Click below to see our 3 locations in Greater Seattle Area </h2>
  <p class='white-text-color'>Hours of Operation Monday-Saturday 8 am-8pm.  We have 3 branches in Seattle area, Click at our addresses in map pin to get exact info!</p>
<div id="map">Map</div>
<script type='text/javascript'>
function initMap() {
    const options = {
      zoom: 12,
      center: { lat:47.6062, lng:-122.3321} 
    }
    //new map
  const map = new google.maps.Map(
    document.getElementById("map"),options);

    const markers = [
        {
    coords:{lat:47.5526,lng:-122.3009},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>Sandy\'s Grooming -Beacon Hill Branch</h4>'+
    '<p>2821 Beacon Ave S #5813, Seattle, WA 98144</p>'+
    "<a href='#'>206-432-5498</a>"+'<p> Mon-Sat, 11 am -7pm</p>'
}, {
    coords:{lat:47.6323,lng:-122.3569},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>Sandy\'s Grooming -Queen Anne Branch</h4>'+
    '<p>400 W Garfield St, Seattle, WA 98119</p>' +
    "<a href='#'>206-432-5498</a>"+'<p> Mon-Fri, 8 am -7pm</p>'
}, {
    coords:{lat:47.5667,lng:-122.3868},
    iconImage:"images/dog-paw-pointer.png",
    content:'<h4>Sandy\'s Grooming -West Seattle Branch</h4>'+
    '<p>4545 Fauntleroy Way SW, Seattle, WA 98116</p>' +
    "<a href='#'>206-432-5498</a>"+'<p> Mon-Fri, 10 am -7pm</p>'
}
    ];
    // loop through markers 
for (let i=0;i<markers.length;i++) {
    //add markers
    addMarker(markers[i]);
}

//add marker function 
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
 }
}
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe5w5WIodeiizv3hZJU9RF3EG5uXjeM7k&callback=initMap">
    </script>
</main>
</body>

<?php
require 'includes/footer.php';
?>