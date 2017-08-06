#!/usr/bin/env bash

if ! [ -e ./resources/keys/private.key ]
then
    openssl genrsa -out ./resources/keys/private.key 1024
fi

if ! [ -e ./resources/keys/public.key ]
then
    openssl rsa -in ./resources/keys/private.key -pubout -out ./resources/keys/public.key
fi

if ! [ -e ./resources/config/parameters.yml ]
then
    cp ./resources/config/parameters.dist ./resources/config/parameters.yml
fi

php ./bin/console.php migrations:migrate -n
