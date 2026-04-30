<?php

declare(strict_types=1);

namespace TwinCities;

use mysqli;
use mysqli_sql_exception;
use Throwable;

/*
Global settings
*/

date_default_timezone_set('Europe/London');

const APP_NAME = 'Twin Cities';
const BASE_URL = 'http://localhost/twin_cities/';

/*
Database settings
*/

const DB_HOST = 'localhost';
const DB_PORT = 3306;
const DB_NAME = 'your_database_name';
const DB_USER = 'your_database_username';
const DB_PASS = 'your_database_password';

/*
API / map settings
*/

const WEATHER_API_BASE = 'https://api.open-meteo.com/v1/forecast';
const MAP_TILE_URL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const MAP_ATTRIBUTION = '&copy; OpenStreetMap contributors';

/*
Routes
*/

const ROUTES = [
    'home'       => 'map-3.php',
    'details'    => 'frontdetails.php',
    'weather'    => 'weather.php',
    'manchester' => 'manchester.php',
    'barcelona'  => 'barcelona.php',
    'rss_feed'   => 'rss.php',
];

/*
City data
*/

const CITIES = [
    1 => [
        'id'        => 1,
        'name'      => 'Barcelona',
        'country'   => 'Spain',
        'latitude'  => 41.3825802,
        'longitude' => 2.177073,
        'slug'      => 'barcelona',
        'zoom'      => 12,
    ],
    2 => [
        'id'        => 2,
        'name'      => 'Manchester',
        'country'   => 'United Kingdom',
        'latitude'  => 53.4794892,
        'longitude' => -2.2451148,
        'slug'      => 'manchester',
        'zoom'      => 12,
    ],
];

// All functions remain identical — only the DB constants above need updating
// Copy this file to config_file.php and fill in your local database credentials
