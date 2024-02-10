# Achievements

 [![GitHub license](https://img.shields.io/github/license/gothinkster/laravel-realworld-example-app.svg)](http://opensource.org/licenses/mit-license.php)

> ### Laravel backend codebase for an app that allows users unlock achievements.


----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

This is the easiest way to get PHP and all it's dependencies on your system
- Download WAMP or XAMPP to manage APACHE, MYSQL and PhpMyAdmin. This also installs PHP by default. You can follow [this ](https://youtu.be/h6DEDm7C37A)tutorial

- Download and install [composer ](https://getcomposer.org/)globally on your system


Clone the repository

    git clone https://github.com/tosinibrahim96/ipp-backend-developer-test.git

Switch to the repo folder

    cd ipp-backend-developer-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/tosinibrahim96/ipp-backend-developer-test.git
    cd ipp-backend-developer-test
    composer install
    cp .env.example .env
    php artisan key:generate

## Environment variables

- `.env` - Environment variables can be set in this file

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve OR php artisan serve --port={PORT_NUMBER} (setting a PORT manually)

## Database seeding

**Populate the database with seed data.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    

----------

# Testing API

Run the laravel development server

    php artisan serve
    php artisan serve --port={PORT_NUMBER} (setting a PORT manually)

The api can now be accessed at

    http://localhost:{PORT_NUMBER}

To run all tests, please run 

    php artisan test

# License
- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2023 © <a href="https://www.linkedin.com/in/ibrahim-alausa/" target="_blank">Ibrahim Alausa</a>.
