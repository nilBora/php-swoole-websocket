FROM brdnlsrg/baseimage:php8.0-full-dev as backend

# kafka
RUN apk add --no-cache librdkafka-dev
RUN git clone https://github.com/arnaud-lb/php-rdkafka.git && \
    cd php-rdkafka && \
    phpize && \
    ./configure && \
    make all -j 5 && \
    make install && \
    docker-php-ext-enable rdkafka

WORKDIR /app