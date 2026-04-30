<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "twin_cities");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Manchester POIs
$manchesterQuery = "SELECT place_id, name, latitude, longitude, description, capacity, image_url, website_url
FROM placeofinterests
WHERE city_id = 2";
$manchesterResult = $conn->query($manchesterQuery);

$manchesterPOIs = [];
while ($row = $manchesterResult->fetch_assoc()) {
    $manchesterPOIs[] = $row;
}

// Fetch Barcelona POIs
$barcelonaQuery = "SELECT place_id, name, latitude, longitude, description, capacity, image_url, website_url
FROM placeofinterests
WHERE city_id = 1";
$barcelonaResult = $conn->query($barcelonaQuery);

$barcelonaPOIs = [];
while ($row = $barcelonaResult->fetch_assoc()) {
    $barcelonaPOIs[] = $row;
}

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Twin Cities Explorer</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Google Fonts: Playfair Display + DM Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            manchester: {
              DEFAULT: '#C8102E',  /* Man City red — actually Man United red for flair */
              light: '#fde8ec',
              dark: '#8b0b20',
            },
            barcelona: {
              DEFAULT: '#004D98',
              light: '#e0eaf8',
              dark: '#003670',
            },
            cream: '#faf8f4',
            ink: '#1a1a2e',
          },
          fontFamily: {
            display: ['"Playfair Display"', 'serif'],
            body: ['"DM Sans"', 'sans-serif'],
          },
        }
      }
    }
  </script>

  <style>
    body { font-family: 'DM Sans', sans-serif; }
    h1, h2, h3 { font-family: 'Playfair Display', serif; }

    /* Hero gradient background */
    .hero-bg {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }

    /* Map containers */
    .map-container {
      height: 420px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }

    @media (min-width: 768px) {
      .map-container { height: 480px; }
    }

    /* City card hover effect */
    .city-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .city-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 48px rgba(0,0,0,0.12);
    }

    /* Leaflet popup custom style */
    .leaflet-popup-content-wrapper {
      border-radius: 10px !important;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2) !important;
    }
    .leaflet-popup-content {
      margin: 12px 16px !important;
      font-family: 'DM Sans', sans-serif !important;
      font-size: 14px !important;
      line-height: 1.5 !important;
    }

    /* Stat badge */
    .stat-badge {
      background: rgba(255,255,255,0.12);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.2);
    }

    /* Scroll fade-in animation */
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.6s ease forwards;
    }
    @keyframes fadeUp {
      to { opacity: 1; transform: translateY(0); }
    }
    .delay-1 { animation-delay: 0.15s; }
    .delay-2 { animation-delay: 0.3s; }
  </style>
</head>
<body class="bg-cream text-ink">

  <!-- ═══════════════════════ HEADER / HERO ═══════════════════════ -->
  <header class="hero-bg text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

        <!-- Title block -->
        <div class="fade-in">
          <p class="text-xs font-medium tracking-[0.25em] uppercase text-blue-300 mb-2">
            <i class="fa-solid fa-earth-europe mr-1"></i> City Guide
          </p>
          <h1 class="text-4xl sm:text-5xl font-display font-bold leading-tight">
            Twin Cities<br>
            <span class="text-blue-300">Explorer</span>
          </h1>
          <p class="mt-3 text-blue-100 text-sm sm:text-base max-w-md font-light">
            Discover the best places of interest across Manchester and Barcelona — click any marker to explore.
          </p>
        </div>

        <!-- City stat badges -->
        <div class="flex flex-row sm:flex-col gap-3 fade-in delay-1">
          <div class="stat-badge rounded-xl px-4 py-3 flex items-center gap-3">
            <span class="text-2xl">🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
            <div>
              <p class="text-xs text-blue-200 uppercase tracking-widest">Manchester</p>
              <p class="font-display font-semibold text-lg"><?php echo count($manchesterPOIs); ?> <span class="text-sm font-body font-normal">locations</span></p>
            </div>
          </div>
          <div class="stat-badge rounded-xl px-4 py-3 flex items-center gap-3">
            <span class="text-2xl">🇪🇸</span>
            <div>
              <p class="text-xs text-blue-200 uppercase tracking-widest">Barcelona</p>
              <p class="font-display font-semibold text-lg"><?php echo count($barcelonaPOIs); ?> <span class="text-sm font-body font-normal">locations</span></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </header>

  <!-- ═══════════════════════ MAIN CONTENT ═══════════════════════ -->
  <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-14">

    <!-- ─── Manchester Section ─── -->
    <section class="city-card bg-white rounded-2xl overflow-hidden shadow-md fade-in">
      <!-- Section header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 pt-6 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-manchester-light text-manchester">
            <i class="fa-solid fa-location-dot text-lg"></i>
          </span>
          <div>
            <h2 class="text-2xl font-display text-ink">Manchester</h2>
            <p class="text-xs text-gray-400 font-light">Greater Manchester, England</p>
          </div>
        </div>
        <span class="inline-flex items-center gap-2 text-sm text-manchester bg-manchester-light px-3 py-1 rounded-full font-medium self-start sm:self-auto">
          <i class="fa-solid fa-map-pin text-xs"></i>
          <?php echo count($manchesterPOIs); ?> Points of Interest
        </span>
      </div>

      <!-- Map -->
      <div class="p-4 sm:p-6">
        <div id="manchesterMap" class="map-container w-full"></div>
        <p class="mt-3 text-xs text-gray-400 flex items-center gap-1">
          <i class="fa-regular fa-circle-question"></i>
          Hover over a marker for a preview &bull; Click to view full details
        </p>
      </div>
    </section>

    <!-- ─── Barcelona Section ─── -->
    <section class="city-card bg-white rounded-2xl overflow-hidden shadow-md fade-in delay-1">
      <!-- Section header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 pt-6 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-barcelona-light text-barcelona">
            <i class="fa-solid fa-location-dot text-lg"></i>
          </span>
          <div>
            <h2 class="text-2xl font-display text-ink">Barcelona</h2>
            <p class="text-xs text-gray-400 font-light">Catalonia, Spain</p>
          </div>
        </div>
        <span class="inline-flex items-center gap-2 text-sm text-barcelona bg-barcelona-light px-3 py-1 rounded-full font-medium self-start sm:self-auto">
          <i class="fa-solid fa-map-pin text-xs"></i>
          <?php echo count($barcelonaPOIs); ?> Points of Interest
        </span>
      </div>

      <!-- Map -->
      <div class="p-4 sm:p-6">
        <div id="barcelonaMap" class="map-container w-full"></div>
        <p class="mt-3 text-xs text-gray-400 flex items-center gap-1">
          <i class="fa-regular fa-circle-question"></i>
          Hover over a marker for a preview &bull; Click to view full details
        </p>
      </div>
    </section>

  </main>

  <!-- ═══════════════════════ FOOTER ═══════════════════════ -->
  <footer class="hero-bg text-white mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-blue-200">
      <p class="font-display text-lg text-white">Twin Cities Explorer</p>
      <p class="text-xs">
        <i class="fa-solid fa-map mr-1"></i> Map data &copy; <a href="https://www.openstreetmap.org/copyright" class="underline hover:text-white transition">OpenStreetMap</a> contributors
      </p>
    </div>
  </footer>

  <!-- ═══════════════════════ SCRIPTS ═══════════════════════ -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    const manchesterPOIs = <?php echo json_encode($manchesterPOIs); ?>;
    const barcelonaPOIs  = <?php echo json_encode($barcelonaPOIs); ?>;

    // ── Custom marker icon factory ──
    function createIcon(color) {
      return L.divIcon({
        className: '',
        html: `<div style="
          width: 28px; height: 28px;
          background: ${color};
          border: 3px solid white;
          border-radius: 50% 50% 50% 0;
          transform: rotate(-45deg);
          box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        "></div>`,
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -32],
      });
    }

    const manchesterIcon = createIcon('#C8102E');
    const barcelonaIcon  = createIcon('#004D98');

    // ── Manchester Map ──
    const manchesterMap = L.map("manchesterMap").setView([53.4794892, -2.2451148], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(manchesterMap);

    manchesterPOIs.forEach(function(poi) {
      const marker = L.marker([poi.latitude, poi.longitude], { icon: manchesterIcon }).addTo(manchesterMap);

      marker.bindTooltip(
        `<strong style="font-family:'Playfair Display',serif;font-size:14px;">${poi.name}</strong>
         <br><span style="color:#666;font-size:12px;">${poi.description}</span>`,
        { direction: "top", offset: [0, -30], opacity: 1 }
      );

      marker.on("click", function() {
        window.location.href = "details.php?place_id=" + poi.place_id;
      });
    });

    // ── Barcelona Map ──
    const barcelonaMap = L.map("barcelonaMap").setView([41.3825802, 2.177073], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(barcelonaMap);

    barcelonaPOIs.forEach(function(poi) {
      const marker = L.marker([poi.latitude, poi.longitude], { icon: barcelonaIcon }).addTo(barcelonaMap);

      marker.bindTooltip(
        `<strong style="font-family:'Playfair Display',serif;font-size:14px;">${poi.name}</strong>
         <br><span style="color:#666;font-size:12px;">${poi.description}</span>`,
        { direction: "top", offset: [0, -30], opacity: 1 }
      );

      marker.on("click", function() {
        window.location.href = "details.php?place_id=" + poi.place_id;
      });
    });
  </script>

</body>
</html>