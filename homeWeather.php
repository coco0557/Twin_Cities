<?php

require_once 'config_file.php';

use function TwinCities\getWeatherForCity;
use function TwinCities\weatherCodeToText;

$manchesterWeather = getWeatherForCity(2);
$barcelonaWeather = getWeatherForCity(1);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Twin Cities Weather</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .city-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Twin Cities Weather</h1>

<?php
function displayWeather($cityName, $weatherData) {
    if (!$weatherData) {
        echo "<div class='city-box'><h2>$cityName</h2><p>Weather data could not be loaded.</p></div>";
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

<a class="back-link" href="homeMap.php">← Back to maps</a>

</body>
</html>