<?php
header("Content-Type: application/rss+xml; charset=UTF-8");
require_once 'config_file.php';

$places = \TwinCities\getAllPlacesWithCity();

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0">
  <channel>
    <title>Twin Cities Places of Interest</title>
    <link>http://localhost/twin_cities/map-3.php</link>
    <description>Latest places of interest from Manchester and Barcelona</description>
    <language>en-gb</language>

    <?php foreach ($places as $row) : ?>
      <item>
        <title><?php echo htmlspecialchars($row['place_name'] . " - " . $row['city_name']); ?></title>
        <link><?php echo htmlspecialchars($row['website_url']); ?></link>
        <description><?php echo htmlspecialchars($row['description']); ?></description>
        <guid><?php echo htmlspecialchars("place-" . $row['place_id']); ?></guid>
      </item>
    <?php endforeach; ?>

  </channel>
</rss>