<?php
require_once 'config_file.php';

$manchesterPOIs = \TwinCities\getPlacesByCityId(2);
$barcelonaPOIs  = \TwinCities\getPlacesByCityId(1);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Twin Cities Maps</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Google Fonts: Playfair Display + DM Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<!-- Tailwind config: custom colours and fonts -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          manchester: { DEFAULT: '#C8102E', light: '#fde8ec' },
          barcelona:  { DEFAULT: '#004D98', light: '#e0eaf8' },
          cream: '#faf8f4',
          ink:   '#1a1a2e',
        },
        fontFamily: {
          display: ['"Playfair Display"', 'serif'],
          body:    ['"DM Sans"', 'sans-serif'],
        },
      }
    }
  }
</script>
  <style>
    body { font-family: 'DM Sans', sans-serif; }
    h1,h2,h3 { font-family: 'Playfair Display', serif; }
     
    .map-box {
     height: 420px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }


    @media (min-width: 768px) {
      .map-box { height: 420px; }
    }
    @media (min-width: 1024px) {
      .map-box { height: 480px; }
    }
  </style>
</head>

  <body class="bg-blue-950">
  <div class="max-w-5xl mx-auto px-4">
  
  
    <div class="bg-slate-800 w-full border-2 border-blue-600 rounded-xl p-6 md:p-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
  <div>
    <p class="text-xs font-mono tracking-widest uppercase text-blue-300 mb-2">
      <i class="fa-solid fa-earth-europe mr-1"></i> City Guide
    </p>
    <h1 class="font-mono font-extrabold text-[28px] md:text-[40px] text-white leading-tight">
      Twin Cities<br>
      <span class="text-blue-300">Explorer</span>
    </h1>
    <p class="mt-3 text-blue-100 text-sm max-w-md">
      Discover the best places of interest across Manchester and Barcelona. Click any marker to explore.
    </p>
  </div>

  <div class="flex flex-row md:flex-col gap-3">
      <a href="manchester.php" class="block">
    <div class="bg-blue-800 border border-blue-600 rounded-xl px-4 py-3 flex items-center gap-3">
      <span class="text-2xl">🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
      <div>
        <p class="text-xs text-blue-300 uppercase tracking-widest font-mono">Manchester</p>
        <p class="font-mono font-bold text-white text-lg"><?php echo count($manchesterPOIs); ?> <span class="text-sm font-normal">locations</span></p>
      </div>
    </div>
    </a>
    <a href="barcelona.php" class="block">
    <div class="bg-blue-800 border border-blue-600 rounded-xl px-4 py-3 flex items-center gap-3">
      <span class="text-2xl">🇪🇸</span>
      <div>
        <p class="text-xs text-blue-300 uppercase tracking-widest font-mono">Barcelona</p>
        <p class="font-mono font-bold text-white text-lg"><?php echo count($barcelonaPOIs); ?> <span class="text-sm font-normal">locations</span></p>
      </div>
    </div>
    </a>
  </div>
</div>


<!-- Manchester Card -->
<div class="bg-slate-800 border-2 border-blue-600 rounded-xl mt-6 overflow-hidden">
  <div class="flex items-center justify-between px-4 py-3 border-b border-blue-700">
    <div class="flex items-center gap-2">
      <i class="fa-solid fa-location-dot text-white text-[15px]"></i>
      <h2 class="font-mono font-extrabold text-[15px] md:text-[20px] text-white">Manchester</h2>
    </div>
    <span class="text-xs text-blue-300 font-mono uppercase tracking-widest hidden md:block">
      Manchester, England
    </span>
  </div>
  <div class="p-4">
    <div id="manchesterMap" class="map-box"></div>
    <p class="text-xs text-blue-400 mt-2 flex items-center gap-1">
      <i class="fa-regular fa-circle-question"></i>
      Hover over a marker for a preview &bull; Click to view full details
    </p>
  </div>
</div>  <!--Manchester card closes here-->

<!-- Barcelona Card -->
<div class="bg-slate-800 border-2 border-blue-600 rounded-xl mt-6 overflow-hidden">
  <div class="flex items-center justify-between px-4 py-3 border-b border-blue-700">
    <div class="flex items-center gap-2">
      <i class="fa-solid fa-location-dot text-white text-[15px]"></i>
      <h2 class="font-mono font-extrabold text-[15px] md:text-[20px] text-white">Barcelona</h2>
    </div>
    <span class="text-xs text-blue-300 font-mono uppercase tracking-widest hidden md:block">
      Catalonia, Spain
    </span>
  </div>
  <div class="p-4">
    <div id="barcelonaMap" class="map-box"></div>
    <p class="text-xs text-blue-400 mt-2 flex items-center gap-1">
      <i class="fa-regular fa-circle-question"></i>
      Hover over a marker for a preview &bull; Click to view full details
    </p>
  </div>
</div>  <!-- Barcelona card closes here -->

<!-- Weather Button -->
<div class="flex justify-center my-6">
  <a href="weather.php" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-mono font-bold px-6 py-3 rounded-lg transition-colors duration-200">
    <i class="fa-solid fa-cloud-sun"></i>
    View Weather for Both Cities
  </a>
</div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Convert PHP arrays into JavaScript
  const manchesterPOIs = <?php echo json_encode($manchesterPOIs); ?>;
  const barcelonaPOIs = <?php echo json_encode($barcelonaPOIs); ?>;
  // Custom Tailwind-style markers

const manchesterIcon = L.divIcon({
  html: `
    <div class="w-5 h-5 bg-red-600 rotate-[-45deg] 
    rounded-[50%_50%_50%_0%] border-2 border-white shadow-md"></div>
  `,
  className: "",
  iconSize: [20, 20],
  iconAnchor: [10, 20]
});

const barcelonaIcon = L.divIcon({
  html: `
    <div class="w-5 h-5 bg-blue-600 rotate-[-45deg] 
    rounded-[50%_50%_50%_0%] border-2 border-white shadow-md"></div>
  `,
  className: "",
  iconSize: [20, 20],
  iconAnchor: [10, 20]
});

  // Manchester map
  const manchesterMap = L.map("manchesterMap").setView([53.4794892, -2.2451148], 12);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(manchesterMap);

  // Add Manchester markers from database
  manchesterPOIs.forEach(function(poi) {
    const marker = L.marker([poi.latitude, poi.longitude], { icon: manchesterIcon }).addTo(manchesterMap);
    

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
      window.location.href = "frontdetails.php?place_id=" + poi.place_id;
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
    const marker = L.marker([poi.latitude, poi.longitude], { icon: barcelonaIcon }).addTo(barcelonaMap);

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
      window.location.href = "frontdetails.php?place_id=" + poi.place_id;
    });
  });
  </script>

</body>
</html>