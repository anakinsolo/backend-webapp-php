# PHP app for Fixably assignment

This project is the backend part of [this react project](https://github.com/anakinsolo/fixably-assignment) 
## Intro
This project can be run with docker. There are 2 containers
- php:8.1-fpm
- nginx

Or this project can be run with php server
- PHP 8.1

## Before installing 
- (For Docker) Make sure you have docker engine and docker compose v2 installed on your local
- Have composer installed on your local
- PHP 8.1 installed on your local

## Installation
- Clone this repo
- Make a copy of `.env.example` to `.env`. Put the access code to the `API_CODE`
- Choose either docker or non docker

### For docker
- Run `docker compose up -d`
- Run `docker compose exect php composer install` to install dependencies
- Run `docker inspect <web_container_name>` and write down the IP address of the <web_container_name>
- Access the site using the IP address above

### For non docker
- Run `composer install`
- Run php server `php -S 127.0.0.1:9002 -t`
- Open [http://127.0.0.1:9002](http://127.0.0.1:9002) to view it in your browser.

## Routes
### /statistics
This will get a list of statistics of the order by their statuses

### /iphones
This will get a list of iphone orders that have assigned technician

### /invoices
This will return the total invoices, total invoice amount for each unique week of November 2020, and the changes between them

### /
Homepage, this contains a form to create new order with a description for defect