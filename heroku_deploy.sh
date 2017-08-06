#!/usr/bin/env bash

./bin/console.php migrations:migrate -n

cd resources/keys

openssl genrsa -out private.key 1024
openssl rsa -in private.key -pubout -out public.key
