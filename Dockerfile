FROM php:8.3-fpm

# set main params
ARG BUILD_ARGUMENT_ENV=dev
ENV ENV=$BUILD_ARGUMENT_ENV
ENV APP_HOME /var/www/html
ARG HOST_UID=1000
ARG HOST_GID=1000
ENV USERNAME=www-data
ARG INSIDE_DOCKER_CONTAINER=1
ENV INSIDE_DOCKER_CONTAINER=$INSIDE_DOCKER_CONTAINER
ARG XDEBUG_CONFIG=main
ENV XDEBUG_CONFIG=$XDEBUG_CONFIG
ARG XDEBUG_VERSION=3.3.2
ENV XDEBUG_VERSION=$XDEBUG_VERSION

# check environment
RUN if [ "$BUILD_ARGUMENT_ENV" = "default" ]; then echo "Set BUILD_ARGUMENT_ENV in docker build-args like --build-arg BUILD_ARGUMENT_ENV=dev" && exit 2; \
    elif [ "$BUILD_ARGUMENT_ENV" = "dev" ]; then echo "Building development environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "test" ]; then echo "Building test environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "staging" ]; then echo "Building staging environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "prod" ]; then echo "Building production environment."; \
    else echo "Set correct BUILD_ARGUMENT_ENV in docker build-args like --build-arg BUILD_ARGUMENT_ENV=dev. Available choices are dev,test,staging,prod." && exit 2; \
    fi

# install all the dependencies and enable PHP modules
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      libjpeg-dev libpng-dev libfreetype6-dev libicu-dev zlib1g-dev libxml2-dev libreadline-dev libxslt1-dev libzip-dev \
      libexif-dev \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      sudo \
      libzip-dev \
      wget \
      librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && yes '' | pecl install -o -f redis && docker-php-ext-enable redis \
    && docker-php-ext-install \
      pdo_mysql \
      sockets \
      intl \
      opcache \
      zip \
      xsl \
      exif \
    && docker-php-ext-install gd pdo_mysql sockets intl opcache zip \
    && pecl install amqp xlswriter \
    && docker-php-ext-enable amqp redis xlswriter \
    && docker-php-ext-enable amqp \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# create document root, fix permissions for www-data user and change owner to www-data
RUN mkdir -p $APP_HOME/public && \
    mkdir -p /home/$USERNAME && chown $USERNAME:$USERNAME /home/$USERNAME \
    && usermod -o -u $HOST_UID $USERNAME -d /home/$USERNAME \
    && groupmod -o -g $HOST_GID $USERNAME \
    && chown -R ${USERNAME}:${USERNAME} $APP_HOME

# put php config for Symfony
COPY ./docker/$BUILD_ARGUMENT_ENV/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/$BUILD_ARGUMENT_ENV/php.ini /usr/local/etc/php/php.ini

# install Xdebug in case dev/test environment
COPY ./docker/general/do_we_need_xdebug.sh /tmp/
COPY ./docker/dev/xdebug-${XDEBUG_CONFIG}.ini /tmp/xdebug.ini

RUN apt-get update && apt-get install -y dos2unix

RUN dos2unix /tmp/do_we_need_xdebug.sh && chmod u+x /tmp/do_we_need_xdebug.sh
RUN /bin/bash -x /tmp/do_we_need_xdebug.sh
# install security-checker in case dev/test environment
COPY ./docker/general/do_we_need_security-checker.sh /tmp/

RUN dos2unix /tmp/do_we_need_security-checker.sh && chmod u+x /tmp/do_we_need_security-checker.sh
RUN /bin/bash -x /tmp/do_we_need_security-checker.sh
# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Enable Composer autocompletion
RUN composer completion bash > /etc/bash_completion.d/composer

# add supervisor
RUN mkdir -p /var/log/supervisor
COPY --chown=root:root ./docker/general/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --chown=root:crontab ./docker/general/cron /var/spool/cron/crontabs/root
RUN chmod 0600 /var/spool/cron/crontabs/root

# set working directory
WORKDIR $APP_HOME

USER ${USERNAME}

# Add necessary stuff to bash autocomplete
RUN echo 'source /usr/share/bash-completion/bash_completion' >> /home/${USERNAME}/.bashrc \
    && echo 'alias console="/var/www/html/bin/console"' >> /home/${USERNAME}/.bashrc

# copy fish configs
COPY --chown=${USERNAME}:${USERNAME} ./docker/fish/completions/ /home/${USERNAME}/.config/fish/completions/
COPY --chown=${USERNAME}:${USERNAME} ./docker/fish/functions/ /home/${USERNAME}/.config/fish/functions/
COPY --chown=${USERNAME}:${USERNAME} ./docker/fish/config.fish /home/${USERNAME}/.config/fish/config.fish

# copy source files
COPY --chown=${USERNAME}:${USERNAME} . $APP_HOME/

# install all PHP dependencies
RUN if [ "$BUILD_ARGUMENT_ENV" = "dev" ] || [ "$BUILD_ARGUMENT_ENV" = "test" ]; then COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress; \
    else export APP_ENV=$BUILD_ARGUMENT_ENV && COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress --no-dev; \
    fi

# create cached config file .env.local.php in case staging/prod environment
RUN if [ "$BUILD_ARGUMENT_ENV" = "staging" ] || [ "$BUILD_ARGUMENT_ENV" = "prod" ]; then composer dump-env $BUILD_ARGUMENT_ENV; \
    fi

USER root
