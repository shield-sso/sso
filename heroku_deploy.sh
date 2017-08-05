#!/usr/bin/env bash

cd resources/keys

openssl genrsa -out private.key 1024
openssl rsa -in private.key -pubout -out public.key
