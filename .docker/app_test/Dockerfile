ARG CI_COMMIT_REF_SLUG=master
ARG CI_SERVER_HOST
ARG CI_PROJECT_PATH
ARG PHP_VER
ARG DOCKER_REGISTRY_PORT

FROM ${CI_SERVER_HOST}${DOCKER_REGISTRY_PORT}/$CI_PROJECT_PATH/php${PHP_VER}-composer:$CI_COMMIT_REF_SLUG
# These ARGs should be after FROM or they will be empty
ARG COMPOSER_INSTALL_CMD

RUN pecl install ast
RUN docker-php-ext-enable ast

WORKDIR /app
COPY . /app

RUN bash -c "echo COMPOSER_INSTALL_CMD: ${COMPOSER_INSTALL_CMD}"
RUN bash -c "${COMPOSER_INSTALL_CMD}"

CMD exec /bin/bash
