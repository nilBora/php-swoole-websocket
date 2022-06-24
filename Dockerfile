FROM brdnlsrg/baseimage:php8.0-full-dev as backend

# install swoole
#TIP: it always get last stable version of swoole coroutine.
RUN export SWOOLE_VERSION=4.5.9 && cd /tmp && \
    curl -o /tmp/swoole.tgz https://pecl.php.net/get/swoole-4.5.9.tgz && \
    tar zxvf swoole.tgz && \
    cd swoole-${SWOOLE_VERSION} && \
    phpize  && \
    ./configure \
    --enable-coroutine \
    --enable-http2  \
    --enable-coroutine-postgresql \
    --enable-async-redis && \
    make && make install && \
    docker-php-ext-enable swoole && \
    echo "swoole.fast_serialize=On" >> /usr/local/etc/php/conf.d/docker-php-ext-swoole-serialize.ini && \
    rm -rf /tmp/*

WORKDIR /app
ENTRYPOINT ["/app/server"]

#RUN chmod +x /app/entrypoint.sh
#ENTRYPOINT ["/app/entrypoint.sh"]
