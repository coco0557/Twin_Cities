<?php
require_once 'config_file.php';

$pois = \TwinCities\getPlacesByCityId(2);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manchester Explorer</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            manchester: { DEFAULT: '#C8102E', light: '#fde8ec' },
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
    h1,h2,h3 { font-family: 'Playfair Display', serif; }

    .map-box {
      height: 420px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }

    @media (min-width: 1024px) {
      .map-box { height: 650px; }
    }
  </style>
</head>

<body class="bg-blue-950 text-white">
  <div class="max-w-7xl mx-auto px-4 py-6">

    <div class="bg-slate-800 w-full border-2 border-red-700 rounded-xl p-6 md:p-10 mb-6">
      <p class="text-xs font-mono tracking-widest uppercase text-red-300 mb-2">
        <i class="fa-solid fa-location-dot mr-1"></i> City Guide
      </p>
      <h1 class="font-mono font-extrabold text-[28px] md:text-[40px] text-white leading-tight">
        Manchester<br>
        <span class="text-red-400">Explorer</span>
      </h1>
      <p class="mt-3 text-blue-100 text-sm max-w-2xl">
        Discover places of interest across Manchester. Click a marker or a place in the list to view more details.
      </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

      <div class="xl:col-span-2">
        <div class="bg-slate-800 border-2 border-red-700 rounded-xl p-4">
          <div id="manchesterMap" class="map-box"></div>
        </div>
      </div>

      <div class="xl:col-span-1">
        <div class="bg-slate-800 border-2 border-red-700 rounded-xl p-4 h-full">
          <div class="flex items-center justify-between mb-4">
            <h2 class="font-mono font-bold text-xl text-white">
              <i class="fa-solid fa-list mr-2 text-red-400"></i>Places of Interest
            </h2>
            <span class="text-sm text-red-300 font-mono"><?php echo count($pois); ?> total</span>
          </div>

          <div class="space-y-3 max-h-[650px] overflow-y-auto pr-1">
            <?php foreach ($pois as $poi): ?>
              <a href="frontdetails.php?place_id=<?php echo $poi['place_id']; ?>"
                 class="block bg-slate-700 hover:bg-slate-600 border border-slate-600 rounded-lg p-4 transition duration-200">
                <h3 class="font-mono font-bold text-xl text-white"><?php echo htmlspecialchars($poi['name']); ?></h3>
                <p class="font-mono text-sm text-blue-200 mt-1 line-clamp-3">
                  <?php echo htmlspecialchars($poi['description']); ?>
                </p>
                <?php if (!empty($poi['capacity'])): ?>
                  <p class="text-xs text-red-300 mt-2 font-mono">
                    Capacity: <?php echo htmlspecialchars($poi['capacity']); ?>
                  </p>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div>

    <div class="flex justify-center mt-6">
      <a href="map-3.php" class="flex items-center gap-2 bg-red-700 hover:bg-red-600 text-white font-mono font-bold px-6 py-3 rounded-lg transition-colors duration-200">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Twin Cities Map
      </a>
    </div>

  </div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    const pois = <?php echo json_encode($pois); ?>;

    const manchesterIcon = L.divIcon({
      html: `
        <div class="w-5 h-5 bg-red-600 rotate-[-45deg] rounded-[50%_50%_50%_0%] border-2 border-white shadow-md"></div>
      `,
      className: "",
      iconSize: [20, 20],
      iconAnchor: [10, 20]
    });

    const manchesterMap = L.map("manchesterMap").setView([53.4794892, -2.2451148], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: "&copy; OpenStreetMap contributors"
    }).addTo(manchesterMap);

    pois.forEach(function(poi) {
      const marker = L.marker([poi.latitude, poi.longitude], { icon: manchesterIcon }).addTo(manchesterMap);

      marker.bindTooltip(
        "<b>" + poi.name + "</b><br>" + poi.description,
        {
          direction: "top",
          offset: [0, -10],
          opacity: 0.95
        }
      );

      marker.on("click", function() {
        window.location.href = "frontdetails.php?place_id=" + poi.place_id;
      });
    });
  </script>
</body>
</html>