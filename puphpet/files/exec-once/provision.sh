#!/usr/bin/env bash

cd /var/www/resources/keys

if ! [ -e private.key ]
then
    openssl genrsa -out private.key 1024
fi

if ! [ -e public.key ]
then
    openssl rsa -in private.key -pubout -out public.key
fi

cd /var/www/resources/config

if ! [ -e parameters.yml ]
then
    cp parameters.dist parameters.yml
fi

cd /var/www

./bin/console.php migrations:migrate -n
