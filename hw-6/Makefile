LOCALHOST_PROJECT_DIR := $(shell pwd)
PROJECT_NAME := hw-6
COMPOSE_FILE := ./docker-compose.yml
# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
# cnf ?= $(LOCALHOST_PROJECT_DIR)/deploy/config.env
# include $(cnf)

# export $(shell sed 's/=.*//' $(cnf))

.DEFAULT_GOAL := help
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)
	@echo $(PROJECT_NAME)

.PHONY: echo-project-dir

print:## print
	@printenv

.PHONY: print

up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev print-compose-file

php-exec: CMD?=-r 'phpinfo();'
php-exec: ## Run any php command in our container
	docker exec -it ${PROJECT_NAME} sh

.PHONY: php-exec

some-cmd:
	docker run \
	-it \
	--network some-network \
	--rm \
	mongo mongo \
	--host some-mongo \
	test

ps:
	docker-compose ps

build:
	docker-compose build

restart:
	docker-compose restart

events:
	docker-compose events

up:
	docker-compose up

cmpsr: 
	docker run --name project-php55 composer require $(package)





