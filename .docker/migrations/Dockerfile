ARG CI_COMMIT_REF_SLUG=master
ARG CI_SERVER_HOST
ARG CI_PROJECT_PATH
ARG PHP_VER
ARG DOCKER_REGISTRY_PORT

FROM ${CI_SERVER_HOST}${DOCKER_REGISTRY_PORT}/$CI_PROJECT_PATH/php${PHP_VER}-composer:$CI_COMMIT_REF_SLUG AS composer
# These ARGs should be after FROM or they will be empty
ARG COMPOSER_INSTALL_CMD

WORKDIR /app
COPY . /app

RUN bash -c "echo COMPOSER_INSTALL_CMD: ${COMPOSER_INSTALL_CMD}"
RUN bash -c "${COMPOSER_INSTALL_CMD}"

FROM ${CI_SERVER_HOST}${DOCKER_REGISTRY_PORT}/$CI_PROJECT_PATH/php${PHP_VER}-cli:$CI_COMMIT_REF_SLUG

COPY --from=composer /app /app

WORKDIR /app

RUN chmod +x /app/.docker/migrations/entrypoint.sh
ENTRYPOINT ["/app/.docker/migrations/entrypoint.sh"]

STOPSIGNAL SIGINT
CMD ["/app/bin/console", "d:m:m", "-n"]
