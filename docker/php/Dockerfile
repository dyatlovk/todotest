FROM debian:10-slim
WORKDIR "../"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get -y install curl gnupg apt-transport-https lsb-release ca-certificates wget \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' \
    && apt-get update

# nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_12.x | bash -

# yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Install selected extensions and other stuff
RUN apt-get update \
      && apt-get -y --no-install-recommends install \
      php7.4-mysql \
      php7.4-cli \
      php7.4-curl \
      php7.4-json \
      php7.4-mbstring \
      php7.4-opcache \
      php7.4-readline \
      php7.4-xml \
      php7.4-fpm \
      php7.4-zip \
      php7.4-gd \
      php7.4-intl \
      php7.4-zip \
      php7.4-dev \
      php7.4-redis \
      php7.4-fpm \
      php7.4-xdebug \
      nodejs \
      yarn \
      vim \
      make \
      sudo \
      git \
      p7zip \
      tzdata \
      supervisor \
      && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENV TZ="Europe/Kiev"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./supervisor/fpm.conf /etc/supervisor/conf.d/fpm.conf

RUN groupadd -g 1000 docker
RUN useradd -m -d /home/docker -s /bin/bash -u 1000 -g 1000 docker
RUN adduser docker www-data
RUN adduser docker sudo
RUN echo "docker ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/user

RUN echo xdebug.mode=debug >> /etc/php/7.4/fpm/conf.d/xdebug.ini \
    && echo xdebug.client_port=9000 >> /etc/php/7.4/fpm/conf.d/xdebug.ini \
    && echo xdebug.client_host=192.168.88.252 >> /etc/php/7.4/fpm/conf.d/xdebug.ini \
    && echo xdebug.start_with_request = yes >> /etc/php/7.4/fpm/conf.d/xdebug.ini

RUN echo xdebug.mode=coverage,debug >> /etc/php/7.4/cli/conf.d/xdebug.ini \
    && echo xdebug.client_port=9000 >> /etc/php/7.4/cli/conf.d/xdebug.ini \
    && echo xdebug.client_host=192.168.88.252 >> /etc/php/7.4/cli/conf.d/xdebug.ini

RUN chmod 00777 /run
USER docker
RUN mkdir -p /run/php
RUN mkdir -p /run/php-fpm
CMD sudo /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
