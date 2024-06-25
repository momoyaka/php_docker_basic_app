#!/usr/bin/env bash
composer install
php src/observer.php
php-fpm -R