#!/usr/bin/env bash

#git pull
docker-compose build
docker-compose down
docker-compose up -d
docker-compose exec php-fpm bash ./deploy_app.sh
