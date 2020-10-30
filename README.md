## About

This project was created using Laravel version 8.x

## requirements

PHP >= 7.3
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP Extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension

## Setup
I'd advice to set up a vagrant box with the laravel homestead, details in how to set it up can be found here: https://laravel.com/docs/8.x/homestead

## Configuration
within the project folder create .env file
    cp .env.example .env

You will also need to generate an application key
    php artisan key:generate
    
The project uses a simple pre-seeded SQLite database, the database file is under the /database folder, in the .env file the sqlite driver and *full path* to the database file will need to be configured, as follows:

DB_CONNECTION=sqlite
DB_HOST=
DB_PORT=
DB_DATABASE=<full-path-to-the-database-folder>/database.sqlite
DB_USERNAME=root
DB_PASSWORD=

# Tests

Tests can be found under the /tests folder, to run them simply type:
    phpunit

# available endpoints
* GET /api/hello-world 
* GET /api/artists
* GET /api/artists/{id}
* POST /api/artists
* PUT /api/artists/{id}
* DELETE /api/artists/{id}
* GET /api/albums
* GET /api/albums/{id}
* POST /api/albums
* PUT /api/albums/{id}
* DELETE /api/albums/{id}

# Demo
a live demo of this project can be found at: http://music6api-env.eba-2mpgacqb.us-east-1.elasticbeanstalk.com/api/hello-world 

note:
If you are using postman to try it up, remember to set up the X-Requested-With: XMLHttpRequest header to correctly fetch the validation errors that the application returns.
