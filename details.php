<?php
$conn = new mysqli("localhost", "root", "", "twin_cities");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['place_id'])) {
    die("No place selected.");
}

$place_id = (int) $_GET['place_id'];

$query = "SELECT p.place_id, p.name, p.description, p.capacity, p.image_url, p.website_url,
                 c.name AS city_name
          FROM placeofinterests p
          JOIN cities c ON p.city_id = c.city_id
          WHERE p.place_id = $place_id";

$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("Place not found.");
}

$place = $result->fetch_assoc();
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($place['name']); ?> — Twin Cities Explorer</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
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

    .hero-bg {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }

    /* Image reveal animation */
    .place-image {
      transition: transform 0.4s ease;
    }
    .place-image:hover {
      transform: scale(1.02);
    }

    /* Fade in */
    .fade-in {
      opacity: 0;
      transform: translateY(16px);
      animation: fadeUp 0.5s ease forwards;
    }
    @keyframes fadeUp {
      to { opacity: 1; transform: translateY(0); }
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.22s; }
    .delay-3 { animation-delay: 0.34s; }
  </style>
</head>
<body class="bg-cream text-ink min-h-screen flex flex-col">

  <!-- ══ TOP NAV ══ -->
  <header class="hero-bg text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
      <a href="map.php" class="flex items-center gap-2 text-sm font-medium text-blue-200 hover:text-white transition group">
        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        <button>href="map-3.php"p->Back to maps</a></button>
      
      </a>
      <span class="font-display text-base sm:text-lg text-white">Twin Cities Explorer</span>
      <span class="text-xs text-blue-300 hidden sm:block">
        <i class="fa-solid fa-location-dot mr-1"></i>
        <?php echo htmlspecialchars($place['city_name']); ?>
      </span>
    </div>
  </header>

  <!-- ══ MAIN ══ -->
  <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12 w-full">

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

      <!-- ── Left: Image ── -->
      <div class="lg:col-span-3 fade-in">
        <div class="rounded-2xl overflow-hidden shadow-xl bg-gray-100 aspect-video w-full">
          <img
            src="<?php echo htmlspecialchars($place['image_url']); ?>"
            alt="<?php echo htmlspecialchars($place['name']); ?>"
            class="place-image w-full h-full object-cover"
            onerror="this.src='https://placehold.co/800x450/e0e0e0/999?text=No+Image'"
          >
        </div>
      </div>

      <!-- ── Right: Details ── -->
      <div class="lg:col-span-2 flex flex-col gap-5">

        <!-- City badge -->
        <div class="fade-in delay-1">
          <span class="inline-flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full">
            <i class="fa-solid fa-location-dot"></i>
            <?php echo htmlspecialchars($place['city_name']); ?>
          </span>
        </div>

        <!-- Title -->
        <div class="fade-in delay-1">
          <h1 class="text-3xl sm:text-4xl font-display font-bold leading-tight text-ink">
            <?php echo htmlspecialchars($place['name']); ?>
          </h1>
        </div>

        <!-- Description -->
        <div class="fade-in delay-2">
          <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
            <?php echo htmlspecialchars($place['description']); ?>
          </p>
        </div>

        <!-- Stats row -->
        <div class="fade-in delay-2 grid grid-cols-2 gap-3">
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-col gap-1">
            <span class="text-xs uppercase tracking-widest text-gray-400 font-medium">
              <i class="fa-solid fa-users mr-1 text-blue-400"></i>Capacity
            </span>
            <span class="text-lg font-display font-semibold text-ink">
              <?php echo htmlspecialchars($place['capacity']) ?: '—'; ?>
            </span>
          </div>
          <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-col gap-1">
            <span class="text-xs uppercase tracking-widest text-gray-400 font-medium">
              <i class="fa-solid fa-city mr-1 text-blue-400"></i>City
            </span>
            <span class="text-lg font-display font-semibold text-ink">
              <?php echo htmlspecialchars($place['city_name']); ?>
            </span>
          </div>
        </div>

        <!-- Website CTA -->
        <div class="fade-in delay-3 mt-auto">
          <a
            href="<?php echo htmlspecialchars($place['website_url']); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center justify-center gap-2 w-full bg-ink text-white font-medium text-sm px-5 py-3.5 rounded-xl hover:bg-opacity-80 transition shadow-md hover:shadow-lg"
          >
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            Visit Official Website
          </a>

          <a
            href="map.php"
            class="flex items-center justify-center gap-2 w-full mt-3 border border-gray-200 text-gray-500 font-medium text-sm px-5 py-3 rounded-xl hover:bg-gray-50 transition"
          >
            <i class="fa-solid fa-map"></i>
            Back to Map
          </a>
        </div>

      </div>
    </div>

  </main>

  <!-- ══ FOOTER ══ -->
  <footer class="hero-bg text-white mt-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-blue-200">
      <p class="font-display text-base text-white">Twin Cities Explorer</p>
      <p class="text-xs">
        <i class="fa-solid fa-map mr-1"></i> Map data &copy;
        <a href="https://www.openstreetmap.org/copyright" class="underline hover:text-white transition">OpenStreetMap</a> contributors
      </p>
    </div>
  </footer>
  <a class="back-link" href="map-3.php">← Back to maps</a>

</body>
</html>