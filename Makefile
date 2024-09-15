# Makefile
include .env

.PHONY: up down build restart logs bash migrate

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

restart:
	docker-compose down
	docker-compose up -d

logs:
	docker-compose logs -f

bash:
	docker exec -it my-api-app /bin/bash

migrate:
	docker exec -it my-api-app php yii migrate --interactive=0
update:
	docker exec -it my-api-app composer update