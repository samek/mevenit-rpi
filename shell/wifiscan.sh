#!/bin/bash


while [ 1 = 1 ]; do
    chmod 777 /var/www/storage/database.sqlite
    rm /var/www/storage/logs/*
    /var/www/artisan WifiNetworks:scan
    sleep 10;
done;


