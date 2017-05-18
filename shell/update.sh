#!/bin/bash


if [ -z "$1" ]; then
    echo "BASE PATH NEEDED";
else
    cd $1;
    /usr/bin/git fetch --all
    /usr/bin/git reset --hard origin/master
    ##database if doesn't exists create	it##
    if [ ! -e "storage/database.sqlite" ]; then
        touch "storage/database.sqlite";
    fi;
    if [ ! -s  "storage/database.sqlite" ]; then
        /usr/bin/php artisan  migrate:install
        /usr/bin/php artisan  migrate:refresh -n --force

    fi;
    /usr/bin/php ./artisan --force migrate
    /usr/bin/php ./artisan optimize
    /usr/bin/php ./artisan queue:restart
fi;
