Amazon Price Tracker API
This is a Laravel-based API that monitors Amazon product prices and tracks price drops. The application fetches product details and prices from Amazon and sends notifications when there's a price change, enabling users to stay up-to-date with the best deals.

Features:
Price Tracking: Automatically checks the price of products listed on Amazon.

Price Alerts: Sends notifications to users when a product price drops.

API Integration: Seamlessly fetches data from Amazon product pages.

User Authentication: Allows users to create accounts and manage their price watchlist.

Admin Panel: Monitor tracked products and price drop alerts.

Tech Stack:
Backend: Laravel 10

Database: MySQL

API: RESTful API for interacting with front-end applications

Authentication: Laravel Passport for API Authentication

Getting Started:
Clone the repository.

Install dependencies with composer install.

Set up your .env file with your database and API credentials.

Run migrations: php artisan migrate.

Start the Laravel development server: php artisan serve.

