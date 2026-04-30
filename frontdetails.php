<?php
require_once 'config_file.php';

if (!isset($_GET['place_id'])) {
    die("No place selected.");
}

$place_id = (int) $_GET['place_id'];
$place = \TwinCities\getPlaceById($place_id);

if ($place === null) {
    die("Place not found.");
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($place['name']); ?></title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <!-- Tailwind config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            manchester: { DEFAULT: '#C8102E', light: '#fde8ec' },
            barcelona:  { DEFAULT: '#004D98', light: '#e0eaf8' },
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
  </style>
</head>
<body class="bg-blue-950 text-white">
    <div class="max-w-5xl mx-auto px-4 py-8">

    </div>
    <div class="bg-slate-800 w-full border-2 border-blue-600 rounded-xl p-6 md:p-10 mb-6">
  <p class="text-xs font-mono tracking-widest uppercase text-blue-300 mb-2">
    <i class="fa-solid fa-location-dot mr-1"></i> Place Details
  </p>
  <h1 class="font-mono font-extrabold text-[28px] md:text-[40px] text-white leading-tight">
    <?php echo htmlspecialchars($place['name']); ?>
  </h1>
  <p class="mt-3 text-blue-100 text-sm max-w-2xl">
    Explore key information about this place of interest.
  </p>
</div>
<div class="bg-slate-800 border-2 border-blue-600 rounded-xl overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

    <!-- Image section -->
    <div class="p-4 md:p-6">
      <img 
        src="<?php echo htmlspecialchars($place['image_url']); ?>" 
        alt="<?php echo htmlspecialchars($place['name']); ?>"
        class="w-full h-full object-cover rounded-xl shadow-lg"
      >
    </div>

    <!-- Text section -->
    <div class="p-6 md:p-8 flex flex-col justify-between">
      <div>
        <div class="mb-4">
          <p class="text-xs text-blue-300 uppercase tracking-widest font-mono mb-1">City</p>
          <p class="text-lg text-white"><?php echo htmlspecialchars($place['city_name']); ?></p>
        </div>

        <div class="mb-4">
          <p class="text-xs text-blue-300 uppercase tracking-widest font-mono mb-1">Description</p>
          <p class="text-blue-100 leading-relaxed"><?php echo htmlspecialchars($place['description']); ?></p>
        </div>

        <div class="mb-6">
          <p class="text-xs text-blue-300 uppercase tracking-widest font-mono mb-1">Capacity</p>
          <p class="text-white"><?php echo htmlspecialchars($place['capacity']); ?></p>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-3">
        <a 
          href="<?php echo htmlspecialchars($place['website_url']); ?>" 
          target="_blank"
          class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-mono font-bold px-5 py-3 rounded-lg transition-colors duration-200"
        >
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
          Visit Website
        </a>

        <a 
          href="map-3.php"
          class="inline-flex items-center justify-center gap-2 bg-slate-700 hover:bg-slate-600 text-white font-mono font-bold px-5 py-3 rounded-lg transition-colors duration-200"
        >
          <i class="fa-solid fa-arrow-left"></i>
          Back to Maps
        </a>
      </div>
    </div>

  </div>
</div>
</body>
</html>