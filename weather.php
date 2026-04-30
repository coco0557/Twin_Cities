<?php
function getWeather($lat, $lon) {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&current=temperature_2m,weather_code&daily=weather_code,temperature_2m_max,temperature_2m_min&forecast_days=3&timezone=auto";

    $response = file_get_contents($url);

    if ($response === false) {
        return null;
    }

    return json_decode($response, true);
}

function weatherCodeToText($code) {
    if ($code == 0) {
        return "Sunny";
    } elseif ($code >= 1 && $code <= 3) {
        return "Cloudy";
    } elseif ($code == 45 || $code == 48) {
        return "Foggy";
    } elseif (($code >= 51 && $code <= 67) || ($code >= 80 && $code <= 82)) {
        return "Rainy";
    } elseif ($code >= 71 && $code <= 77) {
        return "Snowy";
    } elseif ($code >= 95 && $code <= 99) {
        return "Stormy";
    } else {
        return "Unknown";
    }
}

$manchesterWeather = getWeather(53.4808, -2.2426);
$barcelonaWeather = getWeather(41.3874, 2.1686);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Twin Cities Weather</title>

  <!-- Tailwind CSS -->
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
    h1, h2, h3 { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body class="bg-blue-950 text-white">

<div class="max-w-5xl mx-auto px-4 py-8">

  <div class="bg-slate-800 w-full border-2 border-blue-600 rounded-xl p-6 md:p-10 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div>
      <p class="text-xs font-mono tracking-widest uppercase text-blue-300 mb-2">
        <i class="fa-solid fa-cloud-sun mr-1"></i> Weather Overview
      </p>
      <h1 class="font-mono font-extrabold text-[28px] md:text-[40px] text-white leading-tight">
        Twin Cities<br>
        <span class="text-blue-300">Weather</span>
      </h1>
      <p class="mt-3 text-blue-100 text-sm max-w-2xl">
        Compare the current weather and short forecast for Manchester and Barcelona.
      </p>
    </div>

    <div class="flex flex-row md:flex-col gap-3">
      <div class="bg-slate-700 border border-red-700 rounded-xl px-4 py-3 flex items-center gap-3">
        <span class="text-2xl">🏴</span>
        <div>
          <p class="text-xs text-red-300 uppercase tracking-widest font-mono">Manchester</p>
          <p class="font-mono font-bold text-white text-lg">
            <?php echo $manchesterWeather ? htmlspecialchars($manchesterWeather['current']['temperature_2m']) . '°C' : 'N/A'; ?>
          </p>
        </div>
      </div>

      <div class="bg-slate-700 border border-blue-700 rounded-xl px-4 py-3 flex items-center gap-3">
        <span class="text-2xl">🇪🇸</span>
        <div>
          <p class="text-xs text-blue-300 uppercase tracking-widest font-mono">Barcelona</p>
          <p class="font-mono font-bold text-white text-lg">
            <?php echo $barcelonaWeather ? htmlspecialchars($barcelonaWeather['current']['temperature_2m']) . '°C' : 'N/A'; ?>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-6">

<?php
function displayWeather($cityName, $weatherData) {
    if (!$weatherData) {
        echo "<div class='bg-blue-900 border-2 border-blue-600 rounded-xl p-6 mb-6 text-white'>
                <h2 class='font-mono font-extrabold text-xl'>$cityName</h2>
                <p class='text-blue-300 mt-2'>Weather data could not be loaded.</p>
                </div>";
        return;
    }

    echo "<div class='city-box'>";
    echo "<h2>$cityName</h2>";
    echo "<p><strong>Current temperature:</strong> " . $weatherData['current']['temperature_2m'] . "°C</p>";
    echo "<p><strong>Condition:</strong> " . weatherCodeToText($weatherData['current']['weather_code']) . "</p>";

    echo "<h3>3-Day Forecast</h3>";
    echo "<table>";
    echo "<tr><th>Date</th><th>Weather</th><th>Max Temp</th><th>Min Temp</th></tr>";

    for ($i = 0; $i < 3; $i++) {
        echo "<tr>";
        echo "<td>" . $weatherData['daily']['time'][$i] . "</td>";
        echo "<td>" . weatherCodeToText($weatherData['daily']['weather_code'][$i]) . "</td>";
        echo "<td>" . $weatherData['daily']['temperature_2m_max'][$i] . "°C</td>";
        echo "<td>" . $weatherData['daily']['temperature_2m_min'][$i] . "°C</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}

displayWeather("Manchester", $manchesterWeather);
displayWeather("Barcelona", $barcelonaWeather);
?>

<a class="back-link" href="map-3.php">← Back to maps</a>

</body>
</html>