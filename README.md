# PHP app for Fixably assignment

This project is the backend part of [this react project](https://github.com/anakinsolo/fixably-assignment) 
## Intro
This project can be run with docker. There are 2 containers
- php:8.1-fpm
- nginx

## Before installing 
- (For Docker) Make sure you have docker engine and docker compose v2 installed on your local
- Have composer installed on your local
- PHP 8.1 installed on your local

## Installation
- Clone this repo
- (For Docker, otherwise skip this step) Run `docker compose up -d` to start the project
- Run `composer install` command to install dependencies
- Run php server `php -S 127.0.0.1:9002 -t`
- Open [http://127.0.0.1:9002](http://127.0.0.1:9002) to view it in your browser.

## Routes
### /statistics
This will get a list of statistics of the order by their statuses

### /iphones
This will get a list of iphone orders that have assigned technician

### /invoices
This will return the total invoices, total invoice amount for each unique week of November 2020, and the changes between them

### /new
This will redirect to a form, where you can create an order with a description. Or use sample request to create an order for a MacBook Pro with a broken screen