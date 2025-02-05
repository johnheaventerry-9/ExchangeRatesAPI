Currency Exchange Rate API
Overview
This project is a PHP API built using the Laravel framework for ingesting and managing currency exchange rate data. The API integrates with an external currency exchange service to automatically update exchange rates, store them in a database, and provide endpoints for querying historical data. Additional features include CSV report generation and email notifications.

Features
Currency Management: Adds a currency to the database if it doesn't exist.
Daily Exchange Rates: Automatically updates exchange rates for USD against at least ten other currencies every day.
Job Queues: Uses job queues for database-writing operations.
Historical Data Endpoint: Provides an endpoint to retrieve exchange rates for a specific date.
Unit Tests: Includes tests with code coverage.
CSV Report: Generates a daily CSV report of exchange rates and sends it via email.
Email Notifications: Utilizes Laravel Mailer to trigger email notifications.


Setup
Prerequisites
PHP >= 8.0
Composer
MySQL or another compatible database
Laravel 11.x


Installation
Clone the Repository


git clone https://github.com/johnheaventerry-9/ExchangeRatesAPI.git
Navigate to the Project Directory

cd ExchangeRatesAPI
Install Dependencies

composer install
Create the Environment File

Copy the .env.example file to .env:
cp .env.example .env
Generate the Application Key

php artisan key:generate
Configure the Database

Edit the .env file to configure your database connection:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scaffold
DB_USERNAME=root
DB_PASSWORD=
Configure Mail Settings

Edit the .env file with your mail server settings:


// YOU WILL NEED TO go to mailer and create your own. and input them here. 
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=c5ef4bfa2a853d
MAIL_PASSWORD=583e491256f4bf
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"
Run Migrations



php artisan migrate
Set Up Job Queue

Ensure your queue worker is running. Start a worker with:


php artisan queue:work
Schedule Tasks

The fetchAndStoreRates method in the ExchangeRateService class is scheduled to run daily. Ensure that the Laravel scheduler is set up correctly. You can run the scheduler with:



php artisan schedule:run
For production environments, you should set up a cron job that runs every minute to trigger Laravel's task scheduler.

Endpoints
Fetch Exchange Rates by Date

URL: /api/exchange-rates/{date}
Method: GET
URL Params:
date: The date for which to fetch exchange rates (format: YYYY-MM-DD).
Response: JSON array of exchange rates.
Testing
Run Unit Tests



php artisan test
Ensure you have set up a testing database or configured the .env.testing file as needed.

Usage
Fetch and Store Exchange Rates

The fetchAndStoreRates method in the ExchangeRateService class is scheduled to run daily. Ensure that the Laravel scheduler is configured to trigger this method.

Check Job Queue

Monitor the job queue to ensure jobs are processed correctly:


php artisan queue:work
Additional Information
Automatic Data Updates: The fetchAndStoreRates method updates exchange rates daily and dispatches jobs to store the data.
CSV Report Generation: A daily CSV report of exchange rates is generated and sent via email. This is triggered by the exchange-rates:send-report command.



Please check over my .env for a better setup idea. 

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:yhmQWBtJFRTYUlqDuj3zEPGDQ7WCdlguWJZ9Pervl4c=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scaffold
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=c5ef4bfa2a853d
MAIL_PASSWORD=583e491256f4bf
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

EXCHANGE_RATES_API_URL=http://api.exchangeratesapi.io/v1/latest
EXCHANGE_RATES_API_KEY=8821a8b8456efe92aadbcfa56e491620
EXCHANGE_RATES_API_SYMBOLS=USD,EUR,AUD,CAD,GBP,JPY,CHF,CNY,INR,MXN,ZAR
