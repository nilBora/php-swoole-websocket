$(shell (if [ ! -e .env ]; then cp default.env .env; fi))
include .env
export

RUN_ARGS = $(filter-out $@,$(MAKECMDGOALS))

include .make/utils.mk
include .make/docker-compose-shared-services.mk
include .make/composer.mk
include .make/static-analysis.mk

.PHONY: install
install: erase build start-all wait shared-service-setup-db setup## clean current environment, recreate dependencies and spin up again

.PHONY: install-lite
install-lite: build start

.PHONY: start
start: ##up-services ## spin up environment
	docker-compose up -d

.PHONY: stop
stop: ## stop environment
	docker-compose stop

.PHONY: start services
start-services: shared-service-up ## up shared services

.PHONY: stop services
stop-services: shared-service-stop ## stop shared services

.PHONY: start-all
start-all: start start-services ## start full project environment

.PHONY: stop-all
stop-all: stop stop-services ## stop full project environment

.PHONY: remove
remove: ## remove project docker containers
	docker-compose rm -v -f

.PHONY: erase
erase: stop-all remove shared-service-erase docker-remove-volumes ## stop and delete containers, clean volumes

.PHONY: build
build: ## build environment and initialize composer and project dependencies
	docker build .docker/php$(PHP_VER)-cli/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-cli:master --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker build .docker/php$(PHP_VER)-composer/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-composer:master ${DOCKER_BUILD_ARGS} --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker build .docker/php$(PHP_VER)-dev/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-dev:master ${DOCKER_BUILD_ARGS} --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker-compose build --pull
	make composer-install

.PHONY: generate-ssl
generate-ssl:
	docker-compose run --rm php sh -lc 'mkdir -p ./var/jwt'
	docker-compose run --rm php sh -lc 'openssl genrsa -out var/jwt/private.pem -aes256 4096'
	docker-compose run --rm php sh -lc 'openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem'

.PHONY: composer-preload
composer-preload: ## Generate preload config file
	docker-compose run --rm --no-deps php sh -lc 'composer preload'

.PHONY: setup
setup: setup-enqueue setup-db ## build environment and initialize composer and project dependencies

.PHONY: setup-db
setup-db: ## recreate database
	docker-compose run --rm php sh -lc './bin/console d:d:d --force --if-exists'
	docker-compose run --rm php sh -lc './bin/console d:d:c'
	docker-compose run --rm php sh -lc './bin/console d:m:m -n'

.PHONY: setup-enqueue
setup-enqueue: ## setup enqueue
	docker-compose run --rm php sh -lc './bin/console enqueue:setup-broker -c task'
	docker-compose run --rm php sh -lc './bin/console enqueue:setup-broker -c queueevent'
	docker-compose run --rm php sh -lc './bin/console enqueue:setup-broker -c taskevent'

.PHONY: clear-events
clear-events: ## setup enqueue
	docker-compose run --rm php sh -lc './bin/console cleaner:clear db'

.PHONY: schema-validate
schema-validate: ## validate database schema
	docker-compose run --rm php sh -lc './bin/console d:s:v'

.PHONY: migration-generate
migration-generate: ## generate new database migration
	docker-compose run --rm php sh -lc './bin/console d:m:g'

.PHONY: migration-migrate
migration-migrate: ## run database migration
	docker-compose run --rm php sh -lc './bin/console d:m:m'

.PHONY: php-shell
php-shell: ## PHP shell
	docker-compose run --rm php sh -l

.PHONY: php-test
php-test: ## PHP shell without deps
	docker-compose run --rm --no-deps php sh -l

.PHONY: clean
clean: ## Clear build vendor report folders
	rm -rf build/ vendor/ var/

.PHONY: test static-analysis coding-standards tests-unit tests-integration composer-validate
test: install static-analysis coding-standards tests-unit tests-integration composer-validate stop ## Run all test suites
