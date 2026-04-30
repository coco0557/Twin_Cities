# Twin Cities – Database-Driven Web Application

A web application project comparing places of interest across Manchester 
and Barcelona. The application uses PHP, MySQL, JavaScript, Leaflet and Tailwind CSS 
to display dynamic city and place information, map-based views, weather information 
and database-driven content.

## Project Overview

The aim of the project was to create a dynamic web application that allows users to 
explore two cities and compare their places of interest. The application includes 
interactive map views, individual place pages, weather information and content 
retrieved from a relational database.

## Features

- Interactive map-based location views using Leaflet
- Individual place pages for Manchester and Barcelona
- Dynamic content loaded from a MySQL database
- Weather and 3-day forecast data using the Open-Meteo API
- RSS feed of all places of interest across both cities
- Responsive frontend built with Tailwind CSS
- Centralised database configuration to reduce duplicated PHP connection logic
- Prepared statements throughout to prevent SQL injection
- Relational database structure for cities, places of interest, photos, comments and categories

## Technologies Used

- PHP
- MySQL
- SQL
- JavaScript
- Tailwind CSS
- Leaflet
- phpMyAdmin
- Open-Meteo API (no API key required)

## Project Structure
twin_cities/
├── map-3.php              # Main landing page with both city maps
├── manchester.php         # Manchester explorer page
├── barcelona.php          # Barcelona explorer page
├── frontdetails.php       # Individual place detail page
├── weather.php            # Weather comparison page
├── rss.php                # RSS feed of all places
├── config_file.php        # Database config and data access functions (not committed)
├── config_file.example.php # Example config file — copy and rename to config_file.php
└── README.md

## Database Design

The project used a relational database structure with the following entities:

- **Cities** — stores city information including name, country and coordinates
- **PlaceOfInterest** — stores place details linked to a city
- **Photos** — images associated with places
- **Comments** — user comments on places
- **Categories** — types of place (e.g. museum, park, landmark)
- **PlaceCategory** — junction table handling the many-to-many relationship between places and categories

## Setup

1. Clone the repository
```bash
git clone https://github.com/coco0557/Twin_Cities.git
```

2. Import the database schema into phpMyAdmin or MySQL:
```bash
mysql -u root -p twin_cities < twin_cities.sql
```

3. Copy the example config file and update with your local database credentials:
```bash
cp config_file.example.php config_file.php
```

4. Open `config_file.php` and update the following constants:
```php
const DB_NAME = 'twin_cities';
const DB_USER = 'your_username';
const DB_PASS = 'your_password';
```

5. Run on a local PHP server using XAMPP or MAMP and navigate to: http://localhost/twin_cities/map-3.php

## Development Highlights

- Built application from database design through to frontend implementation
- Designed and implemented a relational database schema with normalised structure 
  and a many-to-many junction table for place categories
- Architected a centralised `config_file.php` with namespaced functions handling all 
  data access, routing and error handling across the application
- Refactored all database calls to use prepared statements, eliminating SQL injection 
  vulnerabilities
- Integrated the Open-Meteo API for live weather and 3-day forecast data
- Built an RSS feed serving all places of interest across both cities
- Refactored the frontend using Tailwind CSS for a consistent, responsive interface 
  across all pages
- Presented and explained the technical implementation during a demo

## What I Learned

Through this project I strengthened my understanding of:

- Relational database design and normalisation
- PHP and MySQL integration using prepared statements
- Dynamic web page development with external API integration
- Frontend refactoring with Tailwind CSS
- Code maintainability through centralised configuration
- Namespacing and structured PHP architecture

## Note
`config_file.php` is excluded from this repository — use `config_file.example.php` 
as a template. Any sensitive configuration details have been removed from the 
public repository.
