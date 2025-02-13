#!make
include .env

RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@:)


.DEFAULT_GOAL := help

-PHONY: help
help: ## muestra ayuda de comandos
	@awk 'BEGIN {FS = ":.*##"; printf "\n\033[1;34m${DOCKER_NAMESPACE}\033[0m\\nUsage:\n  make \033[1;34m<target>\033[0m\n\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[1;34m%-25s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
# ejecutar test de phpunit
.PHONY: run-tests
run-tests: ## ejecuta test de phpunit
	@docker exec -e XDEBUG_MODE=coverage ${APP_NAME}  vendor/bin/phpunit -d memory_limit=-1

.PHONY: run-infection
run-infection: ## ejecuta test de infection
	@docker exec -e XDEBUG_MODE=coverage ${APP_NAME} php -d memory_limit=-1 vendor/bin/infection

# analizar formato php PSR12
.PHONY: check-style
check-style: ## revisa formato PSR12 del proyecto
	@docker exec ${APP_NAME} vendor/bin/phpcs --standard=PSR12 src tests --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1

# corregir PSR12
.PHONY: fix-style
fix-style: ## corrige automaticamente varios puntos de PSR12.
	@docker exec ${APP_NAME} vendor/bin/phpcbf --standard=PSR12 src tests

# crear informe de metricas php
.PHONY: metrics
metrics: ## generador de metricas del proyecto
	@docker exec ${APP_NAME} vendor/bin/phpmetrics src --report-html=var/metrics

# admin de consola para dockers
.PHONY: docker-admin
docker-admin: ## consola para gestion de dockers
	@docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock lirantal/dockly

# comando git para ver los ficheros mas modificados de un proyecto
.PHONY: top-modified
top-modified: ## muestra los 10 archivos mas modificados del proyecto
	@git log --pretty=format: --name-only | sort | uniq -c | sort -rg | grep '.php' | head -10

.PHONY: init-database
init-database: ## inicializa la bbdd ejecutando las migraciones
	@docker exec -ti ${APP_NAME} bin/console doctrine:migrations:migrate

.PHONY: list
list:
	@LC_ALL=C $(MAKE) -pRrq -f $(lastword $(MAKEFILE_LIST)) : 2>/dev/null | awk -v RS= -F: '/^# File/,/^# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | egrep -v -e '^[^[:alnum:]]' -e '^$@$$'

create-order: ## ejecuta el comando de creacion de orders. ej:  make create-order userId=1 productId=1 amount=3
	@docker exec -ti ${APP_NAME} bin/console app:order:create $(userId) $(productId) $(amount)