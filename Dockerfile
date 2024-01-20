FROM byancode/doravel:php-8.2

ENV GIT_EMAIL='__GIT_EMAIL__' \
    GIT_NAME='__GIT_NAME__' \
    GIT_AUTO_PULL=false \
    # Laravel
    LARAVEL_AUTO_SCHEDULE=true \
    # PHP
    PHP_UPLOAD_MAX_FILESIZE=1G \
    PHP_MAX_EXECUTION_TIME=60 \
    PHP_OPCACHE_ENABLE=false \
    PHP_POST_MAX_SIZE=1G \
    PHP_MEMORY_LIMIT=512M \
    # NPM
    NPM_AUTO_INSTALL=false \
    NPM_AUTO_BUILD=false \
    # Env
    APP_ENV=local

COPY . /var/www