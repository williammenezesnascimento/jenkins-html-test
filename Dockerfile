FROM php:8.2-apache

RUN apt-get update && apt-get install -y wget

COPY . /var/www/html/

EXPOSE 80