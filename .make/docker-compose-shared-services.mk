ifeq ($(OS),Windows_NT)
    CWD := $(lastword $(dir $(realpath $(MAKEFILE_LIST)/../)))
else
    CWD := $(abspath $(patsubst %/,%,$(dir $(abspath $(lastword $(MAKEFILE_LIST))))/../))/
endif

shared-service-up:
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml up -d

shared-service-erase:
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml stop
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml down -v --remove-orphans

shared-service-stop:
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml stop

shared-service-logs:
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml logs -f

shared-service-setup-db:
	docker-compose --project-directory $(CWD)/ -f $(CWD)/docker-compose-shared-services.yml exec postgres bash -c "if PGPASSWORD=postgres_pass psql -U postgres_user -w -lqtA | cut -d \| -f 1 | grep $(POSTGRESQL_DB); then echo DB $(NEW_DB_NAME) already exists; else PGPASSWORD=postgres_pass createdb -U postgres_user -w $(POSTGRESQL_DB); fi"


