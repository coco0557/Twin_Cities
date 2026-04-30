<?php

require_once 'config_file.php';

use function TwinCities\getPlacesByCityId;

$manchesterPOIs = getPlacesByCityId(2);
$barcelonaPOIs = getPlacesByCityId(1);

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Twin Cities Maps</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .map-box {
      height: 380px;
      border: 1px solid #ccc;
      margin-bottom: 30px;
    }
.weather-button {
  display: inline-block;
  padding: 10px 16px;
  background-color: #2f3640;
  color: #ffffff;
  text-decoration: none;
  border: 1px solid #1f252b;
  border-radius: 4px;
  font-family: Arial, sans-serif;
  font-size: 16px;
  font-weight: normal;
  margin-bottom: 20px;
}

.weather-button:hover {
  background-color: #3b434d;
}

.weather-button:hover {
  background-color: #3b434d;
}
  </style>
</head>
<body>

<h1>Twin Cities Maps</h1>

<h2>Manchester</h2>
<div id="manchesterMap" class="map-box"></div>

<h2>Barcelona</h2>
<div id="barcelonaMap" class="map-box"></div>

<p><a href="homeWeather.php" class="weather-button">View Weather for Both Cities</a></p>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Convert PHP arrays into JavaScript
  const manchesterPOIs = <?php echo json_encode($manchesterPOIs); ?>;
  const barcelonaPOIs = <?php echo json_encode($barcelonaPOIs); ?>;

  // Manchester map
  const manchesterMap = L.map("manchesterMap").setView([53.4794892, -2.2451148], 12);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(manchesterMap);

  // Add Manchester markers from database
  manchesterPOIs.forEach(function(poi) {
    const marker = L.marker([poi.latitude, poi.longitude]).addTo(manchesterMap);

    // Show info when hovering over marker
    marker.bindTooltip(
      "<b>" + poi.name + "</b><br>" + poi.description,
      {
        direction: "top",
        offset: [0, -10],
        opacity: 0.95
      }
    );

    // Go to details page when marker is clicked
    marker.on("click", function() {
      window.location.href = "homeDetails.php?place_id=" + poi.place_id;
    });
  });

  // Barcelona map
  const barcelonaMap = L.map("barcelonaMap").setView([41.3825802, 2.177073], 12);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(barcelonaMap);

  // Add Barcelona markers from database
  barcelonaPOIs.forEach(function(poi) {
    const marker = L.marker([poi.latitude, poi.longitude]).addTo(barcelonaMap);

    // Show info when hovering over marker
    marker.bindTooltip(
      "<b>" + poi.name + "</b><br>" + poi.description,
      {
        direction: "top",
        offset: [0, -10],
        opacity: 0.95
      }
    );

    // Go to details page when marker is clicked
    marker.on("click", function() {
      window.location.href = "homeDetails.php?place_id=" + poi.place_id;
    });
  });
  
</script>

</body>
</html>