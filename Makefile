DEFAULT_GOAL := docker-test

DOCKER_CONTAINER=php-fpm
DOCKER_COMPOSE=docker-compose --env-file .env -f docker-compose.yml
DOCKER_EXEC_WITH_USER=$(DOCKER_COMPOSE) exec -T $(DOCKER_CONTAINER) sh -c

ifeq ($(OS), Windows_NT)
	ANSI=--no-ansi
else
	ANSI=--ansi
	USER_ID=$(shell id -u)
	GROUP_ID=$(shell id -g)
	DOCKER_EXEC_WITH_USER=$(DOCKER_COMPOSE) exec -T -u $(USER_ID):$(GROUP_ID) $(DOCKER_CONTAINER) sh -c
endif # IF OS

docker-start: ## to start the containers
	${MAKE} -i docker-stop
	CURRENT_USER=$(USER_ID):$(GROUP_ID) $(DOCKER_COMPOSE) up -d --remove-orphans
	$(DOCKER_COMPOSE) run --rm wait -c database:3306

vendor: composer.json $(wildcard composer.lock) ## to install the composer dependencies
	$(DOCKER_EXEC_WITH_USER) "composer install --no-interaction --prefer-dist --no-progress $(ANSI)"

docker-stop: ## stop and remove containers for testing only
	$(DOCKER_COMPOSE) down --remove-orphans
