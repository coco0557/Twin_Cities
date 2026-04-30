<?php

require_once 'config_file.php';

use function TwinCities\getPlaceById;

if (!isset($_GET['place_id'])) {
    die("No place selected.");
}

$place_id = (int) $_GET['place_id'];
$place = getPlaceById($place_id);

if (!$place) {
    die("Place not found.");
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($place['name']); ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      max-width: 800px;
    }

    img {
      max-width: 100%;
      height: auto;
      margin-top: 15px;
      border: 1px solid #ccc;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<h1><?php echo htmlspecialchars($place['name']); ?></h1>

<p><strong>City:</strong> <?php echo htmlspecialchars($place['city_name']); ?></p>
<p><strong>Description:</strong> <?php echo htmlspecialchars($place['description']); ?></p>
<p><strong>Capacity:</strong> <?php echo htmlspecialchars($place['capacity']); ?></p>

<p>
  <strong>Website:</strong>
  <a href="<?php echo htmlspecialchars($place['website_url']); ?>" target="_blank">
    Visit official website
  </a>
</p>

<img src="<?php echo htmlspecialchars($place['image_url']); ?>" alt="<?php echo htmlspecialchars($place['name']); ?>">

<br>
<a class="back-link" href="homeMap.php">← Back to maps</a>

</body>
</html>